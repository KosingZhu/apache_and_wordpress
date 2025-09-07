<?php

if ( is_admin() ) {

	//require_once 'settings.php';
}
if ( 'yes' !== get_option( 'fable_extra_woowishlist_enable' ) ) {

	return;
}
require_once 'buttons.php';

if ( ! is_admin() ) {

	require_once 'shortcode.php';
}

// register action hooks
add_action( 'wp_enqueue_scripts', 'fable_extra_woowishlist_setup_plugin' );

add_action( 'wp_ajax_fable_extra_woowishlist_add', 'fable_extra_woowishlist_process_button_action' );
add_action( 'wp_ajax_nopriv_fable_extra_woowishlist_add', 'fable_extra_woowishlist_process_button_action' );

add_action( 'wp_ajax_fable_extra_woowishlist_remove', 'fable_extra_woowishlist_process_remove_button_action' );
add_action( 'wp_ajax_nopriv_fable_extra_woowishlist_remove', 'fable_extra_woowishlist_process_remove_button_action' );

add_action( 'wp_ajax_fable_extra_woowishlist_update', 'fable_extra_woowishlist_process_ajax' );
add_action( 'wp_ajax_nopriv_fable_extra_woowishlist_update', 'fable_extra_woowishlist_process_ajax' );

add_action( 'init', 'fable_extra_woowislist_session_to_db' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 *
 * @action wp_enqueue_scripts
 */
function fable_extra_woowishlist_setup_plugin() {

	wp_enqueue_style( 'fable-extra-woowishlist' );
	wp_enqueue_script( 'fable-extra-woowishlist' );

	$include_bootstrap_grid = apply_filters( 'fable_extra_woocommerce_include_bootstrap_grid', true );

	if ( $include_bootstrap_grid ) {

		wp_enqueue_style( 'bootstrap-grid' );
	}
}

/**
 * Returns wishlist list.
 *
 * @sicne 1.0.0
 *
 * @return array The array of product ids to wishlist.
 */
function fable_extra_woowishlist_get_list() {

	if( is_user_logged_in() ) {

		$id   = get_current_user_id();
		$list = get_user_meta( $id, 'fable_extra_woo_wishlist_items', true );

		if ( ! empty( $list ) ) {

			$list = unserialize( $list );

		} else {

			$list = array();
		}
	} else {

		$list = ! empty( $_SESSION['fable-extra-woowishlist'] ) ? $_SESSION['fable-extra-woowishlist'] : array();

		if ( ! empty( $list ) ) {

			$list  = explode( ':', $list );
			$nonce = array_pop( $list );

			if ( ! wp_verify_nonce( $nonce, implode( $list ) ) ) {

				$list = array();
			}
		}
	}
	return $list;
}

/**
 * Sets new list of products to wishlist.
 *
 * @since 1.0.0
 *
 * @param array $list The new array of products to wishlist.
 */
function fable_extra_woowishlist_set_list( $list ) {

	$nonce                      = wp_create_nonce( implode( $list ) );
	$value                      = implode( ':', array_merge( $list, array( $nonce ) ) );
	if ( ! session_id() ) {

		session_start();
	}
	$_SESSION['fable-extra-woowishlist'] = $value;
}

/**
 * Returns wishlist page link.
 *
 * @since 1.0.0
 *
 * @return string The wishlist page link on success, otherwise FALSE.
 */
function fable_extra_woowishlist_get_page_link() {

	$page_id = intval( get_option( 'fable_extra_woowishlist_page', '' ) );

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
 * @action wp_ajax_fable_extra_woowishlist_add_to_list
 */
function fable_extra_woowishlist_process_button_action() {

    $id = filter_input( INPUT_POST, 'pid' );

    if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'nonce' ), 'fable_extra_woowishlist' . $id ) ) {
        wp_send_json_error();
    }

    // Determine what action to set
    $action = 'add_to_wishlist'; // or something dynamic based on the input or logic

    // Check if single button mode is true and get the button
    $button = json_decode( filter_input( INPUT_POST, 'single' ) ) ? fable_extra_woowishlist_page_button() : false;

    // Process the wishlist action
    fable_extra_woowishlist_add( $id );
    
    // Send JSON success response with action
    wp_send_json_success( array(
        'action'          => $action,  // Now $action is defined
        'wishlistPageBtn' => $button
    ) );
}

/**
 * Returns message when is no products in wishlist.
 *
 * @since 1.0.0
 *
 * @return string The message
 */
