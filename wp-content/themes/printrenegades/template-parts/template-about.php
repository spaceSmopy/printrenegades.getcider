<?php
/**
 * Template Name: About
 */
get_header(); ?>

<div class="container page__about">
	<div class="row">
		<!-- BEGIN of sidebar -->
		<div class="sidebar-toggler">
			<h6>
				<span class="icon">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</span>
				TOGGLE MENU
			</h6>
		</div>
		<div class="sidebar menu col-lg-3">
			<div class="sticky-scroll">

				<?php
				if( $post->post_parent !== 0 ) {
					$childrens = get_children( array(
						'post_parent' => $post->post_parent,
						'post_type'   => 'page',
						'numberposts' => -1,
						'order' => 'ASC',
						'orderby' => 'date',
						'post_status' => 'any'
					) );
				} else {
					$childrens = get_children( array(
						'post_parent' => $post->ID,
						'post_type'   => 'page',
						'numberposts' => -1,
						'order' => 'ASC',
						'orderby' => 'date',
						'post_status' => 'any'
					) );
				}

				if( $childrens ):
					echo "<ul class='sidebar-list'>";
					foreach( $childrens as $children ): ?>
						<li>
							<?php
							if( $image = get_field('subpost_icon',$children->ID) ): ?>
								<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
							<?php endif; ?>
							<a href="<?php echo get_permalink($children->ID); ?>">
								<?php echo $children->post_title; ?>
							</a>

						</li>
						<?php
					endforeach;
					echo "</ul>";
				endif;
				?>
			</div>
		</div>
		<!-- END of sidebar -->
		<!-- BEGIN of main content -->
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="list_of_posts col-lg-9">
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