<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Shopire
 */

/**
 * Theme Page Header Title
*/
function shopire_theme_page_header_title(){
	if( is_archive() )
	{
		echo '<h2>';
		if ( is_day() ) :
		/* translators: %1$s %2$s: date */	
		  printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('Archives','shopire'), get_the_date() );  
        elseif ( is_month() ) :
		/* translators: %1$s %2$s: month */	
		  printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('Archives','shopire'), get_the_date( 'F Y' ) );
        elseif ( is_year() ) :
		/* translators: %1$s %2$s: year */	
		  printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('Archives','shopire'), get_the_date( 'Y' ) );
		elseif( is_author() ):
		/* translators: %1$s %2$s: author */	
			printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('All posts by','shopire'), esc_html(get_the_author()) );
        elseif( is_category() ):
		/* translators: %1$s %2$s: category */	
			printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('Category','shopire'), single_cat_title( '', false ) );
		elseif( is_tag() ):
		/* translators: %1$s %2$s: tag */	
			printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('Tag','shopire'), single_tag_title( '', false ) );
		elseif( class_exists( 'WooCommerce' ) && is_shop() ):
		/* translators: %1$s %2$s: WooCommerce */	
			printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('Shop','shopire'), single_tag_title( '', false ));
        elseif( is_archive() ): 
		the_archive_title( '<h2>', '</h2>' ); 
		endif;
		echo '</h2>';
	}
	elseif( is_404() )
	{
		echo '<h2>';
		/* translators: %1$s: 404 */	
		printf( esc_html__( '%1$s ', 'shopire' ) , esc_html__('404','shopire') );
		echo '</h2>';
	}
	elseif( is_search() )
	{
		echo '<h2>';
		/* translators: %1$s %2$s: search */
		printf( esc_html__( '%1$s %2$s', 'shopire' ), esc_html__('Search results for','shopire'), get_search_query() );
		echo '</h2>';
	}
	else
	{
		echo '<h2>'.esc_html( get_the_title() ).'</h2>';
	}
}


/**
 * Theme Breadcrumbs Url
*/
function shopire_page_url() {
	$page_url = 'http';
	if ( key_exists("HTTPS", $_SERVER) && ( $_SERVER["HTTPS"] == "on" ) ){
		$page_url .= "s";
	}
	$page_url .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $page_url;
}


/**
 * Theme Breadcrumbs
*/
if( !function_exists('shopire_page_header_breadcrumbs') ):
	function shopire_page_header_breadcrumbs() { 	
		global $post;
		$homeLink = home_url();
								
			if (is_home() || is_front_page()) :
				echo '<li class="breadcrumb-item"><a href="'.$homeLink.'">'.__('Home','shopire').'</a></li>';
	            echo '<li class="breadcrumb-item active">'; echo single_post_title(); echo '</li>';
			else:
				echo '<li class="breadcrumb-item"><a href="'.$homeLink.'">'.__('Home','shopire').'</a></li>';
				if ( is_category() ) {
				    echo '<li class="breadcrumb-item active"><a href="'. shopire_page_url() .'">' . __('Archive by category','shopire').' "' . single_cat_title('', false) . '"</a></li>';
				} elseif ( is_day() ) {
					echo '<li class="breadcrumb-item active"><a href="'. get_year_link(get_the_time('Y')) . '">'. get_the_time('Y') .'</a>';
					echo '<li class="breadcrumb-item active"><a href="'. get_month_link(get_the_time('Y'),get_the_time('m')) .'">'. get_the_time('F') .'</a>';
					echo '<li class="breadcrumb-item active"><a href="'. shopire_page_url() .'">'. get_the_time('d') .'</a></li>';
				} elseif ( is_month() ) {
					echo '<li class="breadcrumb-item active"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>';
					echo '<li class="breadcrumb-item active"><a href="'. shopire_page_url() .'">'. get_the_time('F') .'</a></li>';
				} elseif ( is_year() ) {
				    echo '<li class="breadcrumb-item active"><a href="'. shopire_page_url() .'">'. get_the_time('Y') .'</a></li>';
				} elseif ( is_single() && !is_attachment() && is_page('single-product') ) {					
				if ( get_post_type() != 'post' ) {
					$cat = get_the_category(); 
					$cat = $cat[0];
					echo '<li class="breadcrumb-item">';
					echo get_category_parents($cat, TRUE, '');
					echo '</li>';
					echo '<li class="breadcrumb-item active"><a href="' . shopire_page_url() . '">'. get_the_title() .'</a></li>';
				} }  
					elseif ( is_page() && $post->post_parent ) {
				    $parent_id  = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						$breadcrumbs[] = '<li class="breadcrumb-item active"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach ($breadcrumbs as $crumb) echo $crumb;
					    echo '<li class="breadcrumb-item active"><a href="' . shopire_page_url() . '">'. get_the_title() .'</a></li>';
                    }
					elseif( is_search() )
					{
					    echo '<li class="breadcrumb-item active"><a href="' . shopire_page_url() . '">'. get_search_query() .'</a></li>';
					}
					elseif( is_404() )
					{
						echo '<li class="breadcrumb-item active"><a href="' . shopire_page_url() . '">'.__('Error 404','shopire').'</a></li>';
					}
					else { 
					    echo '<li class="breadcrumb-item active"><a href="' . shopire_page_url() . '">'. get_the_title() .'</a></li>';
					}
				endif;
        }
endif;


// Shopire Excerpt Read More
if ( ! function_exists( 'shopire_execerpt_btn' ) ) :
function shopire_execerpt_btn() {
	$shopire_show_post_btn		= get_theme_mod('shopire_show_post_btn','1'); 
	$shopire_read_btn_txt		= get_theme_mod('shopire_read_btn_txt','Read more'); 
	if ( $shopire_show_post_btn == '1' ) {
	?>
	<a href="<?php echo esc_url(get_the_permalink()); ?>" class="more-link"><?php echo wp_kses_post($shopire_read_btn_txt); ?></a>
<?php }
	} 
endif;

// Shopire excerpt length
function shopire_site_excerpt_length( $length ) {
	 $shopire_post_excerpt_length= get_theme_mod('shopire_post_excerpt_length','30'); 
    if( $shopire_post_excerpt_length == 1000 ) {
        return 9999;
    }
    return esc_html( $shopire_post_excerpt_length );
}
add_filter( 'excerpt_length', 'shopire_site_excerpt_length', 999 );



// Shopire excerpt more
function shopire_site_excerpt_more( $more ) {
	return get_theme_mod('shopire_blog_excerpt_more','&hellip;');;
}
add_filter( 'excerpt_more', 'shopire_site_excerpt_more' );


add_filter( 'woocommerce_show_admin_notice', function ( $show, $notice ) {
	if ( 'template_files' === $notice ) {
		return false;
	}

	return $show;
}, 10, 2 );

/*=========================================
Register Google fonts for Shopire.
=========================================*/
function shopire_google_fonts_url() {
	
    $font_families = array('Jost:wght@400;500;600;700;800;900');

	$fonts_url = add_query_arg( array(
		'family' => implode( '&family=', $font_families ),
		'display' => 'swap',
	), 'https://fonts.googleapis.com/css2' );

	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );

	return wptt_get_webfont_url( esc_url_raw( $fonts_url ) );
}

