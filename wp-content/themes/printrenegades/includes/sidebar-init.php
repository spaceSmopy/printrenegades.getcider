<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function printrenegades_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Main Sidebar', 'printrenegades' ),
			'id'            => 'main-sidebar',
			'description'   => __( 'Add widgets here to appear in your footer.', 'printrenegades' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Sidebar 1', 'printrenegades' ),
			'id'            => 'footer-sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'printrenegades' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Sidebar 2', 'printrenegades' ),
			'id'            => 'footer-sidebar-2',
			'description'   => __( 'Add widgets here to appear in your footer.', 'printrenegades' ),
			'before_widget' => '<div id="%1$s" class="widget footer-services %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)

	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Sidebar 3', 'printrenegades' ),
			'id'            => 'footer-sidebar-3',
			'description'   => __( 'Add widgets here to appear in your footer.', 'printrenegades' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'printrenegades' ),
			'id'            => 'blog-sidebar',
			'description'   => __( 'Add widgets here to appear in your sidebar on blog.', 'printrenegades' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5>',
			'after_title'   => '</h5>',
		)
	);

}

add_action( 'widgets_init', 'printrenegades_widgets_init' );
