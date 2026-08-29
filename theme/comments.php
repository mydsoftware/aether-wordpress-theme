<?php
/**
 * قالب نظرات
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="aether-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="aether-comments__title">
			<?php
			$aether_comment_count = get_comments_number();
			printf(
				esc_html( _n( '%1$s نظر', '%1$s نظر', $aether_comment_count, 'aether' ) ),
				esc_html( number_format_i18n( $aether_comment_count ) )
			);
			?>
		</h2>
		<ol class="aether-comments__list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>
		<?php
		the_comments_navigation( array(
			'prev_text' => __( 'نظرات قبلی', 'aether' ),
			'next_text' => __( 'نظرات بعدی', 'aether' ),
		) );
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="aether-comments__closed"><?php esc_html_e( 'نظرات بسته شده‌اند.', 'aether' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'       => __( 'دیدگاه خود را بنویسید', 'aether' ),
		'title_reply_to'    => __( 'پاسخ به %s', 'aether' ),
		'cancel_reply_link' => __( 'لغو پاسخ', 'aether' ),
		'label_submit'      => __( 'ارسال دیدگاه', 'aether' ),
		'comment_field'     => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'دیدگاه', 'aether' ) . '</label><textarea id="comment" name="comment" class="aether-textarea" rows="5" required></textarea></p>',
		'class_submit'      => 'aether-btn aether-btn--primary',
	) );
	?>
</div>
