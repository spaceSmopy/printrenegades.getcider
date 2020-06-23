<?php
/**
 * The template for displaying footer.
 *
 * @package PrintrenegadesElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<footer id="site-footer" class="site-footer" role="contentinfo">
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-3">
					<?php dynamic_sidebar("footer-sidebar-1");?>
				</div>
				<div class="col-12 col-md-4">
					<?php dynamic_sidebar("footer-sidebar-2");?>
				</div>
				<div class="col-12 col-md-5 text-center text-md-right">
					<div class="social-links">
						<h4><?php _e('Get connected', "printrenegades"); ?></h4>
						<?php get_template_part('template-parts/social-menu'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		<p>
			&copy; <?php _e("Copyright", "printrenegades") ?> <?php echo date('Y')?> 
			<?php echo ucwords( get_bloginfo("name") ); ?>, <?php _e("All Rights Reserved", "printrenegades") ?>
		</p>
		<?php dynamic_sidebar("footer-sidebar-3"); ?>
	</div>
</footer>
