<?php
/**
 * سایدبار پیش‌فرض
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
	return;
}
?>
<aside id="secondary" class="aether-sidebar widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
</aside>
