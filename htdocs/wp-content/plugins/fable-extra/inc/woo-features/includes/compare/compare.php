<?php
//require_once 'widget.php';
if ( 'yes' !== get_option( 'fable_extra_woocompare_enable' ) ) {

	return;
}
require_once 'buttons.php';

if ( ! is_admin() ) {

	require_once 'shortcode.php';
}

if ( ! session_id() ) {

	session_start();
}

// register action hooks
add_action( 'wp_enqueue_scripts', 'fable_extra_woocompare_setup_plugin' );

add_action( 'wp_ajax_fable_extra_woocompare_add_to_list', 'fable_extra_woocompare_process_button_action' );
add_action( 'wp_ajax_nopriv_fable_extra_woocompare_add_to_list', 'fable_extra_woocompare_process_button_action' );

add_action( 'wp_ajax_fable_extra_woocompare_remove', 'fable_extra_woocompare_process_remove_button_action' );
add_action( 'wp_ajax_nopriv_fable_extra_woocompare_remove', 'fable_extra_woocompare_process_remove_button_action' );

add_action( 'wp_ajax_fable_extra_woocompare_empty', 'fable_extra_woocompare_process_empty_button_action' );
add_action( 'wp_ajax_nopriv_fable_extra_woocompare_empty', 'fable_extra_woocompare_process_empty_button_action' );

add_action( 'wp_ajax_fable_extra_woocompare_update', 'fable_extra_woocompare_process_ajax' );
add_action( 'wp_ajax_nopriv_fable_extra_woocompare_update', 'fable_extra_woocompare_process_ajax' );

/**
 * Registers scripts, styles and page endpoint.
 *
 * @since 1.0.0
 * @action init
 */
function fable_extra_woocompare_setup_plugin() {

	wp_enqueue_style( 'fable-extra-woocompare' );
	wp_enqueue_script( 'fable-extra-woocompare' );
}

/**
 * Returns compare list.
 *
 * @sicne 1.0.0
 *
 * @return array The array of product ids to compare.
 */
function fable_extra_woocompare_get_list() {

	$list = ! empty( $_SESSION['fable-extra-woocompare-list'] ) ? $_SESSION['fable-extra-woocompare-list'] : array();

	if ( ! empty( $list ) ) {
		$list  = explode( ':', $list );
	}
	return $list;
}

/**
 * Sets new list of products to compare.
 *
 * @since 1.0.0
 *
 * @param array $list The new array of products to compare.
 */
function fable_extra_woocompare_set_list( $list ) {
	$value = implode( ':', $list );
	$_SESSION['fable-extra-woocompare-list'] = $value;
}

/**
 * Returns compare page link.
 *
 * @since 1.0.0
 *
 * @return string The compare pare link on success, otherwise FALSE.
 */
function fable_extra_woocompare_get_page_link() {

	$page_id = intval( get_option( 'fable_extra_woocompare_page' ) );

	if ( ! $page_id ) {

		return false;
	}
	$page_link = get_permalink( $page_id );

	if ( ! $page_link ) {

		return false;
	}
	return trailingslashit( $page_link );
}

/**
 * Processes buttons actions.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_fable_extra_woocompare_add_to_list
 */
function fable_extra_woocompare_process_button_action() {

	$id     = filter_input( INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT );
	$list   = fable_extra_woocompare_get_list();
	$key    = array_search( $id, $list );
	$button = false;

	if ( false !== $key ) {

		$action = 'remove';

		fable_extra_woocompare_remove( $id );

	} else {

		$action = 'add';
		$button = json_decode( filter_input( INPUT_POST, 'single' ) ) ? fable_extra_woocompare_page_button() : false;

		fable_extra_woocompare_add( $id );
	}

	wp_send_json_success( array(
		'action'         => $action,
		'comparePageBtn' => $button,
		'counts'         => fable_extra_woocompare_get_counts_data(),
	) );
}

/**
 * Returns message when is no products in compare.
 *
 * @since 1.0.2
 *
 * @return string The message
 */
function fable_extra_woocompare_empty_message() {

	$empty_text = get_option( 'fable_extra_woocompare_empty_text', __( 'No products found to compare.', 'fable-extra' ) );
	$html       = sprintf( '<p class="fable-extra-woocompare-empty">%s</p>', $empty_text );

	return apply_filters( 'fable_extra_woocompare_empty_message', $html, $empty_text );
}

/**
 * Processes main ajax handler.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_fable_extra_woocompare_update
 */
function fable_extra_woocompare_process_ajax() {

	$is_page   = json_decode( filter_input( INPUT_POST, 'isComparePage' ) );
	$is_widget = json_decode( filter_input( INPUT_POST, 'isWidget' ) );
	$json      = array();

	if ( $is_page ) {

		$json['compareList'] = fable_extra_woocompare_list_render_table();
	}

	$json['counts'] = fable_extra_woocompare_get_counts_data();

	wp_send_json_success( $json );
}

