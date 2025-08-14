<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php
 */
if (!defined('ABSPATH')) {
	exit;
}


if ( ! function_exists( 'srp_get_all_product_ids_from_cat_ids' ) ) {

	/**
	* Get all product ids from the given category ids
	* @since 1.0
	* @return array  
	*/
	function srp_get_all_product_ids_from_cat_ids( array $cat_ids ) {
		$all_ids = get_posts(
			array(
				'post_type'		 => 'product',
				'numberposts'	 => -1,
				'post_status'	 => 'publish',
				'fields'		 => 'ids',
				'tax_query'		 => array(
					array(
						'taxonomy'	 => 'product_cat',
						'field'		 => 'term_id',
						'terms'		 => $cat_ids,
						'operator'	 => 'IN',
					)
				),
			)
		);

		return $all_ids;
	}
}

if ( ! function_exists( 'srp_get_all_product_ids_from_tag_ids' ) ) {

	/**
	* Get all product ids from the given tag ids
	* @since 1.0
	* @return array  
	*/
	function srp_get_all_product_ids_from_tag_ids( array $tag_ids ) {
		$all_ids = get_posts(
			array(
				'post_type'		 => 'product',
				'numberposts'	 => -1,
				'post_status'	 => 'publish',
				'fields'		 => 'ids',
				'tax_query'		 => array(
					array(
						'taxonomy'	 => 'product_tag',
						'field'		 => 'term_id',
						'terms'		 => $tag_ids,
						'operator'	 => 'IN',
					)
				),
			)
		);

		return $all_ids;
	}
}

if ( ! function_exists( 'srp_get_all_product_ids_from_attr_ids' ) ) {

	/**
	* Get all product ids from the given attributes
	* @since 1.0
	* @return array  
	*/
	function srp_get_all_product_ids_from_attr_ids( array $attr_data ) {
	
		$tax_query = array( 'relation'=> 'OR' );
		foreach ($attr_data as $attr_name => $attr_term_ids) {
			$tax_query[] = array(
				'taxonomy'        => "pa_$attr_name",
				'terms'           =>  $attr_term_ids,
				'operator'        => 'IN',
			);
		}
		$all_ids = new WP_Query(
			array(
				'post_type'		 => array('product', 'product_variation'),
				'posts_per_page'	 => -1,
				'post_status'	 => 'publish',
				'fields'		 => 'ids',
				'tax_query' => $tax_query
			)
		);

		if( $all_ids->have_posts() ) {
			return $all_ids->posts;
		}    

		return array();
	}
}

$global_related_by = (array) apply_filters( 'fable_extra_rp_global_related_by', get_option('custom_related_products_fable_extra_relatedp_by') );

if ( $related_products || !empty($global_related_by) ) :