function shopire_google_fonts_scripts_styles() {
    wp_enqueue_style( 'shopire-google-fonts', shopire_google_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'shopire_google_fonts_scripts_styles' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function shopire_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	return $classes;
}
add_filter( 'body_class', 'shopire_body_classes' );

function shopire_post_classes( $classes ) {
	if ( is_single() ) : 
	$classes[]='single-post'; 
	endif;
	return $classes;
}
add_filter( 'post_class', 'shopire_post_classes' );


if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Backward compatibility for wp_body_open hook.
	 *
	 * @since 1.0.0
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if (!function_exists('shopire_str_replace_assoc')) {

    /**
     * shopire_str_replace_assoc
     * @param  array $replace
     * @param  array $subject
     * @return array
     */
    function shopire_str_replace_assoc(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
}


/**
 * Get registered sidebar name by sidebar ID.
 *
 * @since  1.0.0
 * @param  string $sidebar_id Sidebar ID.
 * @return string Sidebar name.
 */
function shopire_get_sidebar_name_by_id( $sidebar_id = '' ) {

	if ( ! $sidebar_id ) {
		return;
	}

	global $wp_registered_sidebars;
	$sidebar_name = '';

	if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
		$sidebar_name = $wp_registered_sidebars[ $sidebar_id ]['name'];
	}

	return $sidebar_name;
}



/*=========================================
	Product Category
=========================================*/
add_action('product_cat_add_form_fields', 'shopire_product_taxonomy_add_new_meta_field', 10, 1);
add_action('product_cat_edit_form_fields', 'shopire_product_taxonomy_edit_meta_field', 10, 1);
//Product Cat Create page
function shopire_product_taxonomy_add_new_meta_field() {
    ?>   
    <div class="form-field">
        <label for="shopire_product_cat_icon"><?php _e('Icon', 'shopire'); ?></label>
        <input type="text" name="shopire_product_cat_icon" id="shopire_product_cat_icon">
        <p class="description"><?php _e('Enter a meta title, <= 60 character', 'shopire'); ?></p>
    </div>
    <?php
}
//Product Cat Edit page
function shopire_product_taxonomy_edit_meta_field($term) {
    //getting term ID
    $term_id = $term->term_id;
    // retrieve the existing value(s) for this meta field.
    $shopire_product_cat_icon = get_term_meta($term_id, 'shopire_product_cat_icon', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="shopire_product_cat_icon"><?php _e('Icon', 'shopire'); ?></label></th>
        <td>
            <input type="text" name="shopire_product_cat_icon" id="shopire_product_cat_icon" value="<?php echo esc_attr($shopire_product_cat_icon) ? esc_attr($shopire_product_cat_icon) : ''; ?>">
        </td>
    </tr>
    <?php
}


add_action('edited_product_cat', 'shopire_save_taxonomy_product_meta', 10, 1);
add_action('create_product_cat', 'shopire_save_taxonomy_product_meta', 10, 1);
// Save extra taxonomy fields callback function.
function shopire_save_taxonomy_product_meta($term_id) {
    $shopire_product_cat_icon = filter_input(INPUT_POST, 'shopire_product_cat_icon');
    update_term_meta($term_id, 'shopire_product_cat_icon', $shopire_product_cat_icon);
}


//Displaying Additional Columns
add_filter( 'manage_edit-product_cat_columns', 'shopire_productFieldsListTitle' ); //Register Function
add_action( 'manage_product_cat_custom_column', 'shopire_productFieldsListDisplay' , 10, 3); //Populating the Columns
/**
 * Meta Title and Description column added to category admin screen.
 *
 * @param mixed $columns
 * @return array
 */
function shopire_productFieldsListTitle( $columns ) {
    $columns['shopire_product_cat_icon'] = __( 'Icon', 'shopire' );
    return $columns;
}
/**
 * Meta Title and Description column value added to product category admin screen.
 *
 * @param string $columns
 * @param string $column
 * @param int $id term ID
 *
 * @return string
 */
function shopire_productFieldsListDisplay( $columns, $column, $id ) {
    if ( 'shopire_product_cat_icon' == $column ) {
        $columns = esc_html( get_term_meta($id, 'shopire_product_cat_icon', true) );
    }
    return $columns;
}


/*=========================================
Shopire Footer Mobile Menu
=========================================*/
if ( ! function_exists( 'shopire_footer_mobile_menu' ) ) :
function shopire_footer_mobile_menu() {
	$shopire_hs_footer_mm  			= get_theme_mod( 'shopire_hs_footer_mm','1');
	$shopire_hs_footer_mm_home  	= get_theme_mod( 'shopire_hs_footer_mm_home','1');
	$shopire_footer_mm_home_icon  	= get_theme_mod( 'shopire_footer_mm_home_icon','far fa-home');
	$shopire_footer_mm_home_title  	= get_theme_mod( 'shopire_footer_mm_home_title','Home');
	$shopire_hs_footer_mm_shop  	= get_theme_mod( 'shopire_hs_footer_mm_shop','1');
	$shopire_footer_mm_shop_icon  	= get_theme_mod( 'shopire_footer_mm_shop_icon','far fa-grid-2');
	$shopire_footer_mm_shop_title  	= get_theme_mod( 'shopire_footer_mm_shop_title','Shop');
	$shopire_hs_footer_mm_cart  	= get_theme_mod( 'shopire_hs_footer_mm_cart','1');
	$shopire_footer_mm_cart_icon  	= get_theme_mod( 'shopire_footer_mm_cart_icon','far fa-cart-shopping');
	$shopire_footer_mm_cart_title  	= get_theme_mod( 'shopire_footer_mm_cart_title','Cart');
	$shopire_hs_footer_mm_ma  		= get_theme_mod( 'shopire_hs_footer_mm_ma','1');
	$shopire_footer_mm_ma_icon  	= get_theme_mod( 'shopire_footer_mm_ma_icon','far fa-user');
	$shopire_footer_mm_ma_title  	= get_theme_mod( 'shopire_footer_mm_ma_title','My Account');
	$shopire_hs_footer_mm_wl  		= get_theme_mod( 'shopire_hs_footer_mm_wl','1');
	$shopire_footer_mm_wl_icon  	= get_theme_mod( 'shopire_footer_mm_wl_icon','far fa-heart');
	$shopire_footer_mm_wl_title  	= get_theme_mod( 'shopire_footer_mm_wl_title','Wishlist');
	$shopire_hs_footer_mm_cm  		= get_theme_mod( 'shopire_hs_footer_mm_cm','1');
	$shopire_footer_mm_cm_icon  	= get_theme_mod( 'shopire_footer_mm_cm_icon','fas fa-exchange');
	$shopire_footer_mm_cm_title  	= get_theme_mod( 'shopire_footer_mm_cm_title','Compare');
	$shopire_hs_footer_mm_search  	= get_theme_mod( 'shopire_hs_footer_mm_search','1');
	$shopire_footer_mm_search_icon  = get_theme_mod( 'shopire_footer_mm_search_icon','far fa-search');
	$shopire_footer_mm_search_title  = get_theme_mod( 'shopire_footer_mm_search_title','Search');
	
	if($shopire_hs_footer_mm == '1') { 
	?>
	<div class="mobile-bottom-nav-wrapper">
        <div class="mobile-bottom-nav">
            <ul>
				<?php if($shopire_hs_footer_mm_home == '1'):  ?>
					<li>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active">
							<?php if(!empty($shopire_footer_mm_home_icon)): ?>
								<i class="<?php echo esc_attr($shopire_footer_mm_home_icon); ?>"></i>
							<?php endif; ?>	
							<?php if(!empty($shopire_footer_mm_home_title)): ?>
								<span><?php echo wp_kses_post($shopire_footer_mm_home_title); ?></span>
							<?php endif; ?>	
						</a>
					</li>
				<?php endif; ?>
				
               <?php if($shopire_hs_footer_mm_shop == '1'  && class_exists( 'woocommerce' )):  ?>
					<li>
						<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
							<?php if(!empty($shopire_footer_mm_shop_icon)): ?>
								<i class="<?php echo esc_attr($shopire_footer_mm_shop_icon); ?>"></i>
							<?php endif; ?>	
							<?php if(!empty($shopire_footer_mm_shop_title)): ?>
								<span><?php echo wp_kses_post($shopire_footer_mm_shop_title); ?></span>
							<?php endif; ?>	
						</a>
					</li>
				<?php endif; ?>
				
                 <?php if($shopire_hs_footer_mm_cart == '1'  && class_exists( 'woocommerce' )):  ?>
					<li>
						<a href="<?php echo esc_url(wc_get_cart_url()); ?>">
							<?php if(!empty($shopire_footer_mm_cart_icon)): ?>
								<i class="<?php echo esc_attr($shopire_footer_mm_cart_icon); ?>"></i>
							<?php endif; ?>	
							<?php if(!empty($shopire_footer_mm_cart_title)): ?>
								<span><?php echo wp_kses_post($shopire_footer_mm_cart_title); ?></span>
							<?php endif; ?>	
						</a>
					</li>
				<?php endif; ?>
				
				
				 <?php if($shopire_hs_footer_mm_ma == '1'  && class_exists( 'woocommerce' )):  ?>
					<li>
						<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>">
							<?php if(!empty($shopire_footer_mm_ma_icon)): ?>
								<i class="<?php echo esc_attr($shopire_footer_mm_ma_icon); ?>"></i>
							<?php endif; ?>	
							<?php if(!empty($shopire_footer_mm_ma_title)): ?>
								<span><?php echo wp_kses_post($shopire_footer_mm_ma_title); ?></span>
							<?php endif; ?>	
						</a>
					</li>
				<?php endif; ?>
				
				<?php if($shopire_hs_footer_mm_wl == '1' && function_exists( 'fable_extra_woowishlist_get_page_link' )  && class_exists( 'woocommerce' )):  ?>
					<li>
						<a href="<?php echo esc_url(fable_extra_woowishlist_get_page_link()); ?>">
							<?php 
								if ( function_exists( 'fable_extra_woowishlist_get_list' ) ) {
									$count =  count(fable_extra_woowishlist_get_list());
									
									if ( $count > 0 ) {
									?>
										 <span class="shopire-wcwl-items-count"><?php echo esc_html( $count ); ?></span>
									<?php 
									}
									else {
										?>
										<span class="shopire-wcwl-items-count"><?php echo esc_html_e('0','shopire'); ?></span>
										<?php 
									}
								}
							?>
							<?php if(!empty($shopire_footer_mm_wl_icon)): ?>
								<i class="<?php echo esc_attr($shopire_footer_mm_wl_icon); ?>"></i>
							<?php endif; ?>	
							<?php if(!empty($shopire_footer_mm_wl_title)): ?>
								<span><?php echo wp_kses_post($shopire_footer_mm_wl_title); ?></span>
							<?php endif; ?>	
						</a>
					</li>
				<?php endif; ?>
				
				
				<?php if($shopire_hs_footer_mm_cm == '1'  && function_exists( 'fable_extra_woocompare_get_page_link' )  && class_exists( 'woocommerce' )):  ?>
					<li>
						<a href="<?php echo esc_url(fable_extra_woocompare_get_page_link()); ?>">
							<?php 
								if ( function_exists( 'fable_extra_woocompare_get_list' ) ) {
									$count =  count(fable_extra_woocompare_get_list());
									
									if ( $count > 0 ) {
									?>
										 <span class="shopire-wcwl-items-count"><?php echo esc_html( $count ); ?></span>
									<?php 
									}
									else {
										?>
										<span class="shopire-wcwl-items-count"><?php echo esc_html_e('0','shopire'); ?></span>
										<?php 
									}
								}
							?>
							<?php if(!empty($shopire_footer_mm_cm_icon)): ?>
								<i class="<?php echo esc_attr($shopire_footer_mm_cm_icon); ?>"></i>
							<?php endif; ?>	
							<?php if(!empty($shopire_footer_mm_cm_title)): ?>
								<span><?php echo wp_kses_post($shopire_footer_mm_cm_title); ?></span>
							<?php endif; ?>	
						</a>
					</li>
				<?php endif; ?>
				
				<?php if($shopire_hs_footer_mm_search == '1'):  ?>
					<li>
						<a href="javascript:void(0);" class="wf_navbar-search-toggle">
							<?php if(!empty($shopire_footer_mm_search_icon)): ?>
								<i class="<?php echo esc_attr($shopire_footer_mm_search_icon); ?>"></i>
							<?php endif; ?>	
							<?php if(!empty($shopire_footer_mm_search_title)): ?>
								<span><?php echo wp_kses_post($shopire_footer_mm_search_title); ?></span>
							<?php endif; ?>
						</a>
						<div class="wf_search search--header">
							<form method="get" class="wf_search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'search again', 'shopire' ); ?>">
								<label for="wf_search-form-1">
									<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'shopire' ); ?></span>
									<input type="search" id="wf_search-form-1" class="wf_search-field" placeholder="<?php esc_attr_e( 'search Here', 'shopire' ); ?>" value="" name="s" />
								</label>
								<button type="submit" class="wf_search-submit search-submit"><i class="fas fa-search" aria-hidden="true"></i></button>
							</form>
							<button type="button" class="wf_search-close"><i class="far fa-arrow-up" aria-hidden="true"></i></button>
						</div>
					</li>
				<?php endif; ?>
            </ul>
        </div>
    </div>
	<?php
	}
} 
endif;
add_action( 'shopire_footer_mobile_menu', 'shopire_footer_mobile_menu',999 );

/*=========================================
Shopire Site Preloader
=========================================*/
if ( ! function_exists( 'shopire_site_preloader' ) ) :
function shopire_site_preloader() {
	$shopire_hs_preloader_option 	= get_theme_mod( 'shopire_hs_preloader_option','1'); 
	if($shopire_hs_preloader_option == '1') { 
	?>
		 <div id="wf_preloader" class="wf_preloader">
            <button type="button" class="wf_preloader-close site--close"></button>
            <div class="wf_preloader-animation">
                <div class="wf_preloader-spinner"></div>
                <div class="wf_preloader-text">
					<?php 
						$shopire_preloader_string = get_bloginfo('name');
						//Using the explode method
						$shopire_preloader_arr_string = str_split($shopire_preloader_string);

						//foreach loop to display the returned array
						foreach($shopire_preloader_arr_string as $str){
							echo sprintf(__('<span class="splitted" data-char=%1$s>%1$s</span>', 'shopire'),$str);
						}
					?>
                </div>
                <p class="text-center">Loading</p>
            </div>
            <div class="loader">
                <div class="wf-row">
                    <div class="wf-col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="wf-col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="wf-col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="wf-col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>
	<?php }
	} 
endif;
add_action( 'shopire_site_preloader', 'shopire_site_preloader' );



/*=========================================
Shopire Site Header
=========================================*/
if ( ! function_exists( 'shopire_site_main_header' ) ) :
function shopire_site_main_header() {
		get_template_part('template-parts/site','header');
} 
endif;
add_action( 'shopire_site_main_header', 'shopire_site_main_header' );



/*=========================================
Shopire Header Image
=========================================*/
if ( ! function_exists( 'shopire_wp_hdr_image' ) ) :
function shopire_wp_hdr_image() {
	if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-header" id="custom-header" rel="home">
		<img src="<?php echo esc_url(get_header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'title' )); ?>">
	</a>
<?php endif;
	} 
endif;
add_action( 'shopire_wp_hdr_image', 'shopire_wp_hdr_image' );


/*=========================================
Shopire Header Left Text
=========================================*/
if ( ! function_exists( 'shopire_header_left_text' ) ) :
function shopire_header_left_text() {
	$shopire_hs_hdr_top_contact 	= get_theme_mod( 'shopire_hs_hdr_top_contact','1'); 
	$shopire_hdr_top_contact_icon 	= get_theme_mod( 'shopire_hdr_top_contact_icon'); 
	$shopire_hdr_top_contact_title  = get_theme_mod( 'shopire_hdr_top_contact_title','🔥  Free shipping on all U.S. orders $50+');
	$shopire_hdr_top_contact_link 	= get_theme_mod( 'shopire_hdr_top_contact_link');
	if($shopire_hs_hdr_top_contact=='1'): ?>
		<aside class="widget widget_contact">
			<div class="contact__list">
				<?php if(!empty($shopire_hdr_top_contact_icon)): ?>
					<i class="<?php echo esc_attr($shopire_hdr_top_contact_icon); ?>" aria-hidden="true"></i>
				<?php endif; ?>
				<div class="contact__body">
					<?php if(!empty($shopire_hdr_top_contact_title)): ?>
						<?php if(!empty($shopire_hdr_top_contact_link)): ?>
							<h6 class="title"><a href="<?php echo esc_url($shopire_hdr_top_contact_link); ?>"><?php echo wp_kses_post($shopire_hdr_top_contact_title); ?></a></h6>
						<?php else: ?>
							<h6 class="title"><?php echo wp_kses_post($shopire_hdr_top_contact_title); ?></h6>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</aside>
	<?php endif;
} 
endif;
add_action( 'shopire_header_left_text', 'shopire_header_left_text' );

/*=========================================
Shopire Social Icon
=========================================*/
if ( ! function_exists( 'shopire_site_social' ) ) :
function shopire_site_social() {
	// Social 
	$shopire_hs_hdr_social 	= get_theme_mod( 'shopire_hs_hdr_social','1'); 
	$shopire_hdr_social 		= get_theme_mod( 'shopire_hdr_social',shopire_get_social_icon_default());
	if($shopire_hs_hdr_social=='1'): ?>
		<aside class="widget widget_social">
			<ul>
				<?php
					$shopire_hdr_social = json_decode($shopire_hdr_social);
					if( $shopire_hdr_social!='' )
					{
					foreach($shopire_hdr_social as $item){	
					$social_icon = ! empty( $item->icon_value ) ? apply_filters( 'shopire_translate_single_string', $item->icon_value, 'Header section' ) : '';	
					$social_link = ! empty( $item->link ) ? apply_filters( 'shopire_translate_single_string', $item->link, 'Header section' ) : '';
				?>
					<li><a href="<?php echo esc_url( $social_link ); ?>"><i class="<?php echo esc_attr( $social_icon ); ?>"></i></a></li>
				<?php }} ?>
			</ul>
		</aside>
	<?php endif;
} 
endif;
add_action( 'shopire_site_social', 'shopire_site_social' );


/*=========================================
Shopire Site Header
=========================================*/
if ( ! function_exists( 'shopire_site_header' ) ) :
function shopire_site_header() {
$shopire_hs_hdr 	= get_theme_mod( 'shopire_hs_hdr','1');
$shopire_header_design 	= get_theme_mod( 'shopire_header_design','header--one');
if($shopire_hs_hdr == '1') { 
?>
	<div class="wf_header-widget">
		<div class="wf-container">
			<div class="wf-row">
				<div class="wf-col-lg-5 wf-col-12">
					<div class="widget--left wf-text-lg-left">
						<?php  do_action('shopire_header_left_text'); ?>
						<?php  do_action('shopire_site_social'); ?>
					</div>
				</div>
				<div class="wf-col-lg-7 wf-col-12">
					<div class="widget--right wf-text-lg-right">    
						<?php 
						$shopire_widget = 'shopire-header-top-sidebar';
							if ( is_active_sidebar( $shopire_widget ) ){ 
									dynamic_sidebar( 'shopire-header-top-sidebar' );
							}elseif ( current_user_can( 'edit_theme_options' ) ) {
								$shopire_widget_name = shopire_get_sidebar_name_by_id( $shopire_widget );
								?>
								<div class="widget widget_none">
									<h6 class='widget-title'><?php echo esc_html( $shopire_widget_name ); ?></h6>
									<p>
										<?php if ( is_customize_preview() ) { ?>
											<a href="JavaScript:Void(0);" class="" data-sidebar-id="<?php echo esc_attr( $shopire_widget ); ?>">
										<?php } else { ?>
											<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>">
										<?php } ?>
											<?php esc_html_e( 'Please assign a widget here.', 'shopire' ); ?>
										</a>
									</p>
								</div>
								<?php
							} 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }
	} 
endif;
add_action( 'shopire_site_header', 'shopire_site_header' );



/*=========================================
Shopire Site Navigation
=========================================*/
if ( ! function_exists( 'shopire_site_header_navigation' ) ) :
function shopire_site_header_navigation() {
	wp_nav_menu( 
		array(  
			'theme_location' => 'primary_menu',
			'container'  => '',
			'menu_class' => 'wf_navbar-mainmenu',
			'fallback_cb' => 'shopire_fallback_page_menu',
			'walker' => new WP_Bootstrap_Navwalker()
			 ) 
		);
	} 
endif;
add_action( 'shopire_site_header_navigation', 'shopire_site_header_navigation' );


/*=========================================
Shopire Header Button
=========================================*/
if ( ! function_exists( 'shopire_header_button' ) ) :
function shopire_header_button() {
	$shopire_hs_hdr_btn 			= get_theme_mod( 'shopire_hs_hdr_btn','1'); 
	$shopire_hdr_btn_icon 		= get_theme_mod( 'shopire_hdr_btn_icon','fas fa-bolt'); 
	$shopire_hdr_btn_lbl 		= get_theme_mod( 'shopire_hdr_btn_lbl','Flash Sale'); 
	$shopire_hdr_btn_link 		= get_theme_mod( 'shopire_hdr_btn_link','#'); 
	$shopire_hdr_btn_target 		= get_theme_mod( 'shopire_hdr_btn_target');
	if($shopire_hdr_btn_target=='1'): $target='target=_blank'; else: $target=''; endif; 
	if($shopire_hs_hdr_btn=='1'  && !empty($shopire_hdr_btn_lbl)):	
?>
	<li class="wf_navbar-button-item">
		<a href="<?php echo esc_url($shopire_hdr_btn_link); ?>" <?php echo esc_attr($target); ?> class="wf-btn wf-btn-primary"><i class="<?php echo esc_attr($shopire_hdr_btn_icon); ?>"></i> <?php echo wp_kses_post($shopire_hdr_btn_lbl); ?></a>
	</li>
<?php endif;
	} 
endif;
add_action( 'shopire_header_button', 'shopire_header_button' );

/*=========================================
Shopire Browse Category
=========================================*/
if ( ! function_exists( 'shopire_header_bcat_base' ) ) :
function shopire_header_bcat_base() {
	$shopire_hs_hdr_bcat 		= get_theme_mod( 'shopire_hs_hdr_bcat','1'); 
	if($shopire_hs_hdr_bcat=='1' && class_exists( 'woocommerce' )):	
?>
	<ul class="wf_navbar-mainmenu">
		<?php
			$categories = array(
				  'taxonomy' => 'product_cat',
				  'hide_empty' => false,
				  'parent'   => 0
			  );
			$product_cat = get_terms( $categories );
			foreach ($product_cat as $parent_product_cat) {
				$child_args = array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'parent'   => $parent_product_cat->term_id
				);
				$thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true );
				$image = wp_get_attachment_url( $thumbnail_id );
				$child_product_cats = get_terms( $child_args );
				$shopire_product_cat_icon = get_term_meta($parent_product_cat->term_id, 'shopire_product_cat_icon', true);
				if ( ! empty($child_product_cats) ) {
					echo '<li class="menu-item menu-item-has-children" style="display: list-item;"><a title="'.esc_attr($parent_product_cat->name).'" href="'.esc_url(get_term_link($parent_product_cat->term_id)).'" class="nav-link">'.(!empty($shopire_product_cat_icon) ? "<i class='{$shopire_product_cat_icon} wf-mr-2'></i>":'').' '. esc_html($parent_product_cat->name).'</a>';
				} else {
					echo '<li class="menu-item" style="display: list-item;"><a title="'.esc_attr($parent_product_cat->name).'" href="'.esc_url(get_term_link($parent_product_cat->term_id)).'" class="nav-link">'.(!empty($shopire_product_cat_icon) ? "<i class='{$shopire_product_cat_icon} wf-mr-2'></i>":'').' '. esc_html($parent_product_cat->name).'</a>';
				}
				if ( ! empty($child_product_cats) ) {
					echo '<ul class="dropdown-menu">';
					foreach ($child_product_cats as $child_product_cat) {
					echo '<li class="menu-item" style="display: list-item;"><a title="'.esc_attr($parent_product_cat->name).'" href="'.esc_url(get_term_link($child_product_cat->term_id)).'" class="dropdown-item">'.esc_html($child_product_cat->name).'</a></li>';
					} echo '</ul>';
				} echo '</li>';
			} 
		?>
	</ul>
