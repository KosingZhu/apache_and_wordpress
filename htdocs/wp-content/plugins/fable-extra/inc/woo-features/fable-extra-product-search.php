<?php
function fable_extra_product_search_scripts_styles(){
    if (class_exists("Woocommerce")) {

        wp_enqueue_style( 'fable-extra-product-search-style', WPFE_URL . '/inc/woo-features/assets/css/fable-extra-product-search.css', array(), '1.0.0' );
        wp_enqueue_script('fable-extra-product-search-main', WPFE_URL . '/inc/woo-features/assets/js/fable-extra-product-search.js', array('jquery'),'',true);
		wp_localize_script(
			'fable-extra-product-search-main',
			'opt',
			array(
				'ajaxUrl'   => admin_url('admin-ajax.php'),
				'noResults' => esc_html__( 'No products found', 'fable-extra' ),
				'nonce'     => wp_create_nonce('fable_search_nonce') // ✅ Add this line
			)
		);
    }
}
add_action( 'wp_enqueue_scripts', 'fable_extra_product_search_scripts_styles' );

/*  Get taxonomy hierarchy
/*-------------------*/

    function fable_extra_get_product_taxonomy_hierarchy( $taxonomy, $parent = 0, $exclude = 0) {
        $taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;
        $terms = get_terms( $taxonomy, array( 'parent' => $parent, 'hide_empty' => false, 'exclude' => $exclude) );

        $children = array();
        foreach ( $terms as $term ){
            $term->children = fable_extra_get_product_taxonomy_hierarchy( $taxonomy, $term->term_id, $exclude);
            $children[ $term->term_id ] = $term;
        }
        return $children;
    }

/*  List taxonomy hierarchy
/*-------------------*/

    function fable_extra_list_product_taxonomy_hierarchy_no_instance( $taxonomies) {
    ?>
        <?php foreach ( $taxonomies as $taxonomy ) { ?>
            <?php $children = $taxonomy->children; ?>
            <option value="<?php echo $taxonomy->term_id; ?>"><?php echo $taxonomy->name; ?></option>
            <?php if (is_array($children) && !empty($children)): ?>
                <optgroup>
                    <?php fable_extra_list_product_taxonomy_hierarchy_no_instance($children); ?>
                </optgroup>
            <?php endif ?>
        <?php } ?>

    <?php
    }

/*  Product categories transient
/*-------------------*/

    function fable_extra_get_product_categories_hierarchy() {

		if ( false === ( $categories = get_transient( 'product-categories-hierarchy' ) ) ) {

			$categories = fable_extra_get_product_taxonomy_hierarchy( 'product_cat', 0, 0);

			// do not set an empty transient - should help catch private or empty accounts.
			if ( ! empty( $categories ) ) {
				$categories = serialize( $categories );  // Serialize the data directly, no need to base64_encode
				set_transient( 'product-categories-hierarchy', $categories, apply_filters( 'null_categories_cache_time', 0 ) );
			}
		}

		if ( ! empty( $categories ) ) {
			$unserialized = @unserialize( $categories );
			if ( false === $unserialized ) {
				return new WP_Error( 'corrupt_data', esc_html__( 'Corrupted or invalid serialized data.', 'fable-extra' ) );
			}
			return $unserialized;
		} else {
			return new WP_Error( 'no_categories', esc_html__( 'No categories.', 'fable-extra' ) );
		}
	}


/*  Delete product categories transient
/*-------------------*/

    function fable_extra_edit_product_term($term_id, $tt_id, $taxonomy) {
        $term = get_term($term_id,$taxonomy);
        if (!is_wp_error($term) && is_object($term)) {
            $taxonomy = $term->taxonomy;
            if ($taxonomy == "product_cat") {
                delete_transient( 'product-categories-hierarchy' );
            }
        }
    }

    function fable_extra_delete_product_term($term_id, $tt_id, $taxonomy, $deleted_term) {
        if (!is_wp_error($deleted_term) && is_object($deleted_term)) {
            $taxonomy = $deleted_term->taxonomy;
            if ($taxonomy == "product_cat") {
                delete_transient( 'product-categories-hierarchy' );
            }
        }
    }
    add_action( 'create_term', 'fable_extra_edit_product_term', 99, 3 );
    add_action( 'edit_term', 'fable_extra_edit_product_term', 99, 3 );
    add_action( 'delete_term', 'fable_extra_delete_product_term', 99, 4 );

    add_action( 'save_post', 'fable_extra_save_post_product_action', 99, 3);
    function fable_extra_save_post_product_action( $post_id ){

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if (!current_user_can( 'edit_page', $post_id ) ) return;

        $post_info = get_post($post_id);

        if (!is_wp_error($post_info) && is_object($post_info)) {
            $content   = $post_info->post_content;
            $post_type = $post_info->post_type;

            if ($post_type == "product"){
                delete_transient( 'enovathemes-product-categories' );
            }
        }

    }

