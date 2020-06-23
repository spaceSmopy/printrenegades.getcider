<?php
/**
 * Widget API: Latest Instagram Widget Class
 *
 * @package Slider and Carousel Plus Widget Instagram
 * @since 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function iscw_insta_grid_widgets() {
	register_widget( 'Iscw_Insta_Grid_Widget' );
}

// Action to register widget
add_action( 'widgets_init', 'iscw_insta_grid_widgets' );

class Iscw_Insta_Grid_Widget extends WP_Widget {

	var $defaults;

	/**
	 * Sets up a new widget instance.
	 *
	 * @package Slider and Carousel Plus Widget Instagram
	 * @since 1.0.0
	 */
	function __construct() {
		$widget_ops = array('classname' => 'iscwp-insta-grid', 'description' => __('Display Instagram pictures in grid view.', 'slider-and-carousel-plus-widget-for-instagram') );
		parent::__construct( 'iscw_insta_grid', __('Instagram Grid - WPOS', 'slider-and-carousel-plus-widget-for-instagram'), $widget_ops );

		$this->defaults = array(
			'title'                         => '',
			'username'                      => '',
			'grid'                          => 2,
			'popup_gallery'                 => 1,
			'instagram_link_text'           => esc_html__('View On Instagram','slider-and-carousel-plus-widget-for-instagram'),
			'limit'                         => 10,
			'show_caption'                  => 1,
			'popup'                         => 1,
			'show_likes_count'              => 1,
			'show_comments_count'           => 0,
			'image_fit'                     => 1,
			'offset'                        => 2,
			'gallery_height'                => '',  
		);
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @package Slider and Carousel Plus Widget Instagram
	 * @since 1.0.0
	 */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title']                          = iscw_clean( $new_instance['title'] );
		$instance['username']                       = iscw_clean( $new_instance['username'] );
		$instance['grid']                           = iscw_clean_number( $new_instance['grid'], 2 );
		$instance['gallery_height']                 = iscw_clean_number( $new_instance['gallery_height'], '' );
		$instance['limit']                          = iscw_clean_number( $new_instance['limit'], 10, 'number' );
		$instance['offset']                         = is_numeric( $new_instance['offset'] ) ? absint( $new_instance['offset'] ) : '';
		$instance['image_fit']                      = ! empty( $new_instance['image_fit'] )				? 1 : 0;
		$instance['popup']                          = ! empty( $new_instance['popup'] ) 				? 1 : 0;
		$instance['popup_gallery']                  = ! empty( $new_instance['popup_gallery'] ) 		? 1 : 0;
		$instance['show_caption']                   = ! empty( $new_instance['show_caption'] )			? 1 : 0;
		$instance['show_likes_count']               = ! empty( $new_instance['show_likes_count'] )		? 1 : 0;
		$instance['show_comments_count']            = ! empty( $new_instance['show_comments_count'] )	? 1 : 0;
		$instance['instagram_link_text']            = ! empty($new_instance['instagram_link_text'])		? iscw_clean( $new_instance['instagram_link_text'] ) : esc_html__('View On Instagram','slider-and-carousel-plus-widget-for-instagram');

		return $instance;
	}

	/**
	 * Outputs the settings form for the widget.
	 *
	 * @package Slider and Carousel Plus Widget Instagram
	 * @since 1.0.0
	 */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>

		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'slider-and-carousel-plus-widget-for-instagram' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<!-- Username -->
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e( 'Username', 'slider-and-carousel-plus-widget-for-instagram' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr( $instance['username'] ); ?>" />
		</p>
		
		<!-- Number of Grid -->
		<p>
			<label for="<?php echo $this->get_field_id('grid'); ?>"><?php _e( 'Grid', 'slider-and-carousel-plus-widget-for-instagram' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('grid'); ?>" name="<?php echo $this->get_field_name('grid'); ?>" type="text" value="<?php echo esc_attr( $instance['grid'] ); ?>" />
		</p>	

		<!-- offset -->
		<p>
			<label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e( 'Offset - Padding for Image Wrap', 'slider-and-carousel-plus-widget-for-instagram' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo esc_attr( $instance['offset'] ); ?>" />
		</p>
		
		 <!-- Image Wrap Height -->
		<p>
			<label for="<?php echo $this->get_field_id('gallery_height'); ?>"><?php _e( 'Image Wrap Height', 'slider-and-carousel-plus-widget-for-instagram' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('gallery_height'); ?>" name="<?php echo $this->get_field_name('gallery_height'); ?>" type="text" value="<?php echo esc_attr( $instance['gallery_height'] ); ?>" />
		</p>
		
		 <!-- Number of Items -->
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Number of Items', 'slider-and-carousel-plus-widget-for-instagram' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
		</p>

		<!-- instagram_link_text -->
		<p>
			<label for="<?php echo $this->get_field_id('instagram_link_text'); ?>"><?php _e( 'Instagram Redirect Link Text', 'slider-and-carousel-plus-widget-for-instagram' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('instagram_link_text'); ?>" name="<?php echo $this->get_field_name('instagram_link_text'); ?>" type="text" value="<?php echo esc_attr($instance['instagram_link_text']); ?>" />
		</p>
		
		 <!-- Select Image Fit -->
		<p>
			<input id="<?php echo $this->get_field_id( 'image_fit' ); ?>" name="<?php echo $this->get_field_name( 'image_fit' ); ?>" type="checkbox" value="1" <?php checked( $instance['image_fit'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'image_fit' ); ?>"><?php _e( 'Image fit', 'slider-and-carousel-plus-widget-for-instagram' ); ?></label></br>
			<small><?php _e( 'Check this box to enable image fit in image wrap', 'slider-and-carousel-plus-widget-for-instagram' ); ?></small>
		</p>
		
		<!-- Select popup -->
		<p>
			<input id="<?php echo $this->get_field_id( 'popup' ); ?>" name="<?php echo $this->get_field_name( 'popup' ); ?>" type="checkbox" value="1" <?php checked( $instance['popup'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'popup' ); ?>"><?php _e( 'Popup', 'slider-and-carousel-plus-widget-for-instagram' ); ?></label></br>
			<small><?php _e( 'Check this box to enable popup', 'slider-and-carousel-plus-widget-for-instagram' ); ?></small>
		</p>

		<!-- Select popup_gallery -->
		<p>
			<input id="<?php echo $this->get_field_id( 'popup_gallery' ); ?>" name="<?php echo $this->get_field_name( 'popup_gallery' ); ?>" type="checkbox" value="1" <?php checked( $instance['popup_gallery'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'popup_gallery' ); ?>"><?php _e( 'Popup Gallery', 'slider-and-carousel-plus-widget-for-instagram' ); ?></label></br>
			<small><?php _e( 'Check this box to enable popup gallery mode', 'slider-and-carousel-plus-widget-for-instagram' ); ?></small>
		</p>

		<!-- Select show_caption -->
		<p>
			<input id="<?php echo $this->get_field_id( 'show_caption' ); ?>" name="<?php echo $this->get_field_name( 'show_caption' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_caption'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_caption' ); ?>"><?php _e( 'Show Caption', 'slider-and-carousel-plus-widget-for-instagram' ); ?></label>
		</p>

		<!-- Select show_likes_count -->
		<p>
			<input id="<?php echo $this->get_field_id( 'show_likes_count' ); ?>" name="<?php echo $this->get_field_name( 'show_likes_count' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_likes_count'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_likes_count' ); ?>"><?php _e( 'Show Likes Count', 'slider-and-carousel-plus-widget-for-instagram' ); ?></label>
		</p>

		<!-- Select show_comments_count -->
		<p>
			<input id="<?php echo $this->get_field_id( 'show_comments_count' ); ?>" name="<?php echo $this->get_field_name( 'show_comments_count' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_comments_count'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_comments_count' ); ?>"><?php _e( 'Show Comments Count', 'slider-and-carousel-plus-widget-for-instagram' ); ?></label>
		</p><?php
	}

	/**
	* Outputs the content for the current widget instance.
	*
	* @package Slider and Carousel Plus Widget Instagram
	* @since 1.0.0
	*/
	function widget( $insta_grid_args, $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		extract($insta_grid_args, EXTR_SKIP);

		$title                          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$username                       = $instance['username'];
		$grid                           = $instance['grid'];
		$limit                          = $instance['limit'];
		$gallery_height                 = $instance['gallery_height'];
		$image_fit                      = $instance['image_fit'];
		$popup_gallery                  = ( isset($instance['popup_gallery']) && ($instance['popup_gallery'] == 1) ) ? "true" : "false";
		$instagram_link_text            = ($instance['instagram_link_text'] != '') ? $instance['instagram_link_text'] : esc_html__('View On Instagram','slider-and-carousel-plus-widget-for-instagram');
		$show_caption                   = ( isset($instance['show_caption']) && ($instance['show_caption'] == 1) ) ? "true" : "false";
		$popup                          = ( isset($instance['popup']) && ($instance['popup'] == 1) ) ? "true" : "false";
		$show_comments_count            = ( isset($instance['show_comments_count']) && ($instance['show_comments_count'] == 1) ) ? "true" : "false";
		$show_likes_count               = ( isset($instance['show_likes_count']) && ($instance['show_likes_count'] == 1) ) ? "true" : "false";
		$height_css                     = !empty($gallery_height) ? "style='height:{$gallery_height}px;'" : '';
		$offset_css                     = ( $instance['offset'] >= 0 ) ? "padding:{$instance['offset']}px;" : '';

		// If no username is passed then return
		if( empty($username) ) {
			return;
		}

		// Taking some variables
		$popup_html             = '';
		$loop_count             = 1;
		$count                  = 1;
		$unique                 = iscw_get_unique();
		$popup_cls              = ($popup == 'true')    ? 'iscwp-popup-gallery' : '';
		$main_cls               = "iscwp-cnt-wrp iscwp-col-{$grid} iscwp-columns";
		$image_fit_class	    = ($image_fit) 	        ? 'iscwp-image-fit' : '';

		$instagram_link_main    = 'https://www.instagram.com/';
		$instagram_data         = iscw_get_user_media( $username );
		$insta_user_media       = !empty($instagram_data['iscwp_data']['edge_owner_to_timeline_media']['edges']) ? $instagram_data['iscwp_data']['edge_owner_to_timeline_media']['edges'] : '';

		if( empty($insta_user_media) ) {
			$ajax_conf = compact('popup', 'loop_count', 'count', 'main_cls', 'offset_css', 'height_css', 'show_likes_count', 'show_comments_count', 'unique', 'instagram_link_main', 'instagram_link_text', 'show_caption', 'shortcode' );
		} 

		// User details
		$userdata = array(
			'username'          =>  (!empty($instagram_data['iscwp_user_data']['username'])) ? $instagram_data['iscwp_user_data']['username'] : '',
			'full_name'         =>  (!empty($instagram_data['iscwp_user_data']['full_name'])) ? $instagram_data['iscwp_user_data']['full_name'] : '',
			'profile_picture'   =>  (!empty($instagram_data['iscwp_user_data']['profile_pic_url'])) ? $instagram_data['iscwp_user_data']['profile_pic_url'] : '',
		);

		// Enqueue required script
		if( $popup == 'true' || empty($insta_user_media) ) {

			wp_enqueue_script('wpos-magnific-script');
			wp_enqueue_script('iscwp-public-js');

			// Popup Configuration
			$popup_conf = compact( 'popup_gallery', 'show_likes_count', 'show_comments_count', 'show_caption', 'instagram_link_text' );
		}

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		?>
			
		<div class="iscwp-main-wrp iscwp-clearfix">
			<div class="iscwp-gallery-main-wrap iscwp-instagram-grid-widget <?php echo $popup_cls.' '.$image_fit_class;?>" id="iscwp-gallery-<?php echo $unique; ?>" data-user="<?php echo $username; ?>" <?php if( empty($insta_user_media) ){ ?> data-ajax="true" data-ajax-conf="<?php echo htmlspecialchars(json_encode($ajax_conf)); ?>" <?php } ?>>
				<div class="iscwp-outer-wrap iscwp-result-wrap">

					<?php if( !empty($insta_user_media) ) { ?>
						<?php foreach ($insta_user_media as $iscwp_key => $iscwp_data) {

							$iscwp_data         = iscw_insta_image_data( $iscwp_data );
							$img_shortcode      = $iscwp_data['shortcode'];
							$gallery_img_src    = isset( $iscwp_data['thumbnail_resources'][640] ) ? $iscwp_data['thumbnail_resources'][640] : $iscwp_data['display_url'];
							$iscwp_likes        = iscw_format_number( $iscwp_data['like_count'] );
							$iscwp_comments     = iscw_format_number( $iscwp_data['comment_count'] );
							$instagram_link     = $iscwp_data['link'];
							$img_caption        = $iscwp_data['caption'];
							$iscwp_link_value   = ($popup =='true') ? 'javascript:void(0);' : $instagram_link ;

							// Getting media data
							$media_data     = iscw_user_media_data( $username, $img_shortcode );
							$location       = isset($media_data['location'])        ? $media_data['location']       : '';                       
							$video_url      = isset($media_data['video_url'])       ? $media_data['video_url']      : '';
							$popup_attr     = (!$media_data) ? "data-shortcode='{$img_shortcode}'" : '';

							$wrpper_cls     = ($loop_count == 1) ? $main_cls.' iscwp-first' : $main_cls;                            

							include( ISCW_DIR . '/templates/design-1.php' );

							// Creating Popup HTML
							if( $popup == 'true' ) {
								
								ob_start();
								include( ISCW_DIR . '/templates/popup/popup.php' );
								$popup_html .= ob_get_clean();
							}
							
							if( $limit == $count ) {
								break;
							}

							$count++;
							$loop_count++; // Increment loop count for grid
							
							// Reset loop count
							if( $loop_count == $grid ) {
								$loop_count = 0;
							}
						} 
					} ?>

				</div>
			</div>
			<?php if($popup == 'true') { ?>                        
				<div class="iscwp-popup-html wp-iscwp-popup-conf" data-conf="<?php echo htmlspecialchars(json_encode($popup_conf)); ?>">
					<?php echo $popup_html; // Printing popup html ?>
				</div>
			<?php } ?>
		</div>
		<?php
		echo $after_widget;
	}
}