function fable_extra_woowishlist_empty_message() {

	$empty_text = get_option( 'fable_extra_woowishlist_empty_text', __( 'No products added to wishlist.', 'fable-extra' ) );

	return apply_filters( 'fable_extra_woowishlist_empty_message', sprintf( '<p class="fable-extra-woowishlist-empty">%s</p>', $empty_text ), $empty_text );
}

/**
 * Processes main ajax handler.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_fable_extra_woowishlist_update
 */
function fable_extra_woowishlist_process_ajax() {

	$is_page   = json_decode( filter_input( INPUT_POST, 'isWishlistPage' ) );
	$is_widget = json_decode( filter_input( INPUT_POST, 'isWidget' ) );
	$json      = array();
	$atts      = json_decode( filter_input( INPUT_POST, 'wishListData' ), true );

	if ( $is_page ) {

		$json['wishList'] = fable_extra_woowishlist_render_table( $atts );
	}
	wp_send_json_success( $json );
}

/**
 * Processes remove button action.
 *
 * @since 1.0.0
 *
 * @action wp_ajax_fable_extra_woowishlist_remove
 */
function fable_extra_woowishlist_process_remove_button_action() {

	$id = filter_input( INPUT_POST, 'pid' );

	if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'nonce' ), 'fable_extra_woowishlist' . $id ) ) {

		wp_send_json_error();
	}
	fable_extra_woowishlist_remove( $id );

	fable_extra_woowishlist_process_ajax();
}

/**
 * Adds product to wishlist.
 *
 * @since 1.0.0
 *
 * @param int $id The product id to add to the wishlist.
 */
function fable_extra_woowishlist_add( $id ) {

	$id = intval( $id );

	if( is_user_logged_in() ) {

		$user_id = get_current_user_id();
		$list    = get_user_meta( $user_id, 'fable_extra_woo_wishlist_items', true );

		if ( ! empty( $list ) ) {

			$list = unserialize( $list );

		} else {

			$list = array();
		}
		$list[] = $id;
		$list   = array_unique( $list );
		$list   = serialize( $list );

		update_user_meta( $user_id, 'fable_extra_woo_wishlist_items', $list );

	} else {

		$list   = fable_extra_woowishlist_get_list();
		$list[] = $id;
		$list   = array_unique( $list );

		fable_extra_woowishlist_set_list( $list );
	}
}

/**
 * Removes product from wishlist list.
 *
 * @since 1.0.0
 *
 * @param int $id The product id to remove from wishlist.
 */
function fable_extra_woowishlist_remove( $id ) {

	$id = intval( $id );

	if( is_user_logged_in() ) {

		$user_id = get_current_user_id();
		$list    = get_user_meta( $user_id, 'fable_extra_woo_wishlist_items', true );

		if ( ! empty( $list ) ) {

			$list = unserialize( $list );
			$key  = array_search( $id, $list );

			if ( false !== $key ) {

				unset( $list[$key] );
			}
			$list = serialize( $list );

			update_user_meta( $user_id, 'fable_extra_woo_wishlist_items', $list );

		}

	} else {

		$list = fable_extra_woowishlist_get_list();
		$key  = array_search( $id, $list );

		if ( false !== $key ) {

			unset( $list[$key] );
		}
		fable_extra_woowishlist_set_list( $list );
	}
}

/**
 * Get products added to wishlist.
 *
 * @since 1.0.0
 *
 * @param array $list The array of products ids.
 * @return object The list of products
 */
function fable_extra_woowishlist_get_products( $list ) {

	$args = array(
		'post_type'      => 'product',
		'post__in'       => $list,
		'orderby'        => 'post__in',
		'posts_per_page' => -1
	);
	$products = new WP_Query( $args );

	wp_reset_query();

	return $products;
}

/**
 * Renders wishlist.
 *
 * @since 1.0.0
 *
 * @return string Wishlist HTML.
 */
function fable_extra_woowishlist_render( $atts = array() ) {

    $content = array();

    // Sanitize class attribute
    $class = isset( $atts['class'] ) && ! empty( $atts['class'] ) ? esc_attr( $atts['class'] ) : '';

    // Filter out only allowed data attributes
    $fable_extra_wc_compare_wishlist = fable_extra_wc_compare_wishlist();
    $data_atts = $fable_extra_wc_compare_wishlist->build_html_dataattributes( $atts );

    // Build the HTML output
    $content[] = '<div class="woocommerce fable-extra-woowishlist ' . $class . '"' . $data_atts . '>';
    $content[] = '<div class="woocommerce fable-extra-woowishlist-wrapper">';
    $content[] = fable_extra_woowishlist_render_table( $atts );
    $content[] = '</div>';
    $content[] = $fable_extra_wc_compare_wishlist->get_loader();
    $content[] = '</div>';

    return implode( "\n", $content );
}


