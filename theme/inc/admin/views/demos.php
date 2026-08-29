<?php
/**
 * صفحه دموها
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$demos = array(
	array( 'id' => 'general', 'name' => 'فروشگاه عمومی', 'category' => 'ecommerce' ),
	array( 'id' => 'fashion', 'name' => 'مد و پوشاک', 'category' => 'ecommerce' ),
	array( 'id' => 'electronics', 'name' => 'الکترونیک', 'category' => 'ecommerce' ),
	array( 'id' => 'cosmetics', 'name' => 'لوازم آرایشی', 'category' => 'ecommerce' ),
	array( 'id' => 'furniture', 'name' => 'مبلمان', 'category' => 'ecommerce' ),
	array( 'id' => 'digital', 'name' => 'محصولات دیجیتال', 'category' => 'ecommerce' ),
	array( 'id' => 'corporate', 'name' => 'شرکتی', 'category' => 'business' ),
	array( 'id' => 'services', 'name' => 'خدمات', 'category' => 'business' ),
	array( 'id' => 'personal', 'name' => 'شخصی', 'category' => 'personal' ),
	array( 'id' => 'landing', 'name' => 'لندینگ پیج', 'category' => 'landing' ),
);
?>
<div class="wrap aether-admin-wrap">
	<h1><?php esc_html_e( 'دموهای آماده', 'aether' ); ?></h1>
	<p><?php esc_html_e( 'یکی از دموهای زیر را انتخاب و با یک کلیک وارد کنید.', 'aether' ); ?></p>

	<div class="aether-admin-cards" style="margin-top: 24px;">
		<?php foreach ( $demos as $demo ) : ?>
			<div class="aether-admin-card">
				<h2><?php echo esc_html( $demo['name'] ); ?></h2>
				<p><span class="aether-badge"><?php echo esc_html( $demo['category'] ); ?></span></p>
				<p>
					<button type="button" class="button button-primary aether-import-demo" data-demo="<?php echo esc_attr( $demo['id'] ); ?>" disabled>
						<?php esc_html_e( 'وارد کردن (به زودی)', 'aether' ); ?>
					</button>
				</p>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="notice notice-info" style="margin-top: 24px;">
		<p><?php esc_html_e( 'سیستم Demo Importer کامل در نسخه بعدی فعال خواهد شد. ساختار و API آن آماده است.', 'aether' ); ?></p>
	</div>
</div>
