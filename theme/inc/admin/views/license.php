<?php
/**
 * صفحه لایسنس
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$status = get_option( 'aether_license_status', 'inactive' );
$key    = get_option( 'aether_license_key', '' );
?>
<div class="wrap aether-admin-wrap">
	<h1><?php esc_html_e( 'لایسنس Aether', 'aether' ); ?></h1>

	<div class="aether-admin-card" style="max-width: 600px; margin-top: 20px;">
		<form method="post" action="">
			<?php wp_nonce_field( 'aether_license_action', 'aether_license_nonce' ); ?>
			<table class="form-table">
				<tr>
					<th><label for="license_key"><?php esc_html_e( 'کلید لایسنس', 'aether' ); ?></label></th>
					<td>
						<input type="text" name="license_key" id="license_key" value="<?php echo esc_attr( $key ); ?>" class="regular-text" placeholder="XXXX-XXXX-XXXX-XXXX">
					</td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'وضعیت', 'aether' ); ?></th>
					<td>
						<?php if ( 'active' === $status ) : ?>
							<span class="aether-badge aether-badge--success"><?php esc_html_e( 'فعال', 'aether' ); ?></span>
						<?php else : ?>
							<span class="aether-badge aether-badge--warning"><?php esc_html_e( 'غیرفعال', 'aether' ); ?></span>
						<?php endif; ?>
					</td>
				</tr>
			</table>
			<p>
				<button type="submit" name="aether_activate_license" class="button button-primary">
					<?php esc_html_e( 'فعال‌سازی', 'aether' ); ?>
				</button>
				<?php if ( 'active' === $status ) : ?>
					<button type="submit" name="aether_deactivate_license" class="button">
						<?php esc_html_e( 'غیرفعال‌سازی', 'aether' ); ?>
					</button>
				<?php endif; ?>
			</p>
		</form>
		<p class="description">
			<?php esc_html_e( 'سیستم لایسنس به صورت modular طراحی شده و آماده اتصال به سرور لایسنس است.', 'aether' ); ?>
		</p>
	</div>
</div>