/*  Search action
/*-------------------*/

    function fable_extra_search_product() {
		check_ajax_referer('fable_search_nonce', '_ajax_nonce'); // ✅ CSRF protection

		global $wpdb;

		if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			$keyword = sanitize_text_field($_POST['keyword']);
			$like_keyword = '%' . $wpdb->esc_like($keyword) . '%';

			$querystr = '';
			$query_params = [];

			if (isset($_POST['category']) && !empty($_POST['category'])) {
				$category = intval($_POST['category']);

				$querystr = "
					SELECT DISTINCT p.* FROM $wpdb->posts AS p
					LEFT JOIN $wpdb->term_relationships AS r ON (p.ID = r.object_id)
					INNER JOIN $wpdb->term_taxonomy AS x ON (r.term_taxonomy_id = x.term_taxonomy_id)
					INNER JOIN $wpdb->terms AS t ON (r.term_taxonomy_id = t.term_id)
					WHERE p.post_type = 'product'
					AND p.post_status = 'publish'
					AND x.taxonomy = 'product_cat'
					AND (
						x.term_id = %d
						OR x.parent = %d
					)
					AND (
						p.ID IN (
							SELECT post_id FROM $wpdb->postmeta
							WHERE meta_key = '_sku' AND meta_value LIKE %s
						)
						OR p.post_content LIKE %s
						OR p.post_title LIKE %s
					)
					ORDER BY t.name ASC, p.post_date DESC
				";

				$query_params = [$category, $category, $like_keyword, $like_keyword, $like_keyword];

			} else {
				$querystr = "
					SELECT DISTINCT p.* FROM $wpdb->posts AS p
					INNER JOIN $wpdb->postmeta AS m ON (p.ID = m.post_id)
					WHERE p.post_status = 'publish'
					AND p.post_type = 'product'
					AND (
						(m.meta_key = '_sku' AND m.meta_value LIKE %s)
						OR (p.post_content LIKE %s)
						OR (p.post_title LIKE %s)
					)
					ORDER BY p.post_date DESC
				";

				$query_params = [$like_keyword, $like_keyword, $like_keyword];
			}

			$query = $wpdb->prepare($querystr, $query_params);
			$query_results = $wpdb->get_results($query);

			if (!empty($query_results)) {
				$output = '';

				foreach ($query_results as $result) {
					$price = get_post_meta($result->ID, '_regular_price', true);
					$price_sale = get_post_meta($result->ID, '_sale_price', true);
					$currency = get_woocommerce_currency_symbol();
					$sku = get_post_meta($result->ID, '_sku', true);
					$stock = get_post_meta($result->ID, '_stock_status', true);
					$categories = wp_get_post_terms($result->ID, 'product_cat');
					$rating = get_post_meta($result->ID, '_wc_average_rating', true);

					$output .= '<li>';
					$output .= '<div class="fable_extra_result_link">';
					$output .= '<div class="product-image"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'thumbnail')) . '"></div>';
					$output .= '<div class="product-data">';
					$output .= '<span class="product-title">' . esc_html($result->post_title) . '</span>';

					if ($rating) {
						for ($i = 0; $i < floor($rating); $i++) {
							$output .= '<div class="product-ratings"><i class="fa fa-star"></i></div>';
						}
					}

					$output .= '</div>';
					$output .= '<div class="price-stock">';

					if (!empty($stock)) {
						$color = $stock === 'instock' ? '#84c224' : '#ff0a0a';
						$output .= '<div class="product-stock" style="background:' . esc_attr($color) . ';">' . esc_html($stock) . '</div>';
					}

					$output .= '</div>';
					$output .= '<div class="product-price">';
					if (!empty($price)) {
						$output .= '<span class="regular-price">' . esc_html($price) . '</span>';
						if (!empty($price_sale)) {
							$output .= '<span class="sale-price">' . esc_html($price_sale) . '</span>';
						}
						$output .= $currency;
					}
					$output .= '</div>';

					$output .= '<div class="product-checkout">';
					$output .= '<a href="' . esc_url(wc_get_checkout_url()) . '"><i class="fa fa-truck"></i></a>';
					$output .= '</div>';

					$output .= '<form class="cart" method="post" enctype="multipart/form-data">
						<div class="quantity">
							<input type="number" step="1" min="1" name="quantity" value="1" title="Quantity" class="input-text qty text" size="4">
						</div>
						<button type="submit" data-quantity="1" data-product_id="' . esc_attr($result->ID) . '" class="button alt ajax_add_to_cart add_to_cart_button product_type_simple"><i class="fa fa-shopping-cart wf-mr-2"></i>Add to cart</button>
					</form>';

					$output .= '</div></li>';
				}

				echo $output;
			}
		}

		wp_die(); // Proper way to terminate AJAX
	}
	add_action('wp_ajax_fable_extra_search_product', 'fable_extra_search_product');
	add_action('wp_ajax_nopriv_fable_extra_search_product', 'fable_extra_search_product');

