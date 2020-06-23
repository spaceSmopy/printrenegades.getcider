<?php
/**
 * Printrenegades Elementor admin functions.
 *
 * @package PrintrenegadesElementor
 */

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @return void
 */
function printrenegades_elementor_fail_load_admin_notice() {
	// Leave to Elementor Pro to manage this.
	if ( function_exists( 'elementor_pro_load_plugin' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	if ( 'true' === get_user_meta( get_current_user_id(), '_printrenegades_elementor_install_notice', true ) ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	$installed_plugins = get_plugins();

	$is_elementor_installed = isset( $installed_plugins[ $plugin ] );

	if ( $is_elementor_installed ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$message = __( 'Printrenegades theme is a lightweight starter theme designed to work perfectly with Elementor Page Builder plugin.', 'printrenegades' );

		$button_text = __( 'Activate Elementor', 'printrenegades' );
		$button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$message = __( 'Printrenegades theme is a lightweight starter theme. We recommend you use it together with Elementor Page Builder plugin, they work perfectly together!', 'printrenegades' );

		$button_text = __( 'Install Elementor', 'printrenegades' );
		$button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
	}

	?>
	<style>
		.notice.printrenegades-notice {
			border-left-color: #9b0a46 !important;
			padding: 20px;
		}
		.rtl .notice.printrenegades-notice {
			border-right-color: #9b0a46 !important;
		}
		.notice.printrenegades-notice .printrenegades-notice-inner {
			display: table;
			width: 100%;
		}
		.notice.printrenegades-notice .printrenegades-notice-inner .printrenegades-notice-icon,
		.notice.printrenegades-notice .printrenegades-notice-inner .printrenegades-notice-content,
		.notice.printrenegades-notice .printrenegades-notice-inner .printrenegades-install-now {
			display: table-cell;
			vertical-align: middle;
		}
		.notice.printrenegades-notice .printrenegades-notice-icon {
			color: #9b0a46;
			font-size: 50px;
			width: 50px;
		}
		.notice.printrenegades-notice .printrenegades-notice-content {
			padding: 0 20px;
		}
		.notice.printrenegades-notice p {
			padding: 0;
			margin: 0;
		}
		.notice.printrenegades-notice h3 {
			margin: 0 0 5px;
		}
		.notice.printrenegades-notice .printrenegades-install-now {
			text-align: center;
		}
		.notice.printrenegades-notice .printrenegades-install-now .printrenegades-install-button {
			padding: 5px 30px;
			height: auto;
			line-height: 20px;
			text-transform: capitalize;
		}
		.notice.printrenegades-notice .printrenegades-install-now .printrenegades-install-button i {
			padding-right: 5px;
		}
		.rtl .notice.printrenegades-notice .printrenegades-install-now .printrenegades-install-button i {
			padding-right: 0;
			padding-left: 5px;
		}
		.notice.printrenegades-notice .printrenegades-install-now .printrenegades-install-button:active {
			transform: translateY(1px);
		}
		@media (max-width: 767px) {
			.notice.printrenegades-notice {
				padding: 10px;
			}
			.notice.printrenegades-notice .printrenegades-notice-inner {
				display: block;
			}
			.notice.printrenegades-notice .printrenegades-notice-inner .printrenegades-notice-content {
				display: block;
				padding: 0;
			}
			.notice.printrenegades-notice .printrenegades-notice-inner .printrenegades-notice-icon,
			.notice.printrenegades-notice .printrenegades-notice-inner .printrenegades-install-now {
				display: none;
			}
		}
	</style>
	<script>jQuery( function( $ ) {
			$( 'div.notice.printrenegades-install-elementor' ).on( 'click', 'button.notice-dismiss', function( event ) {
				event.preventDefault();

				$.post( ajaxurl, {
					action: 'printrenegades_elementor_set_admin_notice_viewed'
				} );
			} );
		} );</script>
	<div class="notice updated is-dismissible printrenegades-notice printrenegades-install-elementor">
		<div class="printrenegades-notice-inner">
			<div class="printrenegades-notice-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/elementor-logo.png' ); ?>" alt="Elementor Logo" />
			</div>

			<div class="printrenegades-notice-content">
				<h3><?php esc_html_e( 'Thanks for installing Printrenegades Theme!', 'printrenegades' ); ?></h3>
				<p>
					<p><?php echo esc_html( $message ); ?></p>
					<a href="https://go.elementor.com/printrenegades-theme-learn/" target="_blank"><?php esc_html_e( 'Learn more about Elementor', 'printrenegades' ); ?></a>
				</p>
			</div>

			<div class="printrenegades-install-now">
				<a class="button button-primary printrenegades-install-button" href="<?php echo esc_attr( $button_link ); ?>"><i class="dashicons dashicons-download"></i><?php echo esc_html( $button_text ); ?></a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Set Admin Notice Viewed.
 *
 * @return void
 */
function ajax_printrenegades_elementor_set_admin_notice_viewed() {
	update_user_meta( get_current_user_id(), '_printrenegades_elementor_install_notice', 'true' );
	die;
}

add_action( 'wp_ajax_printrenegades_elementor_set_admin_notice_viewed', 'ajax_printrenegades_elementor_set_admin_notice_viewed' );

if ( ! did_action( 'elementor/loaded' ) ) {
	add_action( 'admin_notices', 'printrenegades_elementor_fail_load_admin_notice' );
}
