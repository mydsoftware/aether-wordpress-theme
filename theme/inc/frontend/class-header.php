<?php
/**
 * سیستم Header تم
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Header
 */
class Header {

	public function init(): void {
		add_action( 'aether_header', array( $this, 'render' ) );
	}

	public function render(): void {
		$preset      = aether_get_option( 'header_preset', 'default' );
		$sticky      = aether_get_option( 'header_sticky', true );
		$transparent = aether_get_option( 'header_transparent', false );
		$topbar      = aether_get_option( 'header_topbar', true );

		$classes = array( 'aether-header' );
		if ( $sticky ) {
			$classes[] = 'aether-header--sticky';
		}
		if ( $transparent ) {
			$classes[] = 'aether-header--transparent';
		}
		$classes[] = 'aether-header--' . sanitize_html_class( $preset );
		?>
		<header id="aether-header" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" role="banner">
			<?php if ( $topbar ) : ?>
				<?php $this->render_topbar(); ?>
			<?php endif; ?>

			<div class="aether-header__main">
				<div class="aether-container">
					<div class="aether-header__inner">
						<?php $this->render_logo(); ?>
						<?php $this->render_navigation(); ?>
						<?php $this->render_actions(); ?>
						<?php $this->render_mobile_toggle(); ?>
					</div>
				</div>
			</div>

			<?php $this->render_mobile_menu(); ?>
		</header>
		<?php
	}

	private function render_topbar(): void {
		$left_text  = aether_get_option( 'topbar_left_text', '' );
		$right_text = aether_get_option( 'topbar_right_text', '' );
		?>
		<div class="aether-header__topbar">
			<div class="aether-container">
				<div class="aether-header__topbar-inner">
					<div class="aether-header__topbar-left">
						<?php if ( $left_text ) : ?>
							<span><?php echo wp_kses_post( $left_text ); ?></span>
						<?php endif; ?>
					</div>
					<div class="aether-header__topbar-right">
						<?php if ( $right_text ) : ?>
							<span><?php echo wp_kses_post( $right_text ); ?></span>
						<?php endif; ?>
						<?php $this->render_social_icons( 'topbar' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	private function render_logo(): void {
		?>
		<div class="aether-header__logo">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="aether-logo-text" rel="home">
					<span class="aether-logo-text__name"><?php bloginfo( 'name' ); ?></span>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}

	private function render_navigation(): void {
		?>
		<nav class="aether-header__nav aether-hidden-mobile" role="navigation" aria-label="<?php esc_attr_e( 'منوی اصلی', 'aether' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'aether-menu aether-menu--primary',
				'fallback_cb'    => array( $this, 'fallback_menu' ),
				'depth'          => 3,
			) );
			?>
		</nav>
		<?php
	}

	public function fallback_menu(): void {
		echo '<ul class="aether-menu aether-menu--primary">';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'خانه', 'aether' ) . '</a></li>';
		if ( aether_is_woocommerce_active() ) {
			echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">' . esc_html__( 'فروشگاه', 'aether' ) . '</a></li>';
		}
		echo '</ul>';
	}

	private function render_actions(): void {
		?>
		<div class="aether-header__actions aether-hidden-mobile">
			<?php if ( aether_get_option( 'header_search', true ) ) : ?>
				<button type="button" class="aether-header__action aether-header__search-toggle" aria-label="<?php esc_attr_e( 'جستجو', 'aether' ); ?>" data-aether-toggle="search">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
				</button>
			<?php endif; ?>

			<?php if ( aether_is_woocommerce_active() && aether_get_option( 'header_account', true ) ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="aether-header__action" aria-label="<?php esc_attr_e( 'حساب کاربری', 'aether' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
				</a>
			<?php endif; ?>

			<?php if ( aether_is_woocommerce_active() && aether_get_option( 'header_cart', true ) ) : ?>
				<?php $this->render_cart_icon(); ?>
			<?php endif; ?>

			<?php
			$cta_text = aether_get_option( 'header_cta_text', '' );
			$cta_url  = aether_get_option( 'header_cta_url', '' );
			if ( $cta_text && $cta_url ) :
				?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="aether-btn aether-btn--primary aether-btn--sm">
					<?php echo esc_html( $cta_text ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}

	private function render_cart_icon(): void {
		$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
		?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="aether-header__action aether-header__cart" aria-label="<?php esc_attr_e( 'سبد خرید', 'aether' ); ?>">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
			<?php if ( $count > 0 ) : ?>
				<span class="aether-header__cart-count" aria-hidden="true"><?php echo esc_html( (string) $count ); ?></span>
			<?php endif; ?>
		</a>
		<?php
	}

	private function render_mobile_toggle(): void {
		?>
		<button type="button" class="aether-header__mobile-toggle aether-hidden-desktop" aria-label="<?php esc_attr_e( 'باز کردن منو', 'aether' ); ?>" aria-expanded="false" data-aether-toggle="mobile-menu">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
		</button>
		<?php
	}

	private function render_mobile_menu(): void {
		?>
		<div class="aether-mobile-menu" id="aether-mobile-menu" hidden>
			<div class="aether-mobile-menu__overlay" data-aether-close="mobile-menu"></div>
			<div class="aether-mobile-menu__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'منوی موبایل', 'aether' ); ?>">
				<div class="aether-mobile-menu__header">
					<span class="aether-mobile-menu__title"><?php esc_html_e( 'منو', 'aether' ); ?></span>
					<button type="button" class="aether-mobile-menu__close" aria-label="<?php esc_attr_e( 'بستن منو', 'aether' ); ?>" data-aether-close="mobile-menu">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
					</button>
				</div>
				<nav class="aether-mobile-menu__nav">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'mobile',
						'container'      => false,
						'menu_class'     => 'aether-menu aether-menu--mobile',
						'fallback_cb'    => array( $this, 'fallback_menu' ),
						'depth'          => 3,
					) );
					?>
				</nav>
			</div>
		</div>
		<?php
	}

	private function render_social_icons( string $location = '' ): void {
		$socials = array(
			'instagram' => aether_get_option( 'social_instagram', '' ),
			'telegram'  => aether_get_option( 'social_telegram', '' ),
			'twitter'   => aether_get_option( 'social_twitter', '' ),
			'linkedin'  => aether_get_option( 'social_linkedin', '' ),
		);

		$has_any = array_filter( $socials );
		if ( empty( $has_any ) ) {
			return;
		}

		echo '<div class="aether-social-icons">';
		foreach ( $socials as $network => $url ) {
			if ( empty( $url ) ) {
				continue;
			}
			printf(
				'<a href="%s" class="aether-social-icons__item aether-social-icons__item--%s" target="_blank" rel="noopener noreferrer" aria-label="%s"></a>',
				esc_url( $url ),
				esc_attr( $network ),
				esc_attr( ucfirst( $network ) )
			);
		}
		echo '</div>';
	}
}
