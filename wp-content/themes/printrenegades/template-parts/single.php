<?php
/**
 * single post layout
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
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<!-- BEGIN of post content -->
					<article id="post-<?php the_ID(); ?>" class="blog_post" >
						<span class="entry-meta"><?php the_time('d/m/y', get_option('date_format')); ?></span>
						<h1 class="blog_post--title"><?php the_title(); ?></h1>
						<?php the_content('',true); ?>
						<?php  //comments_template(); ?>
					</article>
					<!-- END of post content -->
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<!-- END of main content -->
	</div>
</div>

<?php get_footer(); ?>