<?php
/**
 * سیستم Layout تم
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Layout
 */
class Layout {

	/**
	 * مقداردهی
	 */
	public function init(): void {
		add_filter( 'aether_content_classes', array( $this, 'content_classes' ) );
		add_filter( 'aether_sidebar_position', array( $this, 'get_sidebar_position' ) );
	}

	/**
	 * کلاس‌های محتوا بر اساس layout
	 *
	 * @param array $classes کلاس‌ها.
	 * @return array
	 */
	public function content_classes( array $classes ): array {
		$layout = $this->get_current_layout();

		$classes[] = 'aether-content';
		$classes[] = 'aether-content--' . sanitize_html_class( $layout );

		return $classes;
	}

	/**
	 * موقعیت سایدبار
	 *
	 * @return string
	 */
	public function get_sidebar_position(): string {
		$layout = $this->get_current_layout();

		$map = array(
			'sidebar-left'  => 'left',
			'sidebar-right' => 'right',
			'no-sidebar'    => 'none',
			'full-width'    => 'none',
			'boxed'         => 'right',
		);

		return $map[ $layout ] ?? 'right';
	}

	/**
	 * دریافت layout فعلی
	 *
	 * @return string
	 */
	public function get_current_layout(): string {
		if ( is_singular() ) {
			$post_layout = get_post_meta( get_the_ID(), '_aether_layout', true );
			if ( $post_layout ) {
				return sanitize_key( $post_layout );
			}
		}

		if ( aether_is_woocommerce_active() ) {
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				return aether_get_option( 'shop_layout', 'sidebar-right' );
			}
			if ( is_product() ) {
				return aether_get_option( 'product_layout', 'no-sidebar' );
			}
		}

		if ( is_home() || is_category() || is_tag() || is_archive() ) {
			return aether_get_option( 'blog_layout', 'sidebar-right' );
		}

		return aether_get_option( 'layout_type', 'boxed' );
	}

	/**
	 * آیا سایدبار نمایش داده شود
	 *
	 * @return bool
	 */
	public static function has_sidebar(): bool {
		$position = apply_filters( 'aether_sidebar_position', 'right' );
		return 'none' !== $position;
	}
}