?>

	<section class="related products fable-extra-related-products">

		<?php
		$srp_title		 = get_option('custom_related_products_srp_title', esc_html__('Related Products', 'fable-extra'));
		$srp_heading 	 = apply_filters('wt_related_products_heading', "<h2 class='fable-extra-relatedp-heading'>" . esc_html( $srp_title ) . " </h2>", $srp_title);
		
		global $post;

		// when rendering through shortcode
		if (isset($shortcode_post)) {

			$post = $shortcode_post;
		}
		
		$working_mode = class_exists('Fable_Extra_Related_Products') ? Fable_Extra_Related_Products::get_current_working_mode() : '';

		if ( $working_mode == 'custom' ) {

			$current_post_id = $post->ID;
			global $sitepress;
			$use_primary_id_wpml = apply_filters( 'fable_extra_rp_use_primary_id_wpml', get_option('custom_related_products_use_primary_id_wpml') );
			if( $use_primary_id_wpml == 'enable' && isset( $sitepress ) && defined('ICL_LANGUAGE_CODE') ) {
				$default_lang = $sitepress->get_default_language();
				if( $default_lang != ICL_LANGUAGE_CODE && function_exists('icl_object_id') ) {
					$default_id = icl_object_id ($post->ID, "product", false, $default_lang);
					$default_post = get_post( $default_id );
					$post = $default_post;
				}
			}

			$reselected = get_post_meta($post->ID, 'selected_ids', true);

			if (!empty($reselected)) {
				add_post_meta($post->ID, '_fable_extra_relatedp_ids', $reselected);
			}

			$related = apply_filters( 'fable_extra_rp_related_product_ids', array_filter(array_map('absint', (array) get_post_meta($post->ID, '_fable_extra_relatedp_ids', true))));

			


			//gets selected related categories
			$related_categories_ids = apply_filters( 'fable_extra_rp_related_category_ids',array_filter(array_map('absint', (array) get_post_meta($post->ID, '_fable_extra_relatedp_product_cats', true))));
				
			//gets selected related tags
			$related_tags_ids = apply_filters( 'fable_extra_rp_related_tag_ids', get_post_meta($post->ID, '_fable_extra_relatedp_product_tags', true) );
			
			//gets selected related attributes
			$related_attr_ids = apply_filters( 'fable_extra_rp_related_attribute_ids', get_post_meta($post->ID, '_fable_extra_relatedp_product_attr', true) );
		
			if(!empty($related) || !empty($related_categories_ids) || !empty($related_tags_ids) || !empty($related_attr_ids)) {

				if (!empty($related_categories_ids)) {
					$all_ids = srp_get_all_product_ids_from_cat_ids( $related_categories_ids );

					if (!empty($related)) {
						$related = array_merge($all_ids, $related);
					} else {
						$related = $all_ids;
					}
				}
	
				if (!empty($related_tags_ids) && is_array($related_tags_ids)) {
					$all_ids = srp_get_all_product_ids_from_tag_ids( $related_tags_ids );

					if (!empty($related)) {
						$related = array_merge($all_ids, $related);
					} else {
						$related = $all_ids;
					}
				}

				if (!empty($related_attr_ids)) {

					$all_ids = srp_get_all_product_ids_from_attr_ids( $related_attr_ids );

					if (!empty($related)) {
						$related = array_merge($all_ids, $related);
					} else {
						$related = $all_ids;
					}
				}
			} else if(!empty($global_related_by)) {
				
				if( in_array( 'category', $global_related_by ) ) {
					$product_cat_ids = array();
					$prod_terms = get_the_terms( $post->ID, 'product_cat' );
					

					if ( ! empty( $prod_terms ) && ! is_wp_error( $prod_terms ) ) {
						$subcategory_only = apply_filters('fable_extra_rp_subcategory_only', false);
						$category_count = count($prod_terms);
                        $term_ids = array_column($prod_terms, 'term_id');

						foreach ($prod_terms as $prod_term) {
							if( $subcategory_only && $category_count > 1 ) {
                                $has_term_id = false;
                                $children = function_exists('get_categories') ? get_categories( array ('taxonomy' => 'product_cat', 'child_of' => $prod_term->term_id )) : array();
                                foreach ($children as $term) {
                                    if( in_array($term->term_id, $term_ids) ) {
                                        $has_term_id = true;
                                        break;
                                    }
                                }
                                
                                if ( count($children) == 0 || !$has_term_id ) {
									// if no children, then it may be the deepest sub category.
									$product_cat_ids[] = $prod_term->term_id;
								}
							}else {
								// gets product cat id
								$product_cat_ids[] = $prod_term->term_id;
							}	
						}
						if(!empty($product_cat_ids)) {
							$related = srp_get_all_product_ids_from_cat_ids( $product_cat_ids );
						}
					}
					
				}

				if( in_array( 'tag', $global_related_by ) ) {
					$product_tag_ids = $related_ids = array();
					$prod_terms = get_the_terms( $post->ID, 'product_tag' );
					if ( ! empty( $prod_terms ) && ! is_wp_error( $prod_terms ) ) {
						foreach ($prod_terms as $prod_term) {
							// gets product tag id
							$product_tag_ids[] = $prod_term->term_id;
						}
						if(!empty($product_tag_ids)) {
							$related_ids = srp_get_all_product_ids_from_tag_ids( $product_tag_ids );
							$related = ( !empty($related) && is_array($related) ) ? array_merge($related, $related_ids) : $related_ids;
						}
					}
				}
			}

			//gets excluded categories
			$excluded_categories_ids = apply_filters( 'fable_extra_rp_excluded_category_ids',get_post_meta($post->ID, '_srp_excluded_cats', true) );

			if (!empty($excluded_categories_ids) && !empty($related)) {
				$all_ids = srp_get_all_product_ids_from_cat_ids( $excluded_categories_ids );

				if (!empty($all_ids)) {
					$related = array_diff($related, $all_ids);
				}
			}

			delete_post_meta($post->ID, 'selected_ids');
			$related	= is_array($related) ? array_diff($related, array($post->ID, $current_post_id)) : array();
			if (!empty($related)) {

				$related_products	 = array();
				$copy				 = array();
				
				$related_products	 = $related;
				while (count($related_products)) {
					// takes a rand array elements by its key
					$element			 = array_rand($related_products);
					// assign the array and its value to an another array
					$copy[$element]	 = $related_products[$element];
					//delete the element from source array
					unset($related_products[$element]);
				}

				$number_of_products	 = get_option('custom_related_products_srp_number', 3);
				$number_of_products	 = apply_filters('wt_related_products_number', $number_of_products);
				$orderby 			 = get_option('custom_related_products_srp_order_by', 'title');
				$orderby			 = apply_filters('wt_related_products_orderby', $orderby);
				$order 				 = get_option('custom_related_products_srp_order', 'ASC');	
				$order				 = apply_filters('wt_related_products_order', $order);

				$i = 1;

				// Setup your custom query
				$args = array(
					'post_type' => 'product', 
					'posts_per_page' => $number_of_products, 
					'orderby' => $orderby, 
					'order' => $order, 
					'post__in' => $copy
				);
				$custom_orderby = class_exists('Fable_Extra_Related_Products') ? Fable_Extra_Related_Products::get_custom_order_by_values() : array();
				if( array_key_exists( $orderby, $custom_orderby ) ) {
					$args['orderby'] =  $custom_orderby[$orderby]['orderby'];
					$args['meta_key'] = $custom_orderby[$orderby]['meta_key'];
				}
				
				// To exclude out of stock products
				$exclude_os	 = get_option('custom_related_products_exclude_os');
				if (!empty($exclude_os)) {
					$args['meta_query'] = array(
						array(
							'key'       => '_stock_status',
							'value'     => 'outofstock',
							'compare'   => 'NOT IN'
						)
					);
				}

				$loop	 = new WP_Query($args);
				if($loop->have_posts()) {
					echo $srp_heading;

					woocommerce_product_loop_start();

					while ($loop->have_posts()) : $loop->the_post();
						wc_get_template_part('content', 'product'); 
					endwhile; // end of the loop. 
					woocommerce_product_loop_end();
				}
			} else {
				?>
				<section class="related_products" style="display: none;"></section>
			<?php
			}
		} else if( $working_mode == 'default' && !empty( $related_products )) {
			?>
			<?php echo $srp_heading; ?>
			<?php
			$crelated = get_post_meta($post->ID, '_fable_extra_relatedp_ids', true);

			if (!empty($crelated))
				update_post_meta($post->ID, 'selected_ids', $crelated);
			?>
			<?php 
				woocommerce_product_loop_start();
				foreach ($related_products as $related_product) :
					if (!is_object($related_product)) {
						$related_product = wc_get_product($related_product);
					}

					$post_object		 = get_post($related_product->get_id());
					setup_postdata($GLOBALS['post']	 = &$post_object);
					wc_get_template_part('content', 'product');
				?>
			<?php
				endforeach;
				woocommerce_product_loop_end();
		}
		?>

	</section>

<?php
endif;
wp_reset_postdata();


