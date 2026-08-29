<?php
/**
 * مدیریت Assets تم (CSS/JS)
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Assets
 */
class Assets {

	public function init(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'wp_head', array( $this, 'preload_fonts' ), 1 );
	}

	public function enqueue_frontend_assets(): void {
		wp_enqueue_style(
			'aether-style',
			get_stylesheet_uri(),
			array(),
			AETHER_VERSION
		);

		wp_enqueue_style(
			'aether-vazirmatn',
			'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css',
			array(),
			'33.003'
		);

		wp_enqueue_style(
			'aether-components',
			aether_asset_url( 'css/components.css' ),
			array( 'aether-style' ),
			AETHER_VERSION
		);

		if ( aether_is_woocommerce_active() ) {
			wp_enqueue_style(
				'aether-woocommerce',
				aether_asset_url( 'css/woocommerce.css' ),
				array( 'aether-style' ),
				AETHER_VERSION
			);
		}

		wp_enqueue_script(
			'aether-main',
			aether_asset_url( 'js/main.js' ),
			array(),
			AETHER_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);

		wp_localize_script(
			'aether-main',
			'aetherData',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'restUrl'  => esc_url_raw( rest_url( 'aether/v1/' ) ),
				'nonce'    => wp_create_nonce( 'aether_nonce' ),
				'isRtl'    => is_rtl(),
				'themeUri' => AETHER_URI,
				'version'  => AETHER_VERSION,
				'i18n'     => array(
					'loading'     => __( 'در حال بارگذاری...', 'aether' ),
					'error'       => __( 'خطایی رخ داد.', 'aether' ),
					'addedToCart' => __( 'به سبد خرید اضافه شد', 'aether' ),
					'viewCart'    => __( 'مشاهده سبد خرید', 'aether' ),
				),
			)
		);

		if ( aether_is_woocommerce_active() ) {
			wp_enqueue_script(
				'aether-woocommerce',
				aether_asset_url( 'js/woocommerce.js' ),
				array( 'aether-main', 'jquery' ),
				AETHER_VERSION,
				array( 'strategy' => 'defer', 'in_footer' => true )
			);
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public function enqueue_admin_assets( string $hook ): void {
		$allowed = array( 'toplevel_page_aether-dashboard', 'aether_page_aether-settings' );
		if ( strpos( $hook, 'aether' ) === false && ! in_array( $hook, $allowed, true ) ) {
			return;
		}

		wp_enqueue_style(
			'aether-admin',
			aether_asset_url( 'css/admin.css' ),
			array(),
			AETHER_VERSION
		);

		wp_enqueue_script(
			'aether-admin',
			aether_asset_url( 'js/admin.js' ),
			array( 'jquery', 'wp-color-picker' ),
			AETHER_VERSION,
			true
		);

		wp_enqueue_style( 'wp-color-picker' );

		wp_localize_script(
			'aether-admin',
			'aetherAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'restUrl' => esc_url_raw( rest_url( 'aether/v1/' ) ),
				'nonce'   => wp_create_nonce( 'aether_admin_nonce' ),
				'i18n'    => array(
					'saved'   => __( 'تنظیمات ذخیره شد.', 'aether' ),
					'error'   => __( 'خطا در ذخیره تنظیمات.', 'aether' ),
					'confirm' => __( 'آیا مطمئن هستید؟', 'aether' ),
				),
			)
		);
	}

	public function preload_fonts(): void {
		// فونت‌های محلی در آینده
	}
}
