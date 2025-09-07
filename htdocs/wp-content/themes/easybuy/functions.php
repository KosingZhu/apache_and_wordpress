<?php
/**
 * Theme functions and definitions
 *
 * @package EasyBuy
 */

/**
 * After setup theme hook
 */
function easybuy_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'easybuy' );	
}
add_action( 'after_setup_theme', 'easybuy_theme_setup' );

/**
 * Load assets.
 */

function easybuy_theme_css() {
	wp_enqueue_style( 'easybuy-parent-theme-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'easybuy_theme_css', 99);

require get_stylesheet_directory() . '/theme-functions/controls/class-customize.php';

/**
 * Import Options From Parent Theme
 *
 */
function easybuy_parent_theme_options() {
	$easybuy_mods = get_option( 'theme_mods_shopire' );
	if ( ! empty( $easybuy_mods ) ) {
		foreach ( $easybuy_mods as $easybuy_mod_k => $easybuy_mod_v ) {
			set_theme_mod( $easybuy_mod_k, $easybuy_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'easybuy_parent_theme_options' );