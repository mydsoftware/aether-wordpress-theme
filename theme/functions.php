<?php
/**
 * Aether Theme - فایل اصلی توابع
 *
 * @package Aether
 * @version 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * تعریف ثابت‌های تم
 */
define( 'AETHER_VERSION', '1.0.0' );
define( 'AETHER_DIR', get_template_directory() );
define( 'AETHER_URI', get_template_directory_uri() );
define( 'AETHER_INC', AETHER_DIR . '/inc' );
define( 'AETHER_TEXT_DOMAIN', 'aether' );

/**
 * بارگذاری فایل‌های هسته
 */
require_once AETHER_INC . '/core/class-autoloader.php';
require_once AETHER_INC . '/core/class-theme.php';
require_once AETHER_INC . '/core/helpers.php';

/**
 * راه‌اندازی تم
 */
function aether_init(): void {
	$theme = Aether\Core\Theme::get_instance();
	$theme->init();
}
add_action( 'after_setup_theme', 'aether_init', 0 );

/**
 * بارگذاری فایل ترجمه
 */
function aether_load_textdomain(): void {
	load_theme_textdomain( AETHER_TEXT_DOMAIN, AETHER_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'aether_load_textdomain' );
