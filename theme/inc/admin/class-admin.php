<?php
/**
 * پنل مدیریت تم
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin {

	public function init(): void {
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
	}

	public function register_menus(): void {
		add_menu_page(
			__( 'Aether', 'aether' ),
			__( 'Aether', 'aether' ),
			'manage_options',
			'aether-dashboard',
			array( $this, 'render_dashboard' ),
			'dashicons-admin-customizer',
			59
		);

		add_submenu_page( 'aether-dashboard', __( 'داشبورد', 'aether' ), __( 'داشبورد', 'aether' ), 'manage_options', 'aether-dashboard', array( $this, 'render_dashboard' ) );
		add_submenu_page( 'aether-dashboard', __( 'تنظیمات', 'aether' ), __( 'تنظیمات', 'aether' ), 'manage_options', 'aether-settings', array( $this, 'render_settings' ) );
		add_submenu_page( 'aether-dashboard', __( 'دموها', 'aether' ), __( 'دموها', 'aether' ), 'manage_options', 'aether-demos', array( $this, 'render_demos' ) );
		add_submenu_page( 'aether-dashboard', __( 'لایسنس', 'aether' ), __( 'لایسنس', 'aether' ), 'manage_options', 'aether-license', array( $this, 'render_license' ) );
	}

	public function register_settings(): void {
		register_setting( 'aether_options_group', 'aether_options', array(
			'type'              => 'array',
			'sanitize_callback' => array( $this, 'sanitize_options' ),
			'default'           => $this->get_defaults(),
		) );
	}

	public function get_defaults(): array {
		return array(
			'layout_type'          => 'boxed',
			'dark_mode'            => 'auto',
			'header_preset'        => 'default',
			'header_sticky'        => true,
			'header_transparent'   => false,
			'header_topbar'        => true,
			'header_search'        => true,
			'header_account'       => true,
			'header_cart'          => true,
			'header_cta_text'      => '',
			'header_cta_url'       => '',
			'topbar_left_text'     => '',
			'topbar_right_text'    => '',
			'footer_columns'       => 4,
			'footer_copyright'     => '',
			'footer_payment_icons' => true,
			'color_primary'        => '#0f172a',
			'color_secondary'      => '#6366f1',
			'color_accent'         => '#f59e0b',
			'font_family'          => 'vazirmatn',
			'font_size_base'       => '16',
			'shop_layout'          => 'sidebar-right',
			'shop_columns'         => 3,
			'product_layout'       => 'no-sidebar',
			'products_per_page'    => 12,
			'blog_layout'          => 'sidebar-right',
			'lazy_load'            => true,
			'minify_css'           => false,
			'social_instagram'     => '',
			'social_telegram'      => '',
			'social_twitter'       => '',
			'social_linkedin'      => '',
			'custom_css'           => '',
		);
	}

	public function sanitize_options( $input ): array {
		if ( ! is_array( $input ) ) {
			return $this->get_defaults();
		}

		$defaults = $this->get_defaults();
		$output   = array();

		$booleans = array( 'header_sticky', 'header_transparent', 'header_topbar', 'header_search', 'header_account', 'header_cart', 'footer_payment_icons', 'lazy_load', 'minify_css' );
		foreach ( $booleans as $key ) {
			$output[ $key ] = ! empty( $input[ $key ] );
		}

		$text_fields = array( 'header_preset', 'layout_type', 'dark_mode', 'shop_layout', 'product_layout', 'blog_layout', 'font_family', 'header_cta_text', 'header_cta_url', 'topbar_left_text', 'topbar_right_text', 'footer_copyright', 'social_instagram', 'social_telegram', 'social_twitter', 'social_linkedin' );
		foreach ( $text_fields as $key ) {
			$output[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : $defaults[ $key ];
		}

		if ( isset( $input['header_cta_url'] ) ) {
			$output['header_cta_url'] = esc_url_raw( $input['header_cta_url'] );
		}

		$colors = array( 'color_primary', 'color_secondary', 'color_accent' );
		foreach ( $colors as $key ) {
			$output[ $key ] = isset( $input[ $key ] ) ? aether_sanitize_hex_color( $input[ $key ] ) : $defaults[ $key ];
		}

		$output['footer_columns']    = isset( $input['footer_columns'] ) ? absint( $input['footer_columns'] ) : 4;
		$output['shop_columns']      = isset( $input['shop_columns'] ) ? absint( $input['shop_columns'] ) : 3;
		$output['products_per_page'] = isset( $input['products_per_page'] ) ? absint( $input['products_per_page'] ) : 12;
		$output['font_size_base']    = isset( $input['font_size_base'] ) ? absint( $input['font_size_base'] ) : 16;
		$output['custom_css']        = isset( $input['custom_css'] ) ? wp_strip_all_tags( $input['custom_css'] ) : '';

		return $output;
	}

	public function render_dashboard(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include AETHER_INC . '/admin/views/dashboard.php';
	}

	public function render_settings(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include AETHER_INC . '/admin/views/settings.php';
	}

	public function render_demos(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include AETHER_INC . '/admin/views/demos.php';
	}

	public function render_license(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include AETHER_INC . '/admin/views/license.php';
	}

	public function admin_body_class( string $classes ): string {
		$screen = get_current_screen();
		if ( $screen && strpos( $screen->id, 'aether' ) !== false ) {
			$classes .= ' aether-admin';
		}
		return $classes;
	}
}
