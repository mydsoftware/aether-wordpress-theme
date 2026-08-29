<?php
/**
 * یکپارچه‌سازی ووکامرس
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس WooCommerce
 */
class WooCommerce {

	public function init(): void {
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'dequeue_styles' ) );
		add_filter( 'loop_shop_columns', array( $this, 'shop_columns' ) );
		add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ) );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
		add_action( 'woocommerce_before_main_content', array( $this, 'wrapper_start' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'wrapper_end' ), 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		add_action( 'woocommerce_before_main_content', array( $this, 'breadcrumb' ), 20 );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_count_fragment' ) );
	}

	public function dequeue_styles( array $styles ): array {
		return $styles;
	}

	public function shop_columns(): int {
		return (int) aether_get_option( 'shop_columns', 3 );
	}

	public function products_per_page(): int {
		return (int) aether_get_option( 'products_per_page', 12 );
	}

	public function related_products_args( array $args ): array {
		$args['posts_per_page'] = 4;
		$args['columns']        = 4;
		return $args;
	}

	public function wrapper_start(): void {
		echo '<div class="aether-container"><div class="aether-content-area aether-woo-content">';
		echo '<div class="aether-main-content">';
	}

	public function wrapper_end(): void {
		echo '</div>';
		if ( \Aether\Frontend\Layout::has_sidebar() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
			echo '<aside class="aether-sidebar aether-shop-sidebar" role="complementary">';
			dynamic_sidebar( 'sidebar-shop' );
			echo '</aside>';
		}
		echo '</div></div>';
	}

	public function breadcrumb(): void {
		if ( function_exists( 'woocommerce_breadcrumb' ) ) {
			woocommerce_breadcrumb( array(
				'wrap_before' => '<nav class="aether-breadcrumb" aria-label="' . esc_attr__( 'مسیر راهنما', 'aether' ) . '">',
				'wrap_after'  => '</nav>',
				'delimiter'   => '<span class="aether-breadcrumb__sep">/</span>',
			) );
		}
	}

	public function cart_count_fragment( array $fragments ): array {
		$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
		$fragments['.aether-header__cart-count'] = '<span class="aether-header__cart-count">' . esc_html( (string) $count ) . '</span>';
		return $fragments;
	}
}