<?php endif;
	} 
endif;
add_action( 'shopire_header_bcat_base', 'shopire_header_bcat_base' );

/*=========================================
Shopire Browse Category
=========================================*/
if ( ! function_exists( 'shopire_header_bcat' ) ) :
function shopire_header_bcat() {
	$shopire_hs_hdr_bcat 		= get_theme_mod( 'shopire_hs_hdr_bcat','1'); 
	$shopire_hdr_bcat_icon 		= get_theme_mod( 'shopire_hdr_bcat_icon','fas fa-list-ul'); 
	$shopire_hdr_bcat_ttl 		= get_theme_mod( 'shopire_hdr_bcat_ttl','Browse Categories'); 
	$shopire_hdr_btn_target 	= get_theme_mod( 'shopire_hdr_btn_target');
	if($shopire_hdr_btn_target=='1'): $target='target=_blank'; else: $target=''; endif; 
	if($shopire_hs_hdr_bcat=='1' && class_exists( 'woocommerce' )):	
?>
	<div class="product-categories active">
		<button type="button" class="product-categories-btn">
			<?php if(!empty($shopire_hdr_bcat_icon)): ?><i class="<?php echo esc_attr($shopire_hdr_bcat_icon); ?> wf-mr-2"></i><?php endif; if(!empty($shopire_hdr_bcat_ttl)): echo wp_kses_post($shopire_hdr_bcat_ttl); endif; ?>
		</button>
		<nav class="wf_navbar-nav">
			<?php do_action('shopire_header_bcat_base'); ?>
		</nav>
	</div>
<?php endif;
	} 