/**
 * Processes remove button action.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_fable_extra_woocompare_remove
 */
function fable_extra_woocompare_process_remove_button_action() {
	$product_id = filter_input( INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT );
	fable_extra_woocompare_remove( $product_id );
	fable_extra_woocompare_process_ajax();
}

/**
 * Processes empty button action.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_fable_extra_woocompare_empty
 */
function fable_extra_woocompare_process_empty_button_action() {

	fable_extra_woocompare_set_list( array() );

	fable_extra_woocompare_process_ajax();
}

/**
 * Adds product to compare list.
 *
 * @since 1.0.0
 *
 * @param int $id The product id to add to the compare list.
 */
function fable_extra_woocompare_add( $id ) {

	$list   = fable_extra_woocompare_get_list();
	$list[] = $id;

	fable_extra_woocompare_set_list( $list );
}

/**
 * Removes product from compare list.
 *
 * @since 1.0.0
 *
 * @param int $id The product id to remove from compare list.
 */
function fable_extra_woocompare_remove( $id ) {

	$list = fable_extra_woocompare_get_list();

	foreach ( wp_parse_id_list( $id ) as $id ) {

		$key = array_search( $id, $list );

		if ( false !== $key ) {

			unset( $list[$key] );
		}
	}
	fable_extra_woocompare_set_list( $list );
}

/**
 * Get products added to compare.
 *
 * @since 1.0.0
 *
 * @param array $list The array of products ids.
 * @return object The list of products
 */
function fable_extra_woocompare_get_products( $list ) {

	$args = array(
		'post_type'      => 'product',
		'post__in'       => $list,
		'orderby'        => 'post__in',
		'posts_per_page' => -1
	);
	$products = new WP_Query( $args );

	return $products;
}

/**
 * Renders compare list.
 *
 * @since 1.0.0
 *
 * @param array $atts The array of attributes to show in the table.
 * @return string Compare table HTML.
 */
function fable_extra_woocompare_list_render( $atts = array() ) {

	$fable_extra_wc_compare_wishlist = fable_extra_wc_compare_wishlist();
	$content                = array();
	$content[]              = '<div class="woocommerce fable-extra-woocompare-list">';
	$content[]              = '<div class="woocommerce fable-extra-woocompare-wrapper">';
	$content[]              = fable_extra_woocompare_list_render_table( $atts );
	$content[]              = '</div>';
	$content[]              = $fable_extra_wc_compare_wishlist->get_loader();
	$content[]              = '</div>';

	return implode( "\n", $content );
}

/**
 * Renders compare table.
 *
 * @since 1.0.0
 *
 * @param array $selected_attributes Coming soon.
 *
 * @return string Wishlist table HTML.
 */
function fable_extra_woocompare_list_render_table( $selected_attributes = array() ) {

	$list = fable_extra_woocompare_get_list();

	if ( empty( $list ) ) {

		return fable_extra_woocompare_empty_message();
	}

	$templater        = fable_extra_wc_compare_wishlist_templater();
	$products         = fable_extra_woocompare_get_products( $list );
	$products_content = array();
	$template         = get_option( 'fable_extra_woocompare_page_template' );
	$template         = $templater->get_template_by_name( $template, 'fable-extra-woocompare' );

	if( ! $template ) {

		$template = $templater->get_template_by_name( 'page.tmpl', 'fable-extra-woocompare' );
	}

	$replace_data = $templater->get_replace_data();

	while ( $products->have_posts() ) {

		$products->the_post();

		global $product;

		if ( empty( $product ) ) {

			continue;
		}
		$pid = $product->get_id();
		$pid = fable_extra_wc_compare_wishlist()->get_original_product_id( $pid );
		preg_match_all( $templater->macros_regex(), $template, $matches );

		if( ! empty( $matches[1] ) ) {

			foreach ( $matches[1] as $match ) {

				$macros   = array_filter( explode( ' ', $match, 2 ) );
				$callback = strtolower( $macros[0] );
				$attr     = isset( $macros[1] ) ? shortcode_parse_atts( $macros[1] ) : array();

				if ( ! isset( $replace_data[ $callback ] ) ) {

					continue;
				}
				$callback_func = $replace_data[ $callback ];

				if ( ! is_callable( $callback_func ) ) {

					continue;
				}
				$content = call_user_func( $callback_func, $attr );

				if( 'attributes' == $callback ) {

					$products_content[$pid][$callback] = $content;

				} else {

					$products_content[$pid][] = $content;
				}
			}
		}
	}
	wp_reset_query();

	$parsed_products = fable_extra_woocompare_parse_products( $products_content );

	return fable_extra_woocompare_compare_list_get_table( $parsed_products, $products );
}

/**
 * Get compare table.
 *
 * @since 1.0.1
 *
 * @param array $content The parsed products content.
 * @param object $products The products.
 *
 * @return string Wishlist table HTML.
 */
