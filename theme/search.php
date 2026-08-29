<?php
/**
 * قالب نتایج جستجو
 *
 * @package Aether
 */

get_header();
?>

<div class="aether-container">
	<div class="aether-content-area <?php echo esc_attr( implode( ' ', apply_filters( 'aether_content_classes', array() ) ) ); ?>">
		<div class="aether-main-content">
			<header class="aether-search-header">
				<h1 class="aether-search-header__title">
					<?php
					printf(
						esc_html__( 'نتایج جستجو برای: %s', 'aether' ),
						'<span>' . esc_html( get_search_query() ) . '</span>'
					);
					?>
				</h1>
			</header>

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
				<?php dynamic_sidebar( 'sidebar-main' ); ?>
			</aside>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
