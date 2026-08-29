<?php
/**
 * قالب صفحه
 *
 * @package Aether
 */

get_header();
?>

<div class="aether-container">
	<div class="aether-content-area <?php echo esc_attr( implode( ' ', apply_filters( 'aether_content_classes', array() ) ) ); ?>">
		<div class="aether-main-content">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'aether-page' ); ?>>
					<header class="aether-page__header">
						<?php the_title( '<h1 class="aether-page__title">', '</h1>' ); ?>
					</header>
					<div class="aether-page__content entry-content">
						<?php
						the_content();
						wp_link_pages();
						?>
					</div>
				</article>
				<?php
			endwhile;
			?>
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