function fable_extra_woocompare_compare_list_get_table( $content, $products ) {

	$html = array();
	$i    = 0;

	foreach ( $content as $key => $row ) {

		$row = array_filter( $row );

		$i++;

		if( empty( $row ) ) {

			continue;
		}
		if ( 1 == $i ) {

			$html[] = '<table class="fable-extra-woocompare-table tablesaw" data-tablesaw-mode="swipe">';
			$html[] = '<thead>';
		}
		if ( 2 == $i ) {

			$html[] = '<tbody>';
		}
		$html[] = '<tr class="fable-extra-woocompare-row">';

		if ( 1 == $i ) {

			$tag    = 'th';
			$html[] = '<th class="fable-extra-woocompare-heading-cell title" data-tablesaw-priority="persist" scope="col" data-tablesaw-sortable-col>';

		} else {

			$tag    = 'td';
			$html[] = '<th class="fable-extra-woocompare-heading-cell title">';
		}
		if ( 'string' === gettype( $key ) ) {

			$html[] = $key;
		}
		$html[] = '</th>';

		while ( $products->have_posts() ) {

			$products->the_post();

			global $product;

			$atts = '';

			if ( 1 == $i ) {
				$atts = ' scope="col" data-tablesaw-sortable-col';
			}

			$html[] = '<' . $tag . ' class="fable-extra-woocompare-cell"' . $atts . '>';
			$pid    = $product->get_id();
			$pid    = fable_extra_wc_compare_wishlist()->get_original_product_id( $pid );

			if ( 1 == $i ) {

				$dismiss_icon = apply_filters( 'fable_extra_woocompare_dismiss_icon', '<span class="dashicons dashicons-dismiss"></span>' );
				$html[]       = '<div class="fable-extra-woocompare-remove" data-id="' . $pid . '">' . $dismiss_icon . '</div>';
			}
			if(isset($row[$pid])){
				$html[] = $row[$pid];
			}
			
			$html[] = '</' . $tag . '>';
		}
		$html[] = '</tr>';

		if ( 1 == $i ) {

			$html[] = '</thead>';
		}
		if ( $i == count( $content ) ) {

			$html[] = '</tbody>';
			$html[] = '</table>';
		}
	}
	wp_reset_query();

	return implode( "\n", $html );
}

/**
 * Parse products attributes.
 *
 * @since 1.0.0
 *
 * @param array $attributes The products attributes.
 *
 * @return array parsed products attributes.
 */
function fable_extra_woocompare_parse_products_attributes( $attributes ) {

	$rebuilded_attributes = array();

	foreach ( $attributes as $id => $attribute ) {

		foreach ( $attribute as $attr_name => $attribute_value ) {

			$rebuilded_attributes[$attr_name][$id] = $attribute_value;
		}
	}
	foreach ( $rebuilded_attributes as $attr_name => $attr_products ) {

		foreach ( $attributes as $id => $attribute ) {

			if ( ! array_key_exists( $id, $attr_products ) ) {

				$rebuilded_attributes[$attr_name][$id] = '&#8212;';
			}
		}
	}
	return $rebuilded_attributes;
}

/**
 * Parse products.
 *
 * @since 1.0.0
 *
 * @param array $products_content The products content.
 *
 * @return array parsed products content.
 */
function fable_extra_woocompare_parse_products( $products_content ) {

	$parsed_products = array();

	foreach ( $products_content as $product_id => $product_content_arr ) {

		foreach ( $product_content_arr as $key => $product_content ) {

			$parsed_products[$key][$product_id] = $product_content;
		}
	}
	if( array_key_exists( 'attributes', $parsed_products ) && ! empty( $parsed_products['attributes'] ) ) {

		$attributes      = fable_extra_woocompare_parse_products_attributes( $parsed_products['attributes'] );
		$key             = array_search( 'attributes', array_keys( $parsed_products ), true );
		$before          = array_slice( $parsed_products, 0, $key, true );
		$after           = array_slice( $parsed_products, ( $key + 1 ), null, true );
		$parsed_products = array_merge( $before, $attributes, $after );
	}
	return $parsed_products;
}

add_action( 'wp_ajax_fable_extra_compare_get_fragments',        'fable_extra_woocompare_update_fragments' );
add_action( 'wp_ajax_nopriv_fable_extra_compare_get_fragments', 'fable_extra_woocompare_update_fragments' );

/**
 * Update compare counts on page load and products status change
 *
 * @since  1.1.0
 * @return void
 */
function fable_extra_woocompare_update_fragments() {
	wp_send_json_success( fable_extra_woocompare_get_counts_data() );
}

/**
 * Returns cart counts
 *
 * @since  1.1.0
 * @return array
 */
function fable_extra_woocompare_get_counts_data() {

	$count   = sprintf( '%d', count( fable_extra_woocompare_get_list() ) );
	$default = apply_filters( 'fable_extra_compare_default_count', array( '.menu-compare > a' => $count ) );

	return array(
		'defaultFragments' => $default,
		'customFragments'  => apply_filters( 'fable_extra_compare_refreshed_fragments', array() )
	);
}
