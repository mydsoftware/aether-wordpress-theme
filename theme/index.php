<?php
/**
 * قالب اصلی
 *
 * @package Aether
 */

get_header();
?>

<div class="aether-container">
	<div class="aether-content-area <?php echo esc_attr( implode( ' ', apply_filters( 'aether_content_classes', array() ) ) ); ?>">
		<div class="aether-main-content">
			<?php if ( have_posts() ) : ?>
				<div class="aether-posts">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					?>
				</div>
				<?php
				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => __( 'قبلی', 'aether' ),
					'next_text' => __( 'بعدی', 'aether' ),
				) );
				?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>

		<?php if ( \Aether\Frontend\Layout::has_sidebar() ) : ?>
			<aside class="aether-sidebar" role="complementary">
				<?php
				if ( aether_is_woocommerce_active() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
					dynamic_sidebar( 'sidebar-shop' );
				} elseif ( is_home() || is_category() || is_tag() || is_singular( 'post' ) ) {
					dynamic_sidebar( 'sidebar-blog' );
				} else {
					dynamic_sidebar( 'sidebar-main' );
				}
				?>
			</aside>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
