<?php
/**
 * The template for displaying header.
 *
 * @package PrintrenegadesElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$site_name = get_bloginfo( 'name' );
?>

<div class="header-cont">
	<header class="site-header" role="banner">

		<div class="site-branding">
			
			<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} 
			?>

			<div class='details'>
				<a href="<?php echo esc_url( home_url( '/' )); ?>" class='title'>
					<?php bloginfo('name'); ?>
				</a>
				<a href="tel:2135365233" class='tel'>213.536.5233</a>
			</div>
		</div>

		<?php if ( has_nav_menu( 'primary_menu' ) ) : ?>
			<nav class="site-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary_menu' ) ); ?>
			</nav>
		<?php endif; ?>

		<div class="mobile-handler">
			<span></span>
			<span></span>
			<span></span>
		</div>
	</header>
</div>

<?php if( !is_front_page() ): ?>
	<div class="breadcrumbs" <?php get_breadcrumbs_background_style()?>
>
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<?php get_template_part( 'template-parts/title-page' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>