<?php
declare(strict_types=1);
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Aether_Demo_Settings {
	public function import( string $demo_id, string $demo_path ): void {
		$base = array(
			'layout_type' => 'full-width', 'dark_mode' => 'auto',
			'header_preset' => 'default', 'header_sticky' => true, 'header_transparent' => false,
			'header_topbar' => true, 'header_search' => true, 'header_account' => true, 'header_cart' => true,
			'header_cta_text' => 'فروشگاه', 'header_cta_url' => home_url( '/shop/' ),
			'topbar_left_text' => 'ارسال رایگان برای سفارش‌های بالای ۵۰۰ هزار تومان',
			'topbar_right_text' => 'پشتیبانی: ۰۲۱-۱۲۳۴۵۶۷۸',
			'footer_columns' => 4, 'footer_copyright' => '© ' . gmdate( 'Y' ) . ' تمامی حقوق محفوظ است.',
			'footer_payment_icons' => true,
			'color_primary' => '#0f172a', 'color_secondary' => '#6366f1', 'color_accent' => '#f59e0b',
			'font_family' => 'vazirmatn', 'font_size_base' => '16',
			'shop_layout' => 'sidebar-right', 'shop_columns' => 4, 'product_layout' => 'no-sidebar',
			'products_per_page' => 12, 'blog_layout' => 'sidebar-right', 'lazy_load' => true,
			'social_instagram' => 'https://instagram.com/', 'social_telegram' => 'https://t.me/',
		);
		$json_file = trailingslashit( $demo_path ) . 'settings.json';
		if ( $demo_path && file_exists( $json_file ) ) {
			$file_data = json_decode( (string) file_get_contents( $json_file ), true );
			if ( is_array( $file_data ) ) { $base = array_merge( $base, $file_data ); }
		}
		update_option( 'aether_options', $base );
	}
}
