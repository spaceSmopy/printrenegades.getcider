<?php
/**
 * Template Name: Default page
 */
get_header(); ?>

<div class="container page__default">
	<div class="row">
		<!-- BEGIN of main content -->
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="list_of_posts col-12">
					<!-- BEGIN of post content -->
					<article <?php post_class(); ?>>
						<?php the_content('',true); ?>
					</article>
					<!-- END of post content -->
					<button id="quick-quote-tool" class="pum-trigger">Get a Quote</button>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<!-- END of main content -->
	</div>
</div>

<?php get_footer(); ?>