endif;
add_action( 'shopire_header_bcat', 'shopire_header_bcat' );


/*=========================================
Shopire Header Contact
=========================================*/
if ( ! function_exists( 'shopire_header_contact' ) ) :
function shopire_header_contact() {
	$shopire_hs_hdr_contact 		= get_theme_mod( 'shopire_hs_hdr_contact','1'); 
	$shopire_hdr_contact_icon 		= get_theme_mod( 'shopire_hdr_contact_icon','fal fa-phone-volume'); 
	$shopire_hdr_contact_ttl 		= get_theme_mod( 'shopire_hdr_contact_ttl','Call Anytime'); 
	$shopire_hdr_contact_txt 		= get_theme_mod( 'shopire_hdr_contact_txt','<a href="tel:+8898006802">+ 88 ( 9800 ) 6802</a>'); 
	if($shopire_hs_hdr_contact=='1'):	
?>
	<li class="wf_navbar-info-contact">
		<aside class="widget widget_contact">
			<div class="contact__list">
				<?php if(!empty($shopire_hdr_contact_icon)): ?>
					<i class="<?php echo esc_attr($shopire_hdr_contact_icon); ?>" aria-hidden="true"></i>
				<?php endif; ?>	
				<div class="contact__body one">
					<?php if(!empty($shopire_hdr_contact_ttl)): ?>
						<h6 class="title"><?php echo wp_kses_post($shopire_hdr_contact_ttl); ?></h6>
					<?php endif; ?>
					<?php if(!empty($shopire_hdr_contact_txt)): ?>
						<p class="description"><?php echo wp_kses_post($shopire_hdr_contact_txt); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</aside>
	</li>
<?php endif;
	} 
