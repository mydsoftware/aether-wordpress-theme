<?php
/**
 * Setup Wizard / Onboarding
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Onboarding
 */
class Onboarding {

	public function init(): void {
		add_action( 'admin_init', array( $this, 'maybe_redirect' ) );
		add_action( 'wp_ajax_aether_complete_onboarding', array( $this, 'complete_onboarding' ) );
	}

	public function maybe_redirect(): void {
		if ( ! get_transient( 'aether_activation_redirect' ) ) {
			return;
		}
		delete_transient( 'aether_activation_redirect' );
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}
		if ( get_option( 'aether_onboarding_completed' ) ) {
			return;
		}
		wp_safe_redirect( admin_url( 'admin.php?page=aether-dashboard&onboarding=1' ) );
		exit;
	}

	public function complete_onboarding(): void {
		check_ajax_referer( 'aether_admin_nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'دسترسی غیرمجاز', 'aether' ) ) );
		}
		update_option( 'aether_onboarding_completed', true );
		wp_send_json_success();
	}
}

add_action(
	'after_switch_theme',
	function () {
		set_transient( 'aether_activation_redirect', true, 30 );
	}
);
