<?php
/*
Plugin Name: Fable Extra
Plugin URI: 
Description: Used for WP Fable Themes.
Version: 1.0.9
Author: WP Fable
Author URI: https://wpfable.com/
Tested up to: 6.8
Requires at least: 5.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl.html
Requires PHP: 5.6
Text Domain: fable-extra
*/

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// Path/URL to root of this plugin, with trailing slash.
if ( ! defined( 'WPFE_PATH' ) ) {
	define( 'WPFE_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WPFE_URL' ) ) {
	define( 'WPFE_URL', plugin_dir_url( __FILE__ ) );
}


if( !function_exists('fable_extra_init') ){
	function fable_extra_init(){
		require_once('inc/controls/fable-customize-upgrade-control.php');
		/**
		 * Get Activated Theme
		 */
		$fable_axtra_activated_theme = wp_get_theme(); // gets the current theme
		// Shopire Theme
		if( 'Shopire' == $fable_axtra_activated_theme->name  || 'Shopire Child' == $fable_axtra_activated_theme->name){
			require WPFE_PATH . 'inc/themes/shopire/shopire.php';
		}
		
		// MiniCart Theme
		if( 'MiniCart' == $fable_axtra_activated_theme->name){
			require WPFE_PATH . 'inc/themes/minicart/minicart.php';
		}
		
		// EazyShop Theme
		if( 'EazyShop' == $fable_axtra_activated_theme->name){
			require WPFE_PATH . 'inc/themes/eazyshop/eazyshop.php';
		}
		
		// EasyBuy Theme
		if( 'EasyBuy' == $fable_axtra_activated_theme->name){
			require WPFE_PATH . 'inc/themes/easybuy/easybuy.php';
		}
		
		// eKart Theme
		if( 'eKart' == $fable_axtra_activated_theme->name){
			require WPFE_PATH . 'inc/themes/ekart/ekart.php';
		}
	}
	add_action( 'init', 'fable_extra_init' );
}


if( !function_exists('fable_extra_woo_feature') ){
	function fable_extra_woo_feature(){
		if(class_exists( 'woocommerce' )):
			$fable_extra_activated_theme = wp_get_theme(); // gets the current theme
			$fable_extra_themes = array('Shopire','Shopire Child','MiniCart','EazyShop','EasyBuy','eKart');
			if (in_array($fable_extra_activated_theme->name, $fable_extra_themes)){
				$woo_features = array(
					'compare-wishlist',
					 'product-search',
					 'quick-view',
				);
				
				foreach ( $woo_features as $feature ) {
					 $feature_file = plugin_dir_path( __FILE__ ) . 'inc/woo-features/fable-extra-' . $feature . '.php';
					 if ( file_exists( $feature_file ) ) {
						require_once $feature_file;
					} else {
						// Optionally, log an error or take action if file doesn't exist
						error_log( "Feature file not found: " . $feature_file );
					}
				}
			}	
		endif;
	}
	add_action( 'plugins_loaded', 'fable_extra_woo_feature','11' );
}

/**
 * The code during plugin activation.
 */
function fable_extra_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/fable-extra-activator.php';
	fable_extra_Activator::activate();
}
register_activation_hook( __FILE__, 'fable_extra_activate' );