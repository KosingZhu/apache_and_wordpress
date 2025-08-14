<?php

// add shortcode hooks
add_shortcode( 'fable_extra_woo_wishlist_table', 'fable_extra_woowishlist_shortcode' );

/**
 * Renders wishlist shortcode.
 *
 * @since 1.0.0
 *
 * @param array $atts The array of shortcode attributes.
 */
function fable_extra_woowishlist_shortcode( $atts ) {

	$atts = apply_filters( 'shortcode_atts_fable_extra_woo_wishlist_table', $atts );

	return fable_extra_woowishlist_render( $atts );
}