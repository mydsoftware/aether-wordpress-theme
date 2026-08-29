<?php
/**
 * Mega Menu Walker
 *
 * @package Aether
 */

declare(strict_types=1);

namespace Aether\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mega_Menu_Walker extends \Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		$indent = str_repeat( "\t", $depth );
		if ( 0 === $depth ) {
			$output .= "\n$indent<ul class=\"aether-mega-menu\">\n";
		} else {
			$output .= "\n$indent<ul class=\"aether-sub-menu\">\n";
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$is_mega = in_array( 'mega-menu', $classes, true ) || get_post_meta( $item->ID, '_aether_mega_menu', true );

		if ( $is_mega && 0 === $depth ) {
			$classes[] = 'aether-menu-item--mega';
		}

		$class_names = implode( ' ', array_filter( $classes ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= $indent . '<li' . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output  = $args->before ?? '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( $args->link_before ?? '' ) . $title . ( $args->link_after ?? '' );

		$badge = get_post_meta( $item->ID, '_aether_menu_badge', true );
		if ( $badge ) {
			$item_output .= ' <span class="aether-badge aether-badge--primary">' . esc_html( $badge ) . '</span>';
		}

		$item_output .= '</a>';
		$item_output .= $args->after ?? '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ): void {
		$output .= "</li>\n";
	}
}
