<?php
/**
 * قالب تک‌پست
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
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'aether-single-post' ); ?>>
					<header class="aether-single-post__header">
						<?php the_title( '<h1 class="aether-single-post__title">', '</h1>' ); ?>
						<div class="aether-single-post__meta">
							<span><?php echo esc_html( get_the_date() ); ?></span>
							<span><?php the_author(); ?></span>
							<?php
							$categories = get_the_category_list( ', ' );
							if ( $categories ) {
								echo '<span>' . wp_kses_post( $categories ) . '</span>';
							}
							?>
						</div>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="aether-single-post__thumbnail">
							<?php the_post_thumbnail( 'aether-hero' ); ?>
						</div>
					<?php endif; ?>

					<div class="aether-single-post__content entry-content">
						<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="aether-page-links">' . esc_html__( 'صفحات:', 'aether' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<footer class="aether-single-post__footer">
						<?php the_tags( '<div class="aether-single-post__tags">', '', '</div>' ); ?>
					</footer>
				</article>

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			endwhile;
			?>
		</div>

		<?php if ( \Aether\Frontend\Layout::has_sidebar() ) : ?>
			<aside class="aether-sidebar" role="complementary">
				<?php dynamic_sidebar( 'sidebar-blog' ); ?>
			</aside>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
