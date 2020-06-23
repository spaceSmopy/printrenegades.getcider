<?php
/**
 * search results page layout
 */
get_header(); ?>

<div class="container page__blog">
	<div class="row">
		<!-- BEGIN of sidebar -->
		<div class="sidebar col-lg-3">
			<div class="sticky-scroll">
				<?php dynamic_sidebar('blog-sidebar'); ?>
			</div>
		</div>
		<!-- END of sidebar -->
		<!-- BEGIN of main content -->
		<div class="list_of_posts col-lg-9">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- BEGIN of post content -->
					<article id="post-<?php the_ID(); ?>" class="blog_post" >
						<span class="entry-meta"><?php the_time('d/m/y', get_option('date_format')); ?></span>
						<h2 class="blog_post--title">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'foundation'), the_title_attribute('echo=0'))); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>
						</h2>
						<?php if (is_sticky()) : ?>
							<span class="secondary label"><?php _e('Sticky', 'foundation'); ?></span>
						<?php endif; ?>
						<p>
							<?php //the_excerpt();
							$trimmed_content = wp_trim_words( get_the_content(), 40, ' <a href="'. get_permalink() .'">read more</a>' );
							echo $trimmed_content;
							?>
						</p>
					</article>
					<!-- END of post content -->
				<?php endwhile; ?>
			<?php endif; ?>
			<!-- BEGIN of pagination -->
			<?php the_posts_pagination(); ?>
			<!-- END of pagination -->
		</div>
		<!-- END of main content -->
	</div>
</div>

<?php get_footer(); ?>