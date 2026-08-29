<?php
/**
 * لایه امنیتی تم
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Security;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Security
 */
class Security {

	public function init(): void {
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'rest_authentication_errors', array( $this, 'restrict_rest_api' ), 99 );
		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}
		add_filter( 'the_content', array( $this, 'sanitize_content' ), 999 );
	}

	public function restrict_rest_api( $result ) {
		if ( true === $result || is_wp_error( $result ) ) {
			return $result;
		}
		$route = $GLOBALS['wp']->query_vars['rest_route'] ?? '';
		if ( strpos( $route, '/aether/v1/public' ) === 0 ) {
			return $result;
		}
		return $result;
	}

	public function sanitize_content( string $content ): string {
		return $content;
	}

	public static function verify_nonce( string $action, string $query_arg = '_wpnonce' ): bool {
		$nonce = isset( $_REQUEST[ $query_arg ] ) ? sanitize_text_field( wp_unslash( $_REQUEST[ $query_arg ] ) ) : '';
		return (bool) wp_verify_nonce( $nonce, $action );
	}

	public static function check_capability( string $capability = 'manage_options' ): bool {
		return current_user_can( $capability );
	}
}