endif;
add_action( 'shopire_header_contact', 'shopire_header_contact' );

/*=========================================
Shopire Product Search
=========================================*/
if ( ! function_exists( 'shopire_hdr_product_search' ) ) {
	function shopire_hdr_product_search() {
		$shopire_hs_hdr_search	= get_theme_mod( 'shopire_hs_hdr_search','1');
		if($shopire_hs_hdr_search=='1'): 
		 if(class_exists( 'woocommerce' ) && function_exists( 'fable_extra_get_product_categories_hierarchy' )): ?>
			<div class="header-search-form product-search">
				<form name="product-search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
					<div class="search-wrapper">
						<input type="search" name="s" class="search header-search-input" placeholder="<?php esc_attr_e( 'Search for product...', 'shopire' ); ?>" value="">
						<?php //echo file_get_contents(SHOPIRE_PARENT_INC_URI . '/shopire-woocommerce/assets/images/loading.svg'); ?>
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
					<?php $categories = fable_extra_get_product_categories_hierarchy(); ?>
					<?php if ($categories): ?>
					<div class="header-search-select-wrapper">
						<select name="category" class="category header-search-select">
							<option class="default" value=""><?php echo esc_html__( 'Category', 'shopire' ); ?></option>
							<?php fable_extra_list_product_taxonomy_hierarchy_no_instance( $categories); ?>
						</select>
					</div>
					<?php endif ?>
					<input type="hidden" name="post_type" value="product" />
					<button class="header-search-button" type="submit"><i class="fa fa-search"></i></button>
				</form>
				<div class="search-results woocommerce"></div>
			</div>
		<?php else: ?>	
			<div class="header-search-form product-search">
				<form method="get" class="wf_search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'search again', 'shopire' ); ?>">
					<label for="wf_search-form-1">
						<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'shopire' ); ?></span>
						<input type="search" id="wf_search-form-1" class="wf_search-field" placeholder="<?php esc_attr_e( 'search Here', 'shopire' ); ?>" value="" name="s" />
					</label>
					<button class="header-search-button" type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div>
		<?php endif; endif;
	}
}
add_action( 'shopire_hdr_product_search', 'shopire_hdr_product_search' );


