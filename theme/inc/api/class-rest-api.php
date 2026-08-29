<?php
/**
 * REST API تم - پایه AI-Ready
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rest_Api {

	private string $namespace = 'aether/v1';

	public function init(): void {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes(): void {
		register_rest_route( $this->namespace, '/config', array(
			'methods'             => 'GET',
			'callback'            => array( $this, 'get_config' ),
			'permission_callback' => '__return_true',
		) );

		register_rest_route( $this->namespace, '/schema', array(
			'methods'             => 'GET',
			'callback'            => array( $this, 'get_schema' ),
			'permission_callback' => '__return_true',
		) );

		register_rest_route( $this->namespace, '/settings', array(
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_settings' ),
				'permission_callback' => array( $this, 'check_admin_permission' ),
			),
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_settings' ),
				'permission_callback' => array( $this, 'check_admin_permission' ),
			),
		) );

		register_rest_route( $this->namespace, '/header', array(
			'methods'             => 'GET',
			'callback'            => array( $this, 'get_header_config' ),
			'permission_callback' => '__return_true',
		) );

		register_rest_route( $this->namespace, '/layouts', array(
			'methods'             => 'GET',
			'callback'            => array( $this, 'get_layouts' ),
			'permission_callback' => '__return_true',
		) );
	}

	public function check_admin_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new \WP_Error( 'rest_forbidden', __( 'شما دسترسی لازم را ندارید.', 'aether' ), array( 'status' => 403 ) );
		}
		return true;
	}

	public function get_config(): \WP_REST_Response {
		return new \WP_REST_Response( array(
			'name'        => 'Aether',
			'version'     => AETHER_VERSION,
			'textDomain'  => AETHER_TEXT_DOMAIN,
			'isRtl'       => is_rtl(),
			'woocommerce' => aether_is_woocommerce_active(),
			'darkMode'    => aether_get_option( 'dark_mode', 'auto' ),
		), 200 );
	}

	public function get_schema(): \WP_REST_Response {
		return new \WP_REST_Response( aether_get_schema(), 200 );
	}

	public function get_settings(): \WP_REST_Response {
		return new \WP_REST_Response( get_option( 'aether_options', array() ), 200 );
	}

	public function update_settings( \WP_REST_Request $request ) {
		$settings = $request->get_param( 'settings' );
		if ( ! is_array( $settings ) ) {
			return new \WP_Error( 'invalid_settings', __( 'تنظیمات نامعتبر است.', 'aether' ), array( 'status' => 400 ) );
		}
		$current = get_option( 'aether_options', array() );
		$this->create_snapshot( $current );
		$admin     = new \Aether\Admin\Admin();
		$sanitized = $admin->sanitize_options( $settings );
		update_option( 'aether_options', $sanitized );
		return new \WP_REST_Response( array( 'success' => true, 'settings' => $sanitized ), 200 );
	}

	public function get_header_config(): \WP_REST_Response {
		return new \WP_REST_Response( array(
			'preset'      => aether_get_option( 'header_preset', 'default' ),
			'sticky'      => (bool) aether_get_option( 'header_sticky', true ),
			'transparent' => (bool) aether_get_option( 'header_transparent', false ),
			'topbar'      => (bool) aether_get_option( 'header_topbar', true ),
			'search'      => (bool) aether_get_option( 'header_search', true ),
			'account'     => (bool) aether_get_option( 'header_account', true ),
			'cart'        => (bool) aether_get_option( 'header_cart', true ),
		), 200 );
	}

	public function get_layouts(): \WP_REST_Response {
		return new \WP_REST_Response( array(
			'page'    => array( 'boxed', 'full-width', 'sidebar-left', 'sidebar-right', 'no-sidebar' ),
			'shop'    => array( 'sidebar-right', 'sidebar-left', 'full-width' ),
			'product' => array( 'default', 'gallery-left', 'gallery-right', 'stacked' ),
			'blog'    => array( 'grid', 'list', 'masonry', 'magazine', 'sidebar-right', 'sidebar-left', 'full-width' ),
		), 200 );
	}

	private function create_snapshot( array $data ): void {
		$snapshots   = get_option( 'aether_config_snapshots', array() );
		$snapshots[] = array( 'timestamp' => time(), 'user_id' => get_current_user_id(), 'data' => $data );
		if ( count( $snapshots ) > 20 ) {
			$snapshots = array_slice( $snapshots, -20 );
		}
		update_option( 'aether_config_snapshots', $snapshots, false );
	}
}
