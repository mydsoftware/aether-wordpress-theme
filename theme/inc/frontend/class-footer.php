<?php
/**
 * سیستم Footer تم
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Footer
 */
class Footer {

	/**
	 * مقداردهی
	 */
	public function init(): void {
		add_action( 'aether_footer', array( $this, 'render' ) );
	}

	/**
	 * رندر فوتر
	 */
	public function render(): void {
		$columns = (int) aether_get_option( 'footer_columns', 4 );
		$columns = max( 1, min( 4, $columns ) );
		?>
		<footer id="aether-footer" class="aether-footer" role="contentinfo">
			<div class="aether-footer__main">
				<div class="aether-container">
					<div class="aether-footer__widgets aether-footer__widgets--cols-<?php echo esc_attr( (string) $columns ); ?>">
						<?php
						for ( $i = 1; $i <= $columns; $i++ ) {
							$sidebar_id = 'footer-' . $i;
							if ( is_active_sidebar( $sidebar_id ) ) {
								echo '<div class="aether-footer__column">';
								dynamic_sidebar( $sidebar_id );
								echo '</div>';
							}
						}
						?>
					</div>
				</div>
			</div>

			<div class="aether-footer__bottom">
				<div class="aether-container">
					<div class="aether-footer__bottom-inner">
						<div class="aether-footer__copyright">
							<?php
							$copyright = aether_get_option( 'footer_copyright', '' );
							if ( empty( $copyright ) ) {
								$copyright = sprintf(
									/* translators: %1$s: year, %2$s: site name */
									__( '© %1$s %2$s. تمامی حقوق محفوظ است.', 'aether' ),
									gmdate( 'Y' ),
									get_bloginfo( 'name' )
								);
							}
							echo wp_kses_post( $copyright );
							?>
						</div>

						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'aether-footer__menu',
							'depth'          => 1,
							'fallback_cb'    => false,
						) );
						?>

						<?php $this->render_payment_icons(); ?>
					</div>
				</div>
			</div>
		</footer>
		<?php
	}

	/**
	 * آیکون‌های پرداخت
	 */
	private function render_payment_icons(): void {
		$show = aether_get_option( 'footer_payment_icons', true );
		if ( ! $show ) {
			return;
		}
		?>
		<div class="aether-footer__payments" aria-label="<?php esc_attr_e( 'روش‌های پرداخت', 'aether' ); ?>">
			<span class="aether-footer__payment-icon" title="Visa">Visa</span>
			<span class="aether-footer__payment-icon" title="Mastercard">MC</span>
			<span class="aether-footer__payment-icon" title="Zarinpal">زرین‌پال</span>
		</div>
		<?php
	}
}
