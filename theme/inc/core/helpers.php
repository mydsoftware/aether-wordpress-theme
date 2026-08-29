<?php
/**
 * توابع کمکی تم Aether
 *
 * @package Aether
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * دریافت گزینه تم با مقدار پیش‌فرض
 *
 * @param string $key کلید گزینه.
 * @param mixed  $default مقدار پیش‌فرض.
 * @return mixed
 */
function aether_get_option( string $key, $default = null ) {
	$options = get_option( 'aether_options', array() );
	return $options[ $key ] ?? $default;
}

/**
 * ذخیره گزینه تم
 *
 * @param string $key کلید.
 * @param mixed  $value مقدار.
 * @return bool
 */
function aether_update_option( string $key, $value ): bool {
	$options         = get_option( 'aether_options', array() );
	$options[ $key ] = $value;
	return update_option( 'aether_options', $options );
}

/**
 * بررسی فعال بودن ووکامرس
 *
 * @return bool
 */
function aether_is_woocommerce_active(): bool {
	return class_exists( 'WooCommerce' );
}

/**
 * دریافت مسیر asset با نسخه
 *
 * @param string $path مسیر نسبی از پوشه assets.
 * @return string
 */
function aether_asset_url( string $path ): string {
	return AETHER_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Escape و ترجمه
 *
 * @param string $text متن.
 * @return string
 */
function aether_esc_html__( string $text ): string {
	return esc_html__( $text, AETHER_TEXT_DOMAIN );
}

/**
 * بررسی RTL
 *
 * @return bool
 */
function aether_is_rtl(): bool {
	return is_rtl();
}

/**
 * لاگ امن برای دیباگ
 *
 * @param mixed  $message پیام.
 * @param string $level سطح.
 */
function aether_log( $message, string $level = 'info' ): void {
	if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
		return;
	}

	if ( is_array( $message ) || is_object( $message ) ) {
		$message = wp_json_encode( $message );
	}

	error_log( sprintf( '[Aether][%s] %s', strtoupper( $level ), $message ) );
}

/**
 * دریافت schema تم
 *
 * @return array
 */
function aether_get_schema(): array {
	$schema_file = AETHER_DIR . '/theme-schema.json';
	if ( ! file_exists( $schema_file ) ) {
		return array();
	}

	$content = file_get_contents( $schema_file );
	if ( false === $content ) {
		return array();
	}

	$data = json_decode( $content, true );
	return is_array( $data ) ? $data : array();
}

/**
 * Sanitize رنگ هگز
 *
 * @param string $color رنگ.
 * @return string
 */
function aether_sanitize_hex_color( string $color ): string {
	if ( '' === $color ) {
		return '';
	}

	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return '';
}

/**
 * بررسی قابلیت کاربر
 *
 * @param string $capability قابلیت.
 * @return bool
 */
function aether_current_user_can( string $capability = 'manage_options' ): bool {
	return current_user_can( $capability );
}
