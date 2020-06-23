<?php
/**
 * not found page layout
 */
get_header(); ?>

<div class="container page__not-found">
	<div class="row">
		<div class="col-12">
			<h1><?php _e('404: Page Not Found', 'foundation'); ?></h1>
			<h3><?php _e('Keep on looking...', 'foundation'); ?></h3>
			<p><?php printf(__('Double check the URL or head back to the <a class="label" href="%1s">HOMEPAGE</a>', 'foundation'), get_bloginfo('url')); ?></p>
		</div>
	</div>
</div>

<?php get_footer(); ?>