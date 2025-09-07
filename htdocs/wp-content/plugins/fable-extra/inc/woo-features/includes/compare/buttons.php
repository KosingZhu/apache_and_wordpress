<?php

// register action hooks

add_action( 'fable_extra_woocompare_add_button_loop', 'fable_extra_woocompare_add_button_loop', 12 );

add_action( 'woocommerce_single_product_summary', 'fable_extra_woocompare_add_button_single', 35 );

/**
 * Renders appropriate button for a loop product.
 *
 * @since 1.0.0
 * @action woocommerce_after_shop_loop_item
 */
function fable_extra_woocompare_add_button_loop( $args ) {

	if ( 'yes' === get_option( 'fable_extra_woocompare_show_in_catalog' ) ) {

		fable_extra_woocompare_add_button( $args );
	}
}

/**
 * Renders appropriate button for a product.
 *
 * @since 1.0.0
 */
function fable_extra_woocompare_add_button( $args ) {

	$id      = get_the_ID();
	$id      = fable_extra_wc_compare_wishlist()->get_original_product_id( $id );
	$classes = array( 'button', 'compare-btn', 'compare' );
	$nonce   = wp_create_nonce( 'fable_extra_woocompare' . $id );

	if ( in_array( $id, fable_extra_woocompare_get_list() ) ) {

		//$text      = get_option( 'fable_extra_woocompare_remove_text', __( 'Remove from Compare', 'fable-extra' ) );
		$text      = '<i class="fable-extra-wcwl-icon fa fa-refresh"></i>';
		$classes[] = 'in_compare';

	} else {

		$text = '';
	}
	$text      = '<span class="fable_extra_woocompare_product_actions_tip"><span class="text">' . wp_kses_post( $text ) . '</span></span>';
	//$text      = '<span class="fable_extra_woocompare_product_actions_tip">' . wp_kses_post( $text ) . '</span>';
	$preloader = apply_filters( 'fable_extra_wc_compare_wishlist_button_preloader', '' );

	if( $single = ( is_array( $args ) && isset( $args['single'] ) && $args['single'] ) ) {

		$classes[] = 'compare-btn-single';
	}
	$html = sprintf( '<a  class="%s" data-id="%s" data-nonce="%s">%s</a>', implode( ' ', $classes ), $id, $nonce, $text . $preloader );

	echo apply_filters( 'fable_extra_woocompare_button', $html, $classes, $id, $nonce, $text, $preloader );

	if( in_array( $id, fable_extra_woocompare_get_list() ) && $single ) {

		echo fable_extra_woocompare_page_button();
	}
}

/**
 * Renders appropriate button for a single product.
 *
 * @since 1.0.0
 * @action woocommerce_single_product_summary
 */
function fable_extra_woocompare_add_button_single( $args ) {

	if ( 'yes' === get_option( 'fable_extra_woocompare_show_in_single' ) ) {

		if( empty( $args ) ) {

			$args = array();
		}
		$args['single'] = true;

		fable_extra_woocompare_add_button( $args );
	}
}

/**
 * Renders wishlist page button for a product.
 *
 * @since 1.0.0
 */
function fable_extra_woocompare_page_button() {

	$link    = fable_extra_woocompare_get_page_link();
	$classes = array( 'button', 'fable-extra-woocompare-page-button', 'btn', 'btn-primary', 'alt' );
	$text    = __( 'View compare', 'fable-extra' );
	$html    = sprintf( '<a class="%s" href="%s">%s</a>', implode( ' ', $classes ), $link, $text );

	return apply_filters( 'fable_extra_woocompare_page_button', $html, $classes, $link, $text );
}