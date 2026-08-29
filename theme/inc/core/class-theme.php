<?php
/**
 * کلاس اصلی تم Aether
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Theme - نقطه ورود اصلی
 */
final class Theme {

	/**
	 * نمونه Singleton
	 *
	 * @var Theme|null
	 */
	private static ?Theme $instance = null;

	/**
	 * دریافت نمونه
	 *
	 * @return Theme
	 */
	public static function get_instance(): Theme {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * سازنده خصوصی
	 */
	private function __construct() {}

	/**
	 * مقداردهی اولیه تم
	 */
	public function init(): void {
		$this->setup_theme_supports();
		$this->load_modules();
		$this->register_hooks();
	}

	/**
	 * تنظیم پشتیبانی‌های تم
	 */
	private function setup_theme_supports(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		) );
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'wp-block-styles' );

		// پشتیبانی ووکامرس
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// اندازه تصاویر
		add_image_size( 'aether-product', 600, 600, true );
		add_image_size( 'aether-product-thumb', 300, 300, true );
		add_image_size( 'aether-blog', 800, 500, true );
		add_image_size( 'aether-hero', 1920, 800, true );

		// منوها
		register_nav_menus( array(
			'primary'   => __( 'منوی اصلی', 'aether' ),
			'secondary' => __( 'منوی ثانویه', 'aether' ),
			'footer'    => __( 'منوی فوتر', 'aether' ),
			'mobile'    => __( 'منوی موبایل', 'aether' ),
			'account'   => __( 'منوی حساب کاربری', 'aether' ),
		) );

		$this->register_sidebars();
	}

	/**
	 * ثبت سایدبارها
	 */
	private function register_sidebars(): void {
		$sidebars = array(
			array(
				'id'          => 'sidebar-main',
				'name'        => __( 'سایدبار اصلی', 'aether' ),
				'description' => __( 'سایدبار پیش‌فرض صفحات', 'aether' ),
			),
			array(
				'id'          => 'sidebar-shop',
				'name'        => __( 'سایدبار فروشگاه', 'aether' ),
				'description' => __( 'سایدبار صفحات فروشگاه', 'aether' ),
			),
			array(
				'id'          => 'sidebar-blog',
				'name'        => __( 'سایدبار وبلاگ', 'aether' ),
				'description' => __( 'سایدبار صفحات وبلاگ', 'aether' ),
			),
			array(
				'id'          => 'footer-1',
				'name'        => __( 'فوتر ستون ۱', 'aether' ),
				'description' => __( 'ستون اول فوتر', 'aether' ),
			),
			array(
				'id'          => 'footer-2',
				'name'        => __( 'فوتر ستون ۲', 'aether' ),
				'description' => __( 'ستون دوم فوتر', 'aether' ),
			),
			array(
				'id'          => 'footer-3',
				'name'        => __( 'فوتر ستون ۳', 'aether' ),
				'description' => __( 'ستون سوم فوتر', 'aether' ),
			),
			array(
				'id'          => 'footer-4',
				'name'        => __( 'فوتر ستون ۴', 'aether' ),
				'description' => __( 'ستون چهارم فوتر', 'aether' ),
			),
		);

		foreach ( $sidebars as $sidebar ) {
			register_sidebar( array(
				'id'            => $sidebar['id'],
				'name'          => $sidebar['name'],
				'description'   => $sidebar['description'],
				'before_widget' => '<div id="%1$s" class="aether-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="aether-widget__title">',
				'after_title'   => '</h3>',
			) );
		}
	}

	/**
	 * بارگذاری ماژول‌ها
	 */
	private function load_modules(): void {
		$modules = array(
			'Aether\\Frontend\\Assets',
			'Aether\\Frontend\\Header',
			'Aether\\Frontend\\Footer',
			'Aether\\Frontend\\Layout',
			'Aether\\Admin\\Admin',
			'Aether\\Admin\\Onboarding',
			'Aether\\Api\\Rest_Api',
			'Aether\\Security\\Security',
			'Aether\\Compatibility\\Compatibility',
		);

		if ( aether_is_woocommerce_active() ) {
			$modules[] = 'Aether\\WooCommerce\\WooCommerce';
		}

		foreach ( $modules as $module ) {
			if ( class_exists( $module ) ) {
				$instance = new $module();
				if ( method_exists( $instance, 'init' ) ) {
					$instance->init();
				}
			}
		}
	}

	/**
	 * ثبت هوک‌های عمومی
	 */
	private function register_hooks(): void {
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_action( 'wp_head', array( $this, 'dark_mode_script' ), 1 );
	}

	/**
	 * کلاس‌های body
	 *
	 * @param array $classes کلاس‌ها.
	 * @return array
	 */
	public function body_classes( array $classes ): array {
		$classes[] = 'aether-theme';
		$classes[] = 'aether-v' . str_replace( '.', '-', AETHER_VERSION );

		if ( aether_is_rtl() ) {
			$classes[] = 'aether-rtl';
		}

		$layout = aether_get_option( 'layout_type', 'boxed' );
		$classes[] = 'aether-layout-' . sanitize_html_class( $layout );

		$header_sticky = aether_get_option( 'header_sticky', true );
		if ( $header_sticky ) {
			$classes[] = 'aether-header-sticky';
		}

		return $classes;
	}

	/**
	 * اسکریپت اولیه dark mode برای جلوگیری از چشمک
	 */
	public function dark_mode_script(): void {
		$dark_mode = aether_get_option( 'dark_mode', 'auto' );
		?>
		<script>
		(function() {
			var mode = '<?php echo esc_js( $dark_mode ); ?>';
			var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
			var theme = mode === 'dark' || (mode === 'auto' && prefersDark) ? 'dark' : 'light';
			document.documentElement.setAttribute('data-theme', theme);
		})();
		</script>
		<?php
	}
}
