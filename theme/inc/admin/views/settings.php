<?php
/**
 * صفحه تنظیمات تم
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options  = get_option( 'aether_options', array() );
$defaults = ( new \Aether\Admin\Admin() )->get_defaults();
$options  = wp_parse_args( $options, $defaults );
?>
<div class="wrap aether-admin-wrap">
	<h1><?php esc_html_e( 'تنظیمات Aether', 'aether' ); ?></h1>

	<form method="post" action="options.php" id="aether-settings-form">
		<?php settings_fields( 'aether_options_group' ); ?>

		<div class="aether-settings-tabs">
			<nav class="aether-settings-nav" role="tablist">
				<button type="button" class="aether-settings-nav__item is-active" data-tab="general"><?php esc_html_e( 'عمومی', 'aether' ); ?></button>
				<button type="button" class="aether-settings-nav__item" data-tab="header"><?php esc_html_e( 'هدر', 'aether' ); ?></button>
				<button type="button" class="aether-settings-nav__item" data-tab="footer"><?php esc_html_e( 'فوتر', 'aether' ); ?></button>
				<button type="button" class="aether-settings-nav__item" data-tab="colors"><?php esc_html_e( 'رنگ‌ها', 'aether' ); ?></button>
				<button type="button" class="aether-settings-nav__item" data-tab="woocommerce"><?php esc_html_e( 'ووکامرس', 'aether' ); ?></button>
				<button type="button" class="aether-settings-nav__item" data-tab="performance"><?php esc_html_e( 'عملکرد', 'aether' ); ?></button>
				<button type="button" class="aether-settings-nav__item" data-tab="custom"><?php esc_html_e( 'سفارشی', 'aether' ); ?></button>
			</nav>

			<div class="aether-settings-panels">
				<div class="aether-settings-panel is-active" id="tab-general">
					<table class="form-table">
						<tr>
							<th><label for="layout_type"><?php esc_html_e( 'نوع چیدمان', 'aether' ); ?></label></th>
							<td>
								<select name="aether_options[layout_type]" id="layout_type">
									<option value="boxed" <?php selected( $options['layout_type'], 'boxed' ); ?>><?php esc_html_e( 'Boxed', 'aether' ); ?></option>
									<option value="full-width" <?php selected( $options['layout_type'], 'full-width' ); ?>><?php esc_html_e( 'Full Width', 'aether' ); ?></option>
									<option value="sidebar-left" <?php selected( $options['layout_type'], 'sidebar-left' ); ?>><?php esc_html_e( 'سایدبار چپ', 'aether' ); ?></option>
									<option value="sidebar-right" <?php selected( $options['layout_type'], 'sidebar-right' ); ?>><?php esc_html_e( 'سایدبار راست', 'aether' ); ?></option>
									<option value="no-sidebar" <?php selected( $options['layout_type'], 'no-sidebar' ); ?>><?php esc_html_e( 'بدون سایدبار', 'aether' ); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="dark_mode"><?php esc_html_e( 'حالت تاریک', 'aether' ); ?></label></th>
							<td>
								<select name="aether_options[dark_mode]" id="dark_mode">
									<option value="auto" <?php selected( $options['dark_mode'], 'auto' ); ?>><?php esc_html_e( 'خودکار', 'aether' ); ?></option>
									<option value="light" <?php selected( $options['dark_mode'], 'light' ); ?>><?php esc_html_e( 'روشن', 'aether' ); ?></option>
									<option value="dark" <?php selected( $options['dark_mode'], 'dark' ); ?>><?php esc_html_e( 'تاریک', 'aether' ); ?></option>
								</select>
							</td>
						</tr>
					</table>
				</div>

				<div class="aether-settings-panel" id="tab-header">
					<table class="form-table">
						<tr>
							<th><label for="header_sticky"><?php esc_html_e( 'هدر چسبان', 'aether' ); ?></label></th>
							<td><input type="checkbox" name="aether_options[header_sticky]" id="header_sticky" value="1" <?php checked( $options['header_sticky'] ); ?>></td>
						</tr>
						<tr>
							<th><label for="header_topbar"><?php esc_html_e( 'نمایش تاپ‌بار', 'aether' ); ?></label></th>
							<td><input type="checkbox" name="aether_options[header_topbar]" id="header_topbar" value="1" <?php checked( $options['header_topbar'] ); ?>></td>
						</tr>
						<tr>
							<th><label for="header_search"><?php esc_html_e( 'نمایش جستجو', 'aether' ); ?></label></th>
							<td><input type="checkbox" name="aether_options[header_search]" id="header_search" value="1" <?php checked( $options['header_search'] ); ?>></td>
						</tr>
						<tr>
							<th><label for="header_cart"><?php esc_html_e( 'نمایش سبد خرید', 'aether' ); ?></label></th>
							<td><input type="checkbox" name="aether_options[header_cart]" id="header_cart" value="1" <?php checked( $options['header_cart'] ); ?>></td>
						</tr>
						<tr>
							<th><label for="header_cta_text"><?php esc_html_e( 'متن دکمه CTA', 'aether' ); ?></label></th>
							<td><input type="text" name="aether_options[header_cta_text]" id="header_cta_text" value="<?php echo esc_attr( $options['header_cta_text'] ); ?>" class="regular-text"></td>
						</tr>
						<tr>
							<th><label for="header_cta_url"><?php esc_html_e( 'لینک دکمه CTA', 'aether' ); ?></label></th>
							<td><input type="url" name="aether_options[header_cta_url]" id="header_cta_url" value="<?php echo esc_url( $options['header_cta_url'] ); ?>" class="regular-text"></td>
						</tr>
					</table>
				</div>

				<div class="aether-settings-panel" id="tab-footer">
					<table class="form-table">
						<tr>
							<th><label for="footer_columns"><?php esc_html_e( 'تعداد ستون‌ها', 'aether' ); ?></label></th>
							<td>
								<select name="aether_options[footer_columns]" id="footer_columns">
									<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
										<option value="<?php echo esc_attr( (string) $i ); ?>" <?php selected( $options['footer_columns'], $i ); ?>><?php echo esc_html( (string) $i ); ?></option>
									<?php endfor; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="footer_copyright"><?php esc_html_e( 'متن کپی‌رایت', 'aether' ); ?></label></th>
							<td><textarea name="aether_options[footer_copyright]" id="footer_copyright" rows="3" class="large-text"><?php echo esc_textarea( $options['footer_copyright'] ); ?></textarea></td>
						</tr>
					</table>
				</div>

				<div class="aether-settings-panel" id="tab-colors">
					<table class="form-table">
						<tr>
							<th><label for="color_primary"><?php esc_html_e( 'رنگ اصلی', 'aether' ); ?></label></th>
							<td><input type="text" name="aether_options[color_primary]" id="color_primary" value="<?php echo esc_attr( $options['color_primary'] ); ?>" class="aether-color-picker"></td>
						</tr>
						<tr>
							<th><label for="color_secondary"><?php esc_html_e( 'رنگ ثانویه', 'aether' ); ?></label></th>
							<td><input type="text" name="aether_options[color_secondary]" id="color_secondary" value="<?php echo esc_attr( $options['color_secondary'] ); ?>" class="aether-color-picker"></td>
						</tr>
						<tr>
							<th><label for="color_accent"><?php esc_html_e( 'رنگ تاکیدی', 'aether' ); ?></label></th>
							<td><input type="text" name="aether_options[color_accent]" id="color_accent" value="<?php echo esc_attr( $options['color_accent'] ); ?>" class="aether-color-picker"></td>
						</tr>
					</table>
				</div>

				<div class="aether-settings-panel" id="tab-woocommerce">
					<table class="form-table">
						<tr>
							<th><label for="shop_layout"><?php esc_html_e( 'چیدمان فروشگاه', 'aether' ); ?></label></th>
							<td>
								<select name="aether_options[shop_layout]" id="shop_layout">
									<option value="sidebar-right" <?php selected( $options['shop_layout'], 'sidebar-right' ); ?>><?php esc_html_e( 'سایدبار راست', 'aether' ); ?></option>
									<option value="sidebar-left" <?php selected( $options['shop_layout'], 'sidebar-left' ); ?>><?php esc_html_e( 'سایدبار چپ', 'aether' ); ?></option>
									<option value="full-width" <?php selected( $options['shop_layout'], 'full-width' ); ?>><?php esc_html_e( 'تمام عرض', 'aether' ); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="shop_columns"><?php esc_html_e( 'تعداد ستون محصولات', 'aether' ); ?></label></th>
							<td>
								<select name="aether_options[shop_columns]" id="shop_columns">
									<?php for ( $i = 2; $i <= 5; $i++ ) : ?>
										<option value="<?php echo esc_attr( (string) $i ); ?>" <?php selected( $options['shop_columns'], $i ); ?>><?php echo esc_html( (string) $i ); ?></option>
									<?php endfor; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="products_per_page"><?php esc_html_e( 'تعداد محصول در صفحه', 'aether' ); ?></label></th>
							<td><input type="number" name="aether_options[products_per_page]" id="products_per_page" value="<?php echo esc_attr( (string) $options['products_per_page'] ); ?>" min="1" max="100"></td>
						</tr>
					</table>
				</div>

				<div class="aether-settings-panel" id="tab-performance">
					<table class="form-table">
						<tr>
							<th><label for="lazy_load"><?php esc_html_e( 'بارگذاری تنبل تصاویر', 'aether' ); ?></label></th>
							<td><input type="checkbox" name="aether_options[lazy_load]" id="lazy_load" value="1" <?php checked( $options['lazy_load'] ); ?>></td>
						</tr>
					</table>
				</div>

				<div class="aether-settings-panel" id="tab-custom">
					<table class="form-table">
						<tr>
							<th><label for="custom_css"><?php esc_html_e( 'CSS سفارشی', 'aether' ); ?></label></th>
							<td><textarea name="aether_options[custom_css]" id="custom_css" rows="12" class="large-text code"><?php echo esc_textarea( $options['custom_css'] ); ?></textarea></td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<?php submit_button( __( 'ذخیره تنظیمات', 'aether' ) ); ?>
	</form>
</div>
