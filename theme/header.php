<?php
/**
 * هدر تم
 *
 * @package Aether
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="aether-page" class="aether-page">
	<a class="aether-skip-link aether-sr-only" href="#aether-content"><?php esc_html_e( 'پرش به محتوا', 'aether' ); ?></a>

	<?php
	/**
	 * هوک رندر هدر
	 *
	 * @hooked Aether\Frontend\Header::render
	 */
	do_action( 'aether_header' );
	?>

	<main id="aether-content" class="aether-main">
