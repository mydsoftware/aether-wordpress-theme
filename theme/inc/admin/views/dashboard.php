<?php
/**
 * صفحه داشبورد ادمین تم
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$version = AETHER_VERSION;
$license_status = get_option( 'aether_license_status', 'inactive' );
?>
<div class="wrap aether-admin-wrap">
	<div class="aether-admin-header">
		<h1><?php esc_html_e( 'داشبورد Aether', 'aether' ); ?></h1>
		<p class="aether-admin-version"><?php printf( esc_html__( 'نسخه %s', 'aether' ), esc_html( $version ) ); ?></p>
	</div>

	<div class="aether-admin-cards">
		<div class="aether-admin-card">
			<h2><?php esc_html_e( 'وضعیت لایسنس', 'aether' ); ?></h2>
			<p>
				<?php if ( 'active' === $license_status ) : ?>
					<span class="aether-badge aether-badge--success"><?php esc_html_e( 'فعال', 'aether' ); ?></span>
				<?php else : ?>
					<span class="aether-badge aether-badge--warning"><?php esc_html_e( 'غیرفعال', 'aether' ); ?></span>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=aether-license' ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'فعال‌سازی لایسنس', 'aether' ); ?>
					</a>
				<?php endif; ?>
			</p>
		</div>

		<div class="aether-admin-card">
			<h2><?php esc_html_e( 'شروع سریع', 'aether' ); ?></h2>
			<ul>
				<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=aether-settings' ) ); ?>"><?php esc_html_e( 'تنظیمات تم', 'aether' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=aether-demos' ) ); ?>"><?php esc_html_e( 'وارد کردن دمو', 'aether' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'سفارشی‌سازی زنده', 'aether' ); ?></a></li>
			</ul>
		</div>

		<div class="aether-admin-card">
			<h2><?php esc_html_e( 'وضعیت سیستم', 'aether' ); ?></h2>
			<ul class="aether-system-status">
				<li><?php esc_html_e( 'وردپرس:', 'aether' ); ?> <strong><?php echo esc_html( get_bloginfo( 'version' ) ); ?></strong></li>
				<li><?php esc_html_e( 'PHP:', 'aether' ); ?> <strong><?php echo esc_html( PHP_VERSION ); ?></strong></li>
				<li>
					<?php esc_html_e( 'ووکامرس:', 'aether' ); ?>
					<strong>
						<?php
						if ( class_exists( 'WooCommerce' ) ) {
							echo esc_html( WC()->version );
						} else {
							esc_html_e( 'نصب نشده', 'aether' );
						}
						?>
					</strong>
				</li>
			</ul>
		</div>

		<div class="aether-admin-card">
			<h2><?php esc_html_e( 'مستندات', 'aether' ); ?></h2>
			<p><?php esc_html_e( 'برای راهنمای کامل استفاده از تم، مستندات را مطالعه کنید.', 'aether' ); ?></p>
			<a href="https://aether.theme/docs" target="_blank" class="button" rel="noopener noreferrer">
				<?php esc_html_e( 'مشاهده مستندات', 'aether' ); ?>
			</a>
		</div>
	</div>
</div>
