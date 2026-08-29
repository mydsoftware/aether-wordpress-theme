<?php
declare(strict_types=1);
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Aether_Demo_Importer {
	private static ?self $instance = null;
	private array $steps = array( 'init', 'settings', 'categories', 'products', 'pages', 'elementor', 'menus', 'widgets', 'finalize' );

	public static function get_instance(): self {
		if ( null === self::$instance ) { self::$instance = new self(); }
		return self::$instance;
	}

	public function init(): void {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'aether_demo_import_enabled', '__return_true' );
	}

	public function enqueue_scripts( string $hook ): void {
		if ( strpos( $hook, 'aether-demos' ) === false ) { return; }
		wp_enqueue_script( 'aether-demo-importer', AETHER_DEMO_URI . 'assets/demo-importer.js', array( 'jquery' ), AETHER_DEMO_VERSION, true );
		wp_localize_script( 'aether-demo-importer', 'aetherDemo', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'aether_admin_nonce' ),
			'steps'   => $this->steps,
			'i18n'    => array(
				'importing' => __( 'در حال وارد کردن...', 'aether-demo' ),
				'success'   => __( 'دمو با موفقیت وارد شد!', 'aether-demo' ),
				'error'     => __( 'خطا در واردات دمو', 'aether-demo' ),
				'confirm'   => __( 'آیا مطمئن هستید؟ داده‌های فعلی ممکن است بازنویسی شوند.', 'aether-demo' ),
			),
		) );
	}

	public function run_step( string $demo_id, string $step ) {
		$demo_path = $this->resolve_demo_path( $demo_id );
		switch ( $step ) {
			case 'init':
				return array( 'step' => 'init', 'next' => 'settings', 'progress' => 5, 'message' => __( 'شروع واردات...', 'aether-demo' ) );
			case 'settings':
				( new Aether_Demo_Settings() )->import( $demo_id, $demo_path );
				return array( 'step' => 'settings', 'next' => 'categories', 'progress' => 15, 'message' => __( 'تنظیمات تم اعمال شد', 'aether-demo' ) );
			case 'categories':
				$count = ( new Aether_Demo_WooCommerce() )->import_categories( $demo_id );
				return array( 'step' => 'categories', 'next' => 'products', 'progress' => 25, 'message' => sprintf( __( '%d دسته‌بندی ایجاد شد', 'aether-demo' ), $count ) );
			case 'products':
				$count = ( new Aether_Demo_WooCommerce() )->import_products( $demo_id );
				return array( 'step' => 'products', 'next' => 'pages', 'progress' => 50, 'message' => sprintf( __( '%d محصول وارد شد', 'aether-demo' ), $count ) );
			case 'pages':
				$count = ( new Aether_Demo_Content() )->import_pages( $demo_id, $demo_path );
				return array( 'step' => 'pages', 'next' => 'elementor', 'progress' => 70, 'message' => sprintf( __( '%d صفحه ایجاد شد', 'aether-demo' ), $count ) );
			case 'elementor':
				$count = ( new Aether_Demo_Elementor() )->import( $demo_id, $demo_path );
				return array( 'step' => 'elementor', 'next' => 'menus', 'progress' => 85, 'message' => sprintf( __( 'محتوای Elementor برای %d صفحه', 'aether-demo' ), $count ) );
			case 'menus':
				( new Aether_Demo_Content() )->import_menus( $demo_id );
				return array( 'step' => 'menus', 'next' => 'widgets', 'progress' => 92, 'message' => __( 'منوها ایجاد شدند', 'aether-demo' ) );
			case 'widgets':
				( new Aether_Demo_Content() )->import_widgets( $demo_id );
				return array( 'step' => 'widgets', 'next' => 'finalize', 'progress' => 96, 'message' => __( 'ویجت‌ها تنظیم شدند', 'aether-demo' ) );
			case 'finalize':
				update_option( 'aether_demo_imported', $demo_id );
				update_option( 'show_on_front', 'page' );
				$home_id = get_option( 'aether_demo_home_page_id' );
				if ( $home_id ) { update_option( 'page_on_front', $home_id ); }
				$blog_id = get_option( 'aether_demo_blog_page_id' );
				if ( $blog_id ) { update_option( 'page_for_posts', $blog_id ); }
				if ( class_exists( '\Elementor\Plugin' ) ) {
					\Elementor\Plugin::$instance->files_manager->clear_cache();
				}
				return array( 'step' => 'finalize', 'next' => null, 'progress' => 100, 'message' => __( 'واردات کامل شد!', 'aether-demo' ), 'done' => true );
			default:
				return new WP_Error( 'invalid_step', __( 'مرحله نامعتبر', 'aether-demo' ) );
		}
	}

	private function resolve_demo_path( string $demo_id ): string {
		$paths = array(
			get_template_directory() . '/demos/' . $demo_id,
			dirname( get_template_directory() ) . '/demos/' . $demo_id,
		);
		foreach ( $paths as $p ) {
			if ( is_dir( $p ) ) { return $p; }
		}
		return '';
	}
}