/*=========================================
Shopire WooCommerce Cart
=========================================*/
if ( ! function_exists( 'shopire_woo_cart' ) ) :
function shopire_woo_cart() {
	$shopire_hs_hdr_cart 	= get_theme_mod( 'shopire_hs_hdr_cart','1'); 
		if($shopire_hs_hdr_cart=='1' && class_exists( 'WooCommerce' )):	
	?>
	<li class="wf_navbar-cart-item">
		<a href="javascript:void(0);" class="wf_navbar-cart-icon active">
			<span class="cart_icon"><i class="far fa-cart-shopping" aria-hidden="true"></i></span>
			<?php 
				$count = WC()->cart->cart_contents_count;
				
				if ( $count > 0 ) {
				?>
					 <strong class="cart_count"><?php echo esc_html( $count ); ?></strong>
				<?php 
				}
				else {
					?>
					<strong class="cart_count"><?php  esc_html_e('0','shopire'); ?></strong>
					<?php 
				}
		?>
		</a>
		<div class="wf_navbar-shopcart">
			<?php get_template_part('woocommerce/cart/mini','cart'); ?>
		</div>
	</li>
	<?php endif; 
	} 
endif;
add_action( 'shopire_woo_cart', 'shopire_woo_cart' );


 /**
 * Add WooCommerce Cart Icon With Cart Count (https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header)
 */
function shopire_woo_add_to_cart_fragment( $fragments ) {
	
    ob_start();
    $count = WC()->cart->cart_contents_count; 
    ?> 
	<?php 
			$count = WC()->cart->cart_contents_count;
			
			if ( $count > 0 ) {
			?>
				 <strong class="cart_count"><?php echo esc_html( $count ); ?></strong>
			<?php 
			}
			else {
				?>
				<strong class="cart_count"><?php esc_html_e('0','shopire'); ?></strong>
				<?php 
			}
	?>
	<?php
 
    $fragments['.cart_count'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'shopire_woo_add_to_cart_fragment' );



/*=========================================
Shopire Compare
=========================================*/
if ( ! function_exists( 'shopire_hcompare' ) ) {
	function shopire_hcompare() {
		$shopire_hs_hdr_compare	= get_theme_mod( 'shopire_hs_hdr_compare','1');
		if($shopire_hs_hdr_compare=='1'  && function_exists( 'fable_extra_woocompare_get_page_link' )):									
		?>	
			<li class="wf_navbar-compare-item">
				<a href="<?php echo esc_url(fable_extra_woocompare_get_page_link()); ?>" class="wf_compare_btn active">
					<span class="compare_icon"><i class="fas fa-exchange"></i></span>
					<?php 
						if ( function_exists( 'fable_extra_woocompare_get_list' ) ) {
							$count =  count(fable_extra_woocompare_get_list());
							
							if ( $count > 0 ) {
							?>
								 <span class="shopire-wcwl-items-count"><?php echo esc_html( $count ); ?></span>
							<?php 
							}
							else {
								?>
								<span class="shopire-wcwl-items-count"><?php esc_html_e('0','shopire'); ?></span>
								<?php 
							}
						}
					?>
				</a>
			</li>
		<?php endif;
	}
}
add_action( 'shopire_hcompare', 'shopire_hcompare' );


/*=========================================
Shopire Wishlist
=========================================*/
if ( ! function_exists( 'shopire_hwishlist' ) ) {
	function shopire_hwishlist() {
		$shopire_hs_hdr_wishlist	= get_theme_mod( 'shopire_hs_hdr_wishlist','1');
		if($shopire_hs_hdr_wishlist=='1'  && function_exists( 'fable_extra_woowishlist_get_page_link' )):									
		?>	
			<li class="wf_navbar-favourite-item">
				<a href="<?php echo esc_url(fable_extra_woowishlist_get_page_link()); ?>" class="wf_favourite_btn active">
					<span class="favourite_icon"><i class="far fa-heart"></i></span>
					<?php 
						if ( function_exists( 'fable_extra_woowishlist_get_list' ) ) {
							$count =  count(fable_extra_woowishlist_get_list());
							
							if ( $count > 0 ) {
							?>
								 <span class="shopire-wcwl-items-count"><?php echo esc_html( $count ); ?></span>
							<?php 
							}
							else {
								?>
								<span class="shopire-wcwl-items-count"><?php esc_html_e('0','shopire'); ?></span>
								<?php 
							}
						}
					?>
				</a>
			</li>
		<?php endif;
	}
}
add_action( 'shopire_hwishlist', 'shopire_hwishlist' );

/*=========================================
Shopire My Account
=========================================*/
if ( ! function_exists( 'shopire_hdr_account' ) ) {
	function shopire_hdr_account() {	
		$shopire_hs_hdr_account 		= get_theme_mod( 'shopire_hs_hdr_account','1');
		if($shopire_hs_hdr_account=='1'  && class_exists( 'woocommerce' )): ?>
			<li class="wf_navbar-user-item">
				<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" class="wf_user_btn"><i class="fas fa-user"></i></a>
			</li>
		<?php endif;
	}
}
add_action( 'shopire_hdr_account', 'shopire_hdr_account' );

/*=========================================
Shopire Header Docker
=========================================*/
if ( ! function_exists( 'shopire_hdr_side_docker' ) ) :
function shopire_hdr_side_docker() {
	$shopire_hs_side_docker 	= get_theme_mod( 'shopire_hs_side_docker','1'); 
	if($shopire_hs_side_docker=='1'):	
?>
	<li class="wf_navbar-sidebar-item">
		<div class="wf_navbar-sidebar-btn">
			<button type="button" class="wf_navbar-sidebar-toggle">
				<span class="lines">
					<span class="lines-1"></span>
					<span class="lines-2"></span>
				</span>
			</button>
			<div class="wf_sidebar">
				<div class="wf_sidebar-close off--layer"></div>
				<div class="wf_sidebar-wrapper">
					<div class="wf_sidebar-inner">
						<button type="button" class="wf_sidebar-close site--close"></button>
						<div class="wf_sidebar-content">
							<?php 
								$shopire_widget = 'shopire-header-docker-sidebar';
									if ( is_active_sidebar( $shopire_widget ) ){ 
											dynamic_sidebar( 'shopire-header-docker-sidebar' );
									}elseif ( current_user_can( 'edit_theme_options' ) ) {
										$shopire_widget_name = shopire_get_sidebar_name_by_id( $shopire_widget );
										?>
										<div class="widget widget_none">
											<h6 class='widget-title'><?php echo esc_html( $shopire_widget_name ); ?></h6>
											<p>
												<?php if ( is_customize_preview() ) { ?>
													<a href="JavaScript:Void(0);" class="" data-sidebar-id="<?php echo esc_attr( $shopire_widget ); ?>">
												<?php } else { ?>
													<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>">
												<?php } ?>
													<?php esc_html_e( 'Please assign a widget here.', 'shopire' ); ?>
												</a>
											</p>
										</div>
										<?php
									} 
								?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</li> 
<?php endif; 
	} 
endif;
add_action( 'shopire_hdr_side_docker', 'shopire_hdr_side_docker' );


/*=========================================
Shopire Site Logo
=========================================*/
if ( ! function_exists( 'shopire_site_logo' ) ) :
function shopire_site_logo() {
		$shopire_title_tagline_seo = get_theme_mod( 'shopire_title_tagline_seo');
		if(has_custom_logo())
			{	
				the_custom_logo();
			}
			else { 
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site--title">
				<h4 class="site-title">
					<?php 
						echo esc_html(get_bloginfo('name'));
					?>
				</h4>
			</a>	
		<?php 						
			}
		?>
		<?php if($shopire_title_tagline_seo=='1'): ?>	
			<h1 class="site-title" style="display: none;">
				<?php 
					echo esc_html(get_bloginfo('name'));
				?>
			</h1>
		<?php
			endif;
			$shopire_description = get_bloginfo( 'description');
			if ($shopire_description) : ?>
				<p class="site-description"><?php echo esc_html($shopire_description); ?></p>
		<?php endif;
	} 
endif;
add_action( 'shopire_site_logo', 'shopire_site_logo' );

/*=========================================
Shopire Footer Widget
=========================================*/
if ( ! function_exists( 'shopire_footer_widget' ) ) :
function shopire_footer_widget() {
	?>
	<div class="wf_footer_middle">
		<div class="wf-container">
			<div class="wf-row wf-g-lg-4 wf-g-5">
				<?php if ( is_active_sidebar( 'shopire-footer-widget-1' ) ) : ?>
					<div class="wf-col-lg-3 wf-col-sm-6 wf-col-12 wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
						<?php dynamic_sidebar( 'shopire-footer-widget-1'); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'shopire-footer-widget-2' ) ) : ?>
					<div class="wf-col-lg-3 wf-col-sm-6 wf-col-12 wow fadeInUp animated" data-wow-delay="100ms" data-wow-duration="1500ms">
						<?php dynamic_sidebar( 'shopire-footer-widget-2'); ?>	
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'shopire-footer-widget-3' ) ) : ?>
					<div class="wf-col-lg-3 wf-col-sm-6 wf-col-12 wow fadeInUp animated" data-wow-delay="200ms" data-wow-duration="1500ms">
						<?php dynamic_sidebar( 'shopire-footer-widget-3'); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'shopire-footer-widget-4' ) ) : ?>
					<div class="wf-col-lg-3 wf-col-sm-6 wf-col-12 wow fadeInUp animated" data-wow-delay="300ms" data-wow-duration="1500ms">
						<?php dynamic_sidebar( 'shopire-footer-widget-4'); ?>
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div>
	<?php 
	 } 
