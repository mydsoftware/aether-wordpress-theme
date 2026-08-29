<?php
/**
 * فرم جستجو
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="aether-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="aether-sr-only" for="aether-search-field"><?php esc_html_e( 'جستجو', 'aether' ); ?></label>
	<input type="search" id="aether-search-field" class="aether-input" placeholder="<?php esc_attr_e( 'جستجو...', 'aether' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	<button type="submit" class="aether-btn aether-btn--primary aether-btn--sm">
		<?php esc_html_e( 'جستجو', 'aether' ); ?>
	</button>
</form>
