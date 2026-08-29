<?php
/**
 * قالب محتوا - پست پیش‌فرض
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'aether-post-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="aether-post-card__thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'aether-blog' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="aether-post-card__body">
		<header class="aether-post-card__header">
			<?php
			the_title(
				sprintf( '<h2 class="aether-post-card__title"><a href="%s">', esc_url( get_permalink() ) ),
				'</a></h2>'
			);
			?>
			<div class="aether-post-card__meta">
				<span class="aether-post-card__date"><?php echo esc_html( get_the_date() ); ?></span>
				<span class="aether-post-card__author"><?php the_author(); ?></span>
			</div>
		</header>

		<div class="aether-post-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="aether-btn aether-btn--outline aether-btn--sm">
			<?php esc_html_e( 'ادامه مطلب', 'aether' ); ?>
		</a>
	</div>
</article>
