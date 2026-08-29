<?php
/**
 * فوتر تم
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	</main><!-- #aether-content -->

	<?php
	/**
	 * هوک رندر فوتر
	 *
	 * @hooked Aether\Frontend\Footer::render
	 */
	do_action( 'aether_footer' );
	?>

</div><!-- #aether-page -->

<?php wp_footer(); ?>
</body>
</html>
