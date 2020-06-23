<?php

if (!function_exists('printrenegades_elementor_scripts_styles')) {
    /**
     * Theme Scripts & Styles.
     *
     * @return void
     */
    function printrenegades_elementor_scripts_styles()
    {
        $enqueue_basic_style = apply_filters_deprecated('printrenegades_theme_enqueue_style', [true], '2.0', 'printrenegades_elementor_enqueue_style');
        $min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style(
            'bootstrap',
            get_template_directory_uri() . '/assets/css/bootstrap' . $min_suffix . '.css',
            [],
            PRINTRENEGADES_VERSION
        );

        wp_enqueue_style(
            'magnific-popup',
            get_template_directory_uri() . '/assets/css/magnific-popup.css',
            [],
            PRINTRENEGADES_VERSION
        );

        if (apply_filters('printrenegades_elementor_enqueue_style', $enqueue_basic_style)) {
            wp_enqueue_style(
                'printrenegades',
                get_template_directory_uri() . '/style' . $min_suffix . '.css',
                [],
                PRINTRENEGADES_VERSION
            );
        }

        if (apply_filters('printrenegades_elementor_enqueue_theme_style', true)) {
            wp_enqueue_style(
                'printrenegades-theme-style',
                get_template_directory_uri() . '/theme' . $min_suffix . '.css',
                [],
                PRINTRENEGADES_VERSION
            );
        }

        wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), PRINTRENEGADES_VERSION, true);
        wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup'  . $min_suffix . '.js', array('jquery'), PRINTRENEGADES_VERSION, true);


    }
}
add_action('wp_enqueue_scripts', 'printrenegades_elementor_scripts_styles');