/*  Widget
/*-------------------*/

    add_action('widgets_init', 'register_product_search_widget');
    function register_product_search_widget(){
    	register_widget( 'Fable_Extra_product_search_widget' );
    }

    class Fable_Extra_product_search_widget extends WP_Widget {

    	public function __construct() {
    		parent::__construct(
    			'product_search_widget',
    			esc_html__('WP Fable Product Ajax Search', 'fable-extra'),
    			array( 'description' => esc_html__('WP Fable Product Ajax Search', 'fable-extra'))
    		);
    	}

    	public function widget( $args, $instance) {

    		//wp_enqueue_script('fable-extra-product-search-main');

    		extract($args);

    		$title = apply_filters( 'widget_title', $instance['title'] );

    		echo $before_widget;

    			if ( ! empty( $title ) ){echo $before_title . $title . $after_title;}

                ?>

    			<div class="product-search">
    				<form name="product-search" method="POST">
                        <?php $categories = fable_extra_get_product_categories_hierarchy(); ?>
                        <?php if ($categories): ?>
                            <select name="category" class="category">
                                <option class="default" value=""><?php echo esc_html__( 'Select a category', 'fable-extra' ); ?></option>
                                <?php fable_extra_list_product_taxonomy_hierarchy_no_instance( $categories); ?>
                            </select>
                        <?php endif ?>
                        <div class="search-wrapper">
                            <input type="search" name="search" class="search" placeholder="<?php esc_attr_e( 'Search for product...', 'fable-extra' ); ?>" value="">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 471.701 471.701">
									<path d="M409.6,0c-9.426,0-17.067,7.641-17.067,17.067v62.344C304.667-5.656,164.478-3.386,79.411,84.479
										c-40.09,41.409-62.455,96.818-62.344,154.454c0,9.426,7.641,17.067,17.067,17.067S51.2,248.359,51.2,238.933
										c0.021-103.682,84.088-187.717,187.771-187.696c52.657,0.01,102.888,22.135,138.442,60.976l-75.605,25.207
										c-8.954,2.979-13.799,12.652-10.82,21.606s12.652,13.799,21.606,10.82l102.4-34.133c6.99-2.328,11.697-8.88,11.674-16.247v-102.4
										C426.667,7.641,419.026,0,409.6,0z"/>
									<path d="M443.733,221.867c-9.426,0-17.067,7.641-17.067,17.067c-0.021,103.682-84.088,187.717-187.771,187.696
										c-52.657-0.01-102.888-22.135-138.442-60.976l75.605-25.207c8.954-2.979,13.799-12.652,10.82-21.606
										c-2.979-8.954-12.652-13.799-21.606-10.82l-102.4,34.133c-6.99,2.328-11.697,8.88-11.674,16.247v102.4
										c0,9.426,7.641,17.067,17.067,17.067s17.067-7.641,17.067-17.067v-62.345c87.866,85.067,228.056,82.798,313.122-5.068
										c40.09-41.409,62.455-96.818,62.344-154.454C460.8,229.508,453.159,221.867,443.733,221.867z"/>
								</svg>
                        </div>
    	            </form>
                    <div class="search-results woocommerce"></div>
        		</div>

    		<?php echo $after_widget;
    	}

     	public function form( $instance ) {

     		$defaults = array(
     			'title' => esc_html__('Product search', 'fable-extra'),
     		);

     		$instance = wp_parse_args((array) $instance, $defaults);

    		?>

    		<div id="<?php echo esc_attr($this->get_field_id( 'widget_id' )); ?>">

    			<p>
    				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title:', 'fable-extra' ); ?></label>
    				<input class="widefat <?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    			</p>

    		</div>

    		<?php
    	}

    	public function update( $new_instance, $old_instance ) {
    		$instance = $old_instance;
    		$instance['title'] = strip_tags( $new_instance['title'] );
    		return $instance;
    	}

    }
