<?php

// register action hooks

add_action( 'fable_extra_woowishlist_add_button_loop', 'fable_extra_woowishlist_add_button_loop', 12 );

add_action( 'woocommerce_single_product_summary', 'fable_extra_woowishlist_add_button_single', 35 );

/**
 * Renders appropriate button for a loop product.
 *
 * @since 1.0.0
 * @action woocommerce_after_shop_loop_item
 */
function fable_extra_woowishlist_add_button_loop( $args ) {

	if ( 'yes' === get_option( 'fable_extra_woowishlist_show_in_catalog' ) ) {

		fable_extra_woowishlist_add_button( $args );
	}
}

/**
 * Renders appropriate button for a product.
 *
 * @since 1.0.0
 */
function fable_extra_woowishlist_add_button( $args ) {

	$id      = get_the_ID();
	$id      = fable_extra_wc_compare_wishlist()->get_original_product_id( $id );
	$classes = array( 'fable-extra-wcwl-add-to-wishlist', 'fable-extra-woowishlist-button' );
	$nonce   = wp_create_nonce( 'fable_extra_woowishlist' . $id );

	if ( in_array( $id, fable_extra_woowishlist_get_list() ) ) {

		//$text      = get_option( 'fable_extra_woowishlist_added_text', __( 'Added to Wishlist', 'fable-extra' ) );
		$text      = '<div class="fable-extra-wcwl-add-button"><a href="#" class="add_to_wishlist single_add_to_wishlist" data-product-type="simple" data-title="Add to wishlist" rel="nofollow">                                                    <i class="fable-extra-wcwl-icon fa fa-heart"></i><span>Add to wishlist</span></a></div>';
		$classes[] = ' in_wishlist';

	} else {

		$text = '<div class="fable-extra-wcwl-add-button"><a href="#" class="add_to_wishlist single_add_to_wishlist" data-product-type="simple" data-title="Add to wishlist" rel="nofollow">                                                    <i class="fable-extra-wcwl-icon fa fa-heart"></i><span>Add to wishlist</span></a></div>';
	}
	$text      = '<span class="fable_extra_woowishlist_product_actions_tip"><span class="text">' . wp_kses_post( $text ) . '</span></span>';
	$preloader = apply_filters( 'fable_extra_wc_compare_wishlist_button_preloader', '' );

	if( $single = ( is_array( $args ) && isset( $args['single'] ) && $args['single'] ) ) {

		$classes[] = 'fable-extra-woowishlist-button-single';
	}
	$html = sprintf( '<div class="%s" data-id="%s" data-nonce="%s">%s</div>', implode( ' ', $classes ), $id, $nonce, $text . $preloader );

	echo apply_filters( 'fable_extra_woowishlist_button', $html, $classes, $id, $nonce, $text, $preloader );

	if ( in_array( $id, fable_extra_woowishlist_get_list() ) && $single ) {

		echo fable_extra_woowishlist_page_button( array( 'btn-primary', 'alt' ) );
	}
}

/**
 * Renders appropriate button for a single product.
 *
 * @since 1.0.0
 * @action woocommerce_single_product_summary
 */
function fable_extra_woowishlist_add_button_single( $args ) {

	if ( 'yes' === get_option( 'fable_extra_woowishlist_show_in_single' ) ) {

		if( empty( $args ) ) {

			$args = array();
		}
		$args['single'] = true;

		fable_extra_woowishlist_add_button( $args );
	}
}

/**
 * Renders wishlist page button for a product.
 *
 * @since 1.0.0
 */
function fable_extra_woowishlist_page_button( $classes = array() ) {

	$link = fable_extra_woowishlist_get_page_link();

	if( ! $link ) {

		return;
	}
	$classes = array_merge( $classes,  array( 'button', 'fable-extra-woowishlist-page-button', 'btn' ) );
	$text    = get_option( 'fable_extra_woowishlist_page_btn_text', __( 'Go to my wishlist', 'fable-extra' ) );
	$html    = sprintf( '<a class="%s" href="%s">%s</a>', implode( ' ', $classes ), $link, $text );

	return apply_filters( 'fable_extra_woowishlist_page_button', $html, $classes, $link, $text );
}