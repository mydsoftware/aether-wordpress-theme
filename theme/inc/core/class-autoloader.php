<?php
/**
 * سیستم Autoloader تم Aether
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Autoloader
 */
class Autoloader {

	/**
	 * پیشوند namespace
	 *
	 * @var string
	 */
	private static string $prefix = 'Aether\\';

	/**
	 * مسیر پایه
	 *
	 * @var string
	 */
	private static string $base_dir = '';

	/**
	 * ثبت Autoloader
	 */
	public static function register(): void {
		self::$base_dir = AETHER_INC . '/';
		spl_autoload_register( array( __CLASS__, 'autoload' ) );
	}

	/**
	 * بارگذاری کلاس
	 *
	 * @param string $class نام کامل کلاس.
	 */
	public static function autoload( string $class ): void {
		if ( strpos( $class, self::$prefix ) !== 0 ) {
			return;
		}

		$relative_class = substr( $class, strlen( self::$prefix ) );
		$relative_class = strtolower( str_replace( '\\', '/', $relative_class ) );
		$relative_class = str_replace( '_', '-', $relative_class );

		$parts       = explode( '/', $relative_class );
		$class_name  = array_pop( $parts );
		$subdir      = implode( '/', $parts );

		$file = self::$base_dir;
		if ( $subdir ) {
			$file .= $subdir . '/';
		}
		$file .= 'class-' . $class_name . '.php';

		if ( file_exists( $file ) ) {
			require_once $file;
			return;
		}

		$file_alt = self::$base_dir;
		if ( $subdir ) {
			$file_alt .= $subdir . '/';
		}
		$file_alt .= $class_name . '.php';

		if ( file_exists( $file_alt ) ) {
			require_once $file_alt;
		}
	}
}

// ثبت خودکار
Autoloader::register();
