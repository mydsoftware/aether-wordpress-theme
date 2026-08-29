<?php
/**
 * Plugin Name: Aether Demo Importer
 * Description: سیستم واردات دمو یک‌کلیکه برای تم Aether - سازگار با Elementor
 * Version: 1.0.0
 * Author: Aether Team
 * Text Domain: aether-demo
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AETHER_DEMO_VERSION', '1.0.0' );
define( 'AETHER_DEMO_DIR', plugin_dir_path( __FILE__ ) );
define( 'AETHER_DEMO_URI', plugin_dir_url( __FILE__ ) );

require_once AETHER_DEMO_DIR . 'includes/class-demo-importer.php';
require_once AETHER_DEMO_DIR . 'includes/class-demo-content.php';
require_once AETHER_DEMO_DIR . 'includes/class-demo-elementor.php';
require_once AETHER_DEMO_DIR . 'includes/class-demo-woocommerce.php';
require_once AETHER_DEMO_DIR . 'includes/class-demo-settings.php';

function aether_demo_importer_init(): void {
	Aether_Demo_Importer::get_instance()->init();
}
add_action( 'plugins_loaded', 'aether_demo_importer_init' );

add_action( 'wp_ajax_aether_import_demo', function () {
	check_ajax_referer( 'aether_admin_nonce', 'nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'دسترسی غیرمجاز', 'aether-demo' ) ) );
	}
	$demo_id = isset( $_POST['demo_id'] ) ? sanitize_key( $_POST['demo_id'] ) : '';
	$step    = isset( $_POST['step'] ) ? sanitize_key( $_POST['step'] ) : 'init';
	if ( empty( $demo_id ) ) {
		wp_send_json_error( array( 'message' => __( 'دمو مشخص نشده', 'aether-demo' ) ) );
	}
	$result = Aether_Demo_Importer::get_instance()->run_step( $demo_id, $step );
	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}
	wp_send_json_success( $result );
} );