/**
 * Renders wishlist table.
 *
 * @since 1.0.0
 *
 * @param array $atts The wishlist table attributes.
 * @return string Wishlist table HTML.
 */
function fable_extra_woowishlist_render_table( $atts = array() ) {

    // Get the wishlist list
    $list = fable_extra_woowishlist_get_list();

    if ( empty( $list ) ) {
        return fable_extra_woowishlist_empty_message();
    }

    $html      = array();
    $templater = fable_extra_wc_compare_wishlist_templater();
    $products  = fable_extra_woowishlist_get_products( $list );

    // Define the allowed templates and sanitize the template input
    $allowed_templates = array( 'page.tmpl', 'grid.tmpl', 'list.tmpl' ); // Define your safe templates
    $user_template     = isset( $atts['template'] ) ? sanitize_file_name( $atts['template'] ) : '';
    $template          = in_array( $user_template, $allowed_templates, true )
                         ? $user_template
                         : get_option( 'fable_extra_woowishlist_page_template', 'page.tmpl' );

    // Set the number of columns (validate and sanitize input)
    $cols = isset( $atts['cols'] ) && ! empty( $atts['cols'] ) ? (int) $atts['cols'] : (int) get_option( 'fable_extra_woowishlist_cols', '1' );
    $cols = $cols > 4 ? 4 : $cols; // Limit max columns to 4

    // Get the template path using the sanitized template name
    $template_path = $templater->get_template_by_name( $template, 'fable-extra-woowishlist' );

    // Fallback to default template if the specified template is not found
    if ( ! $template_path ) {
        $template_path = $templater->get_template_by_name( 'page.tmpl', 'fable-extra-woowishlist' );
    }

    // Begin the output HTML
    $html[] = '<div class="wf-row">';
    $html[] = sprintf(
        __('<div class="wf-col-lg-12 wf-col-xs-12"><div class="fable-extra-woowishlist-item wishlist-head"><div><h5>Product Image</h5></div><div class="product-name"><h5>Product Name</h5></div><div class="product-price"><h5>Unit price</h5></div><div class="product-stock-status"><h5>Stock status</h5></div><div class="product-add-to-cart"><h5>Action</h5></div></div></div>', 'fable-extra')
    );

    // Determine the column class based on the number of columns
    $class = apply_filters( 'fable_extra_woowishlist_column_class', 'col-lg-' . round( 12 / $cols ) . ' col-xs-12', $cols );

    // Loop through the products and generate the output for each
    while ( $products->have_posts() ) {
        $products->the_post();

        global $product;

        if ( empty( $product ) ) {
            continue;
        }

        $pid          = $product->get_id();
        $pid          = fable_extra_wc_compare_wishlist()->get_original_product_id( $pid );
        $nonce        = wp_create_nonce( 'fable_extra_woowishlist' . $pid );
        $dismiss_icon = apply_filters( 'fable_extra_woowishlist_dismiss_icon', '<span class="dashicons dashicons-dismiss"></span>' );

        // Output product details and template rendering
        $html[] = '<div class="' . esc_attr( $class ) . '">';
        $html[] = '<div class="fable-extra-woowishlist-item">';
        $html[] = '<div class="fable-extra-woowishlist-remove" data-id="' . esc_attr( $pid ) . '" data-nonce="' . esc_attr( $nonce ) . '">' . $dismiss_icon . '</div>';
        $html[] = $templater->parse_template( $template_path, $atts );
        $html[] = '</div>';
        $html[] = '</div>';
    }

    // Reset the query to avoid conflicts
    wp_reset_postdata(); // Replaces deprecated wp_reset_query()

    // Close the row div and return the generated HTML
    $html[] = '</div>';

    return implode( "\n", $html );
}

function fable_extra_woowislist_session_to_db() {

	if ( is_user_logged_in() ) {

		$list         = fable_extra_woowishlist_get_list();
		$session_list = ! empty( $_SESSION['fable-extra-woowishlist'] ) ? $_SESSION['fable-extra-woowishlist'] : array();

		if ( ! empty( $session_list ) ) {

			$session_list = explode( ':', $session_list );
			$nonce        = array_pop( $session_list );
		}
		if ( ! empty( $session_list ) ) {

			foreach ( $session_list as $product_id ) {

				if( ! in_array( $product_id, $list ) ) {

					fable_extra_woowishlist_add( $product_id );
				}
			}
			fable_extra_woowishlist_set_list( array() );
		}
	}
}