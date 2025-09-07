<?php
/**
 * Theme functions and definitions
 *
 * @package MiniCart
 */

/**
 * After setup theme hook
 */
function minicart_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'minicart' );	
}
add_action( 'after_setup_theme', 'minicart_theme_setup' );

/**
 * Load assets.
 */

function minicart_theme_css() {
	wp_enqueue_style( 'minicart-parent-theme-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'minicart_theme_css', 99);

require get_stylesheet_directory() . '/theme-functions/controls/class-customize.php';

/**
 * Import Options From Parent Theme
 *
 */
function minicart_parent_theme_options() {
	$minicart_mods = get_option( 'theme_mods_shopire' );
	if ( ! empty( $minicart_mods ) ) {
		foreach ( $minicart_mods as $minicart_mod_k => $minicart_mod_v ) {
			set_theme_mod( $minicart_mod_k, $minicart_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'minicart_parent_theme_options' );

/*=========================================
 MiniCart Customize 
=========================================*/
function minicart_customize_setting( $wp_customize ) {
	$wp_customize->add_section(
		'header_image', array(
			'title' => esc_html__( 'Header Image', 'minicart' ),
			'panel' => 'header_options',
		)
	);
}
add_action( 'customize_register', 'minicart_customize_setting',99 );

/**
 * Sample implementation of the Custom Header feature
 */
function minicart_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'minicart_custom_header_args', array(
		'default-image'          => esc_url(get_stylesheet_directory_uri() . '/assets/images/banner.png'),
		'default-text-color'     => '000',
		'width'                  => 1920,
		'height'                 => 200,
		'flex-height'            => true,
		'wp-head-callback'       => 'shopire_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'minicart_custom_header_setup' );