endif;
add_action( 'shopire_footer_widget', 'shopire_footer_widget' );


/*=========================================
Shopire Footer Bottom
=========================================*/
if ( ! function_exists( 'shopire_footer_bottom' ) ) :
function shopire_footer_bottom() {
	?>
	<div class="wf_footer_copyright">
		<div class="wf-container">
			<div class="wf-row wf-g-4 wf-mt-0">
				<div class="wf-col-md-12 wf-col-sm-12 wf-text-sm-center wf-text-center">
					<?php do_action('shopire_footer_copyright_data'); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	} 
endif;
add_action( 'shopire_footer_bottom', 'shopire_footer_bottom' );

/*=========================================
Shopire Footer Copyright
=========================================*/
if ( ! function_exists( 'shopire_footer_copyright_data' ) ) :
function shopire_footer_copyright_data() {
	$shopire_footer_copyright_text = get_theme_mod('shopire_footer_copyright_text','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');
	?>
	<?php if(!empty($shopire_footer_copyright_text)): 
			$shopire_copyright_allowed_tags = array(
				'[current_year]' => date_i18n('Y'),
				'[site_title]'   => get_bloginfo('name'),
				'[theme_author]' => sprintf(__('<a href="#">WP Fable</a>', 'shopire')),
			);
	?>
		<div class="wf_footer_copyright-text">
			<?php
				echo apply_filters('shopire_footer_copyright', wp_kses_post(shopire_str_replace_assoc($shopire_copyright_allowed_tags, $shopire_footer_copyright_text)));
			?>
		</div>
<?php endif;
	} 
endif;
add_action( 'shopire_footer_copyright_data', 'shopire_footer_copyright_data' );

/*=========================================
Shopire Scroller
=========================================*/
if ( ! function_exists( 'shopire_top_scroller' ) ) :
function shopire_top_scroller() {
	$shopire_hs_scroller_option	=	get_theme_mod('shopire_hs_scroller_option','1');
?>		
	<?php if ($shopire_hs_scroller_option == '1') { ?>
		<button type="button" id="wf_uptop" class="wf_uptop">
			<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
				<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: -0.0171453;"></path>
			</svg>
		</button>
	<?php }
	} 
endif;
add_action( 'shopire_top_scroller', 'shopire_top_scroller' );

function shopire_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'shopire_page_menu_args' );
function shopire_fallback_page_menu( $args = array() ) {
	$defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'wp_page_menu_args', $args );
	$menu = '';
	$list_args = $args;
	// Show Home in the menu
	if ( ! empty($args['show_home']) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = 'Home';
		else
			$text = $args['show_home'];
		$class = '';
		if ( is_front_page() && !is_paged() )
		{
		$class = 'class="nav-item menu-item active"';
		}
		else
		{
			$class = 'class="nav-item menu-item "';
		}
		$menu .= '<li ' . $class . '><a class="nav-link " href="' . esc_url(home_url( '/' )) . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
		// If the front page is a page, add it to the exclude list
		if (get_option('show_on_front') == 'page') {
			if ( !empty( $list_args['exclude'] ) ) {
				$list_args['exclude'] .= ',';
			} else {
				$list_args['exclude'] = '';
			}
			$list_args['exclude'] .= get_option('page_on_front');
		}
	}
	$list_args['echo'] = false;
	$list_args['title_li'] = '';
	$list_args['walker'] = new shopire_walker_page_menu;
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );
	if ( $menu )
		$menu = '<ul class="'. esc_attr($args['menu_class']) .'">' . $menu . '</ul>';

	$menu = $menu . "\n";
	$menu = apply_filters( 'wp_page_menu', $menu, $args );
	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;
}
class shopire_walker_page_menu extends Walker_Page{
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<span class='wf_mobilenav-dropdown-toggle'><button type='button' class='fa fa-angle-right' aria-label='Mobile Dropdown Toggle'></button></span><ul class='dropdown-menu default'>\n";
	}
	function start_el( &$output, $page, $depth=0, $args = array(), $current_page = 0 )
	 {
		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		if($depth === 0)
		{
			$child_class='nav-link';
		}
		else if($depth > 0)
		{
			$child_class='dropdown-item';
		}
		else
		{
			$child_class='';
		}
		extract($args, EXTR_SKIP);
		if($has_children){
			$css_class = array('menu-item page_item dropdown menu-item-has-children', 'page-item-'.$page->ID);
		}else{
			 $css_class = array('menu-item page_item dropdown', 'page-item-'.$page->ID);
		 }
		if ( !empty($current_page) ) {
			$_current_page = get_post( $current_page );
			if ( in_array( $page->ID, $_current_page->ancestors ) )
				$css_class[] = 'current_page_ancestor';
			if ( $page->ID == $current_page )
				$css_class[] = 'nav-item active';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$css_class[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current_page_parent';
		}
		$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
		$output .= $indent . '<li class="nav-item ' . $css_class . '"><a class="' . $child_class . '" href="' . esc_url(get_permalink($page->ID)) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';
		if ( !empty($show_date) ) {
			if ( 'modified' == $show_date )
				$time = $page->post_modified;
			else
				$time = $page->post_date;
			$output .= " " . mysql2date($date_format, $time);
		}
	}
}


