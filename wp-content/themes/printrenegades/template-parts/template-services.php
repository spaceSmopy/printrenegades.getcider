<?php
/**
 * Template Name: Services
 */
get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="container page__services">
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
						BROWSE SERVICES
					</h6>
				</div>
				<div class="sidebar menu col-lg-3">
					<div class="sticky-scroll">
						<h4 class="sidebar-title">
							<?php _e('Other services','printrenegadesdev'); ?>
						</h4>
						<?php
						$servicesArgs = array(
							'post_type'=>'services',
							'order'          => 'ASC',
							'orderby'        => 'menu_order',
							'posts_per_page' => - 1
						);
						$services = new WP_Query($servicesArgs);?>
						<?php if($services->have_posts()): ?>
							<ul class="sidebar-list">
								<?php while($services->have_posts()): $services->the_post() ?>
									<li>
										<?php if($alternative_image = get_field('alternative_image')): ?>
											<img src="<?php echo $alternative_image['url']; ?>" alt="<?php echo $alternative_image['alt']; ?>" />
										<?php endif; ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</li>
								<?php endwhile; ?>
							</ul>
							<?php wp_reset_postdata(); ?>
						<?php endif;?>
					</div>
				</div>
				<!-- END of sidebar -->
				<!-- BEGIN of main content -->
				<div class="list_of_posts col-lg-9">
					<!-- BEGIN of post content -->
					<div class="service_additional_content">
						<?php the_content(); ?>
					</div>
					<?php
					$images = get_field('service_photos');

					if( $images ): ?>
						<ul class="service_photos portfolio__grid">
							<?php foreach( $images as $image ): ?>
								<li class="portfolio__grid--item">
									<a href="<?php echo $image['url']; ?>" rel='photos' style="background-image: url(<?php echo $image['sizes']['portfolio_thumbnail']; ?>)">
									</a>
									<p><?php echo $image['caption']; ?></p>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if($service_table = get_field('service_table')): ?>
						<div class="desktop_table">
							<?php echo $service_table; ?>
						</div>
					<?php endif; ?>

					<?php if($service_mobile_table = get_field('service_mobile_table')): ?>
						<div class="mobile_table">
							<?php echo $service_mobile_table; ?>
						</div>
					<?php endif; ?>
					<!-- END of post content -->
					<button id="quick-quote-tool" class="pum-trigger">Get a Quote</button>
				</div>
				<!-- END of main content -->
			</div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>