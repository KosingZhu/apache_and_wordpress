<?php
/**
 * Fired during plugin Activation
 *
 * @package    Fable Extra
 */

/**
 * This class defines all code necessary to run during the plugin's activation.
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
class fable_extra_Activator {

	public static function activate() {

        $item_details_page = get_option('item_details_page');
		$fable_current_theme = wp_get_theme(); // gets the current theme
		if(!$item_details_page){
		if( 'Shopire' == $fable_current_theme->name || 'MiniCart' == $fable_current_theme->name  || 'EazyShop' == $fable_current_theme->name  || 'EasyBuy' == $fable_current_theme->name  || 'eKart' == $fable_current_theme->name){
				require WPFE_PATH .'inc/themes/shopire/fresh-site-data/media.php';
				require WPFE_PATH .'inc/themes/shopire/fresh-site-data/widget.php';
			}	
			$pages = array( esc_html__( 'Home', 'fable-extra' ), esc_html__( 'Blog', 'fable-extra' ) );
					foreach ($pages as $page){ 
					$post_data = array( 'post_author' => 1, 'post_name' => $page,  'post_status' => 'publish' , 'post_title' => $page, 'post_type' => 'page', ); 	
					if($page== 'Home'): 
						$page_option = 'page_on_front';
						$template = 'page-templates/frontpage.php';	
					else: 	
						$page_option = 'page_for_posts';
						$template = 'page.php';
					endif;
					$post_data = wp_insert_post( $post_data, false );
						if ( $post_data ){
							update_post_meta( $post_data, '_wp_page_template', $template );
							$page = new WP_Query(
								array(
									'post_type'              => 'page',
									'title'                  => $page,
									'posts_per_page'         => 1,
									'no_found_rows'          => true,
									'ignore_sticky_posts'    => true,
									'update_post_term_cache' => false,
									'update_post_meta_cache' => false,
								)
							);
							update_option( 'show_on_front', 'page' );
							update_option( $page_option, $page->post->ID );
						}
					}
			
			update_option( 'item_details_page', 'Done' );
				
		}
	}

}