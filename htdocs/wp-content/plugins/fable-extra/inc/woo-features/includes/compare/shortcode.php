<?php

// add shortcode hooks
add_shortcode( 'fable_extra_woo_compare_table', 'fable_extra_woocompare_shortcode' );

/**
 * Renders compare list shortcode.
 *
 * @since 1.0.0
 * @shortcode fable_extra_woo_compare_table
 */
function fable_extra_woocompare_shortcode( $atts ) {

	wp_enqueue_style( 'tablesaw' );
	wp_enqueue_script( 'tablesaw-init' );

	return fable_extra_woocompare_list_render();
}