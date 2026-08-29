<?php
/**
 * سازگاری با افزونه‌ها و نسخه‌ها
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Compatibility;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Compatibility
 */
class Compatibility {

	public function init(): void {
		add_action( 'elementor/theme/register_locations', array( $this, 'register_elementor_locations' ) );
		add_filter( 'aether_disable_title', array( $this, 'maybe_disable_title' ) );
	}

	public function register_elementor_locations( $elementor_theme_manager ): void {
		if ( ! method_exists( $elementor_theme_manager, 'register_location' ) ) {
			return;
		}
		$elementor_theme_manager->register_location( 'header' );
		$elementor_theme_manager->register_location( 'footer' );
	}

	public function maybe_disable_title( bool $disable ): bool {
		if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'AIOSEO\\Plugin\\AIOSEO' ) ) {
			return true;
		}
		return $disable;
	}
}
