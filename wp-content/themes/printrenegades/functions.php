<?php
/**
 * Theme functions and definitions
 *
 * @package PrintrenegadesElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'PRINTRENEGADES_VERSION', '2.2.0' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

get_template_part('includes/theme-supports');
get_template_part('includes/theme-scripts');
get_template_part('includes/sidebar-init');
get_template_part('includes/customizer');
get_template_part('includes/extras');
get_template_part('includes/template', 'tags');

if ( ! function_exists( 'printrenegades_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function printrenegades_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'printrenegades_theme_register_elementor_locations', [ true ], '2.0', 'printrenegades_elementor_register_elementor_locations' );
		if ( apply_filters( 'printrenegades_elementor_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'printrenegades_elementor_register_elementor_locations' );

if ( ! function_exists( 'printrenegades_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function printrenegades_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'printrenegades_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'printrenegades_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

if ( ! function_exists( 'printrenegades_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function printrenegades_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = \Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'printrenegades_elementor_page_title', 'printrenegades_elementor_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'printrenegades_elementor_body_open' ) ) {
	function printrenegades_elementor_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}