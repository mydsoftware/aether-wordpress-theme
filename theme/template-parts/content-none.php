<?php
/**
 * قالب عدم وجود محتوا
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="aether-no-results">
	<header class="aether-no-results__header">
		<h1 class="aether-no-results__title"><?php esc_html_e( 'مطلبی یافت نشد', 'aether' ); ?></h1>
	</header>
	<div class="aether-no-results__content">
		<p><?php esc_html_e( 'متأسفانه چیزی مطابق جستجوی شما پیدا نشد. لطفاً دوباره تلاش کنید.', 'aether' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</section>
