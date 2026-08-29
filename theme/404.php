<?php
/**
 * صفحه ۴۰۴
 *
 * @package Aether
 */

get_header();
?>

<div class="aether-container">
	<section class="aether-no-results" style="text-align: center; padding: 4rem 0;">
		<h1 style="font-size: 6rem; margin: 0; color: var(--aether-color-text-muted);">404</h1>
		<h2><?php esc_html_e( 'صفحه یافت نشد', 'aether' ); ?></h2>
		<p><?php esc_html_e( 'متأسفانه صفحه مورد نظر شما وجود ندارد یا منتقل شده است.', 'aether' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="aether-btn aether-btn--primary">
			<?php esc_html_e( 'بازگشت به خانه', 'aether' ); ?>
		</a>
	</section>
</div>

<?php
get_footer();
