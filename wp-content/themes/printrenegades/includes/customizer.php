<?php

function printrenegades_customizer_setting($wp_customize) {
    $wp_customize->add_setting('printrenegades_breadcrumbs_background');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'printrenegades_breadcrumbs_background', array(
        'label' => 'Breadcrumbs Background',
        'section' => 'title_tagline',
        'settings' => 'printrenegades_breadcrumbs_background',
        'priority' => 10
    )));
}

add_action('customize_register', 'printrenegades_customizer_setting');

function get_breadcrumbs_background_style(){
    return !empty(get_theme_mod('printrenegades_breadcrumbs_background')) ?
    printf('style="background-image: url(%s)"', get_theme_mod('printrenegades_breadcrumbs_background')) : '';
}