// Hide Shop Page Title
add_filter('woocommerce_show_page_title', 'shopire_hide_shop_page_title');
function shopire_hide_shop_page_title($title) {
   if (is_shop()) $title = false;
   return $title;
}

if ( ! function_exists( 'shopire_post_sharing' ) ) { 
	function shopire_post_sharing() {	
	
	global $post; ?>
	
	<div class="social-share-tooltip">
		<i class="far fa-share-nodes" aria-hidden="true"></i>
		<div class="social-share">
			<?php $facebook_link = 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( get_the_permalink() ); ?>
			<a href="<?php echo esc_url ( $facebook_link ); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
			
			<?php $twitter_link = 'https://twitter.com/intent/tweet?url='. esc_url( get_the_permalink() ); ?>
			<a href="<?php echo esc_url ( $twitter_link ); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
			
			<?php $linkedin_link = 'http://www.linkedin.com/shareArticle?url='.esc_url( get_the_permalink() ).'&amp;title='.get_the_title(); ?>
			<a href="<?php echo esc_url( $linkedin_link ); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
			
			<?php $pinterest_link = 'https://pinterest.com/pin/create/button/?url='.esc_url( get_the_permalink() ).'&amp;media='.esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID)) ).'&amp;description='.get_the_title(); ?>
			<a href="<?php echo esc_url( $pinterest_link ); ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
			
			<?php $whatsapp_link = 'https://api.whatsapp.com/send?text=*'. get_the_title() .'*\n'. esc_html( get_the_excerpt() ) .'\n'. esc_url( get_the_permalink() ); ?>
			<a href="<?php echo esc_url( $whatsapp_link ); ?>" target="_blank"><i class="fab fa-whatsapp"></i></a>
			
			<?php $tumblr_link = 'http://www.tumblr.com/share/link?url='. urlencode( esc_url(get_permalink()) ) .'&amp;name='.urlencode( get_the_title() ).'&amp;description='.urlencode( wp_trim_words( get_the_excerpt(), 50 ) ); ?>
			<a href="<?php echo esc_url( $tumblr_link ); ?>" target="_blank"><i class="fab fa-tumblr"></i></a>
			
			<?php $reddit_link = 'http://reddit.com/submit?url='. esc_url( get_the_permalink() ) .'&amp;title='.get_the_title(); ?>
			<a href="<?php echo esc_url( $reddit_link ); ?>" target="_blank"><i class="fab fa-reddit"></i></a>
		</div>
	</div>
	<?php
	}
}
add_action( 'shopire_post_sharing', 'shopire_post_sharing' );



// Function to retrieve the post views count
function shopire_get_post_view($post_id) {
    $count = get_post_meta( $post_id, 'post_views_count', true );
    if (!empty($count)) {
        return $count . " views";
    } else {
        return "0 views";
    }
}

// Function to increment the post views count
function shopire_set_post_view() {
    if (is_single()) {  // Only count views on single post page
        $post_id = get_the_ID();
        $key = 'post_views_count';
        $count = (int) get_post_meta( $post_id, $key, true );
        $count++;
        update_post_meta( $post_id, $key, $count );
    }
}
add_action('wp_head', 'shopire_set_post_view');  // Increment views when viewing a single post

// Add custom column for post views in admin posts list
function shopire_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';  // Add "Views" column
    return $columns;
}
add_filter('manage_posts_columns', 'shopire_posts_column_views');

// Display views count in the custom column for posts
function shopire_posts_custom_column_views( $column, $post_id ) {
    if ( $column === 'post_views') {
        echo shopire_get_post_view($post_id);  // Display views in the column
    }
}
add_action( 'manage_posts_custom_column', 'shopire_posts_custom_column_views', 10, 2 ); // Add second argument $post_id


/**
 * Calculate reading time by content length
 *
 * @param string  $text Content to calculate
 * @return int Number of minutes
 * @since  1.0
 */

if ( !function_exists( 'shopire_read_time' ) ):
	function shopire_read_time() {
		global $post;
		$content = get_post_field( 'post_content', $post->ID );
		$word_count = str_word_count( strip_tags( $content ) );
		$readingtime = ceil($word_count / 200);

		if ($readingtime == 1) {
		$timer = " minute Read";
		} else {
		$timer = " minutes Read";
		}
		$totalreadingtime = $readingtime . $timer;

		return $totalreadingtime;
	}
endif;

/*
 *
 * Social Icon
 */
function shopire_get_social_icon_default() {
	return apply_filters(
		'shopire_get_social_icon_default', json_encode(
				 array(
				array(
					'icon_value'	  =>  esc_html__( 'fab fa-facebook-f', 'shopire' ),
					'link'	  =>  esc_html__( '#', 'shopire' ),
					'id'              => 'customizer_repeater_header_social_001',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fab fa-google-plus-g', 'shopire' ),
					'link'	  =>  esc_html__( '#', 'shopire' ),
					'id'              => 'customizer_repeater_header_social_002',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fab fa-x-twitter', 'shopire' ),
					'link'	  =>  esc_html__( '#', 'shopire' ),
					'id'              => 'customizer_repeater_header_social_003',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fab fa-tiktok', 'shopire' ),
					'link'	  =>  esc_html__( '#', 'shopire' ),
					'id'              => 'customizer_repeater_header_social_004',
				)
			)
		)
	);
}

if ( ! function_exists( 'shopire_after_before' ) ) { 
	function shopire_after_before($shopire_page) {	
		if( !empty($shopire_page)){
			?>
			<div class="wf-container">
				<?php 
					$shopire_page_query = new wp_query('page_id='.$shopire_page); 
					if($shopire_page_query->have_posts() ){ 
					   while( $shopire_page_query->have_posts() ) { $shopire_page_query->the_post();
							the_content();
						}
					} wp_reset_postdata(); 
				?>
			</div>
		<?php }
	}
}

if ( ! function_exists( 'shopire_popular_product_option_before' ) ) { 
	function shopire_popular_product_option_before() {	
		$shopire_page	= get_theme_mod('shopire_popular_product_option_before');
		shopire_after_before($shopire_page);
	}
	add_action('shopire_popular_product_option_before','shopire_popular_product_option_before');
}	


if ( ! function_exists( 'shopire_popular_product_option_after' ) ) { 
	function shopire_popular_product_option_after() {	
		$shopire_page	= get_theme_mod('shopire_popular_product_option_after');
		shopire_after_before($shopire_page);
	}
	add_action('shopire_popular_product_option_after','shopire_popular_product_option_after');
}