<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) {

	header( 'HTTP/1.0 404 Not Found', true, 404 );

	exit;
}

// register action hooks
add_action( 'woocommerce_settings_start', 'fable_extra_woocompare_register_settings' );
add_action( 'woocommerce_settings_fable_extra_woocompare_list', 'fable_extra_woocompare_render_settings_page' );
add_action( 'woocommerce_update_options_fable_extra_woocompare_list', 'fable_extra_woocompare_update_options' );

// register filter hooks
add_filter( 'woocommerce_settings_tabs_array', 'fable_extra_woocompare_register_settings_tab', PHP_INT_MAX );

/**
 * Returns array of the plugin settings, which will be rendered in the
 * WooCommerce settings tab.
 *
 * @since 1.0.0
 *
 * @return array The array of the plugin settings.
 */
function fable_extra_woocompare_get_settings() {

	return array(
		array(
			'id'    => 'general-options',
			'type'  => 'title',
			'title' => __( 'General Options', 'fable-extra' ),
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'fable_extra_woocompare_enable',
			'title'   => __( 'Enable compare', 'fable-extra' ),
			'desc'    => __( 'Enable compare functionality.', 'fable-extra' ),
			'default' => 'yes',
		),
		array(
			'type'  => 'single_select_page',
			'id'    => 'fable_extra_woocompare_page',
			'class' => 'chosen_select_nostd',
			'title' => __( 'Select compare page', 'fable-extra' ),
			'desc'  => '<br>' . __( 'Select a page which will display compare list.', 'fable-extra' ),
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'fable_extra_woocompare_show_in_catalog',
			'title'   => __( 'Show in catalog', 'fable-extra' ),
			'desc'    => __( 'Enable compare functionality for catalog list.', 'fable-extra' ),
			'default' => 'yes',
		),
		array(
			'type'    => 'checkbox',
			'id'      => 'fable_extra_woocompare_show_in_single',
			'title'   => __( 'Show in products page', 'fable-extra' ),
			'desc'    => __( 'Enable compare functionality for single product page.', 'fable-extra' ),
			'default' => 'yes',
		),
		// array(
			// 'type'    => 'text',
			// 'id'      => 'fable_extra_woocompare_compare_text',
			// 'title'   => __( 'Compare button text', 'fable-extra' ),
			// 'desc'    => '<br>' . __( 'Enter text which will be displayed on the add to compare button.', 'fable-extra' ),
			// 'default' => __( 'Add to Compare', 'fable-extra' ),
		// ),
		// array(
			// 'type'    => 'text',
			// 'id'      => 'fable_extra_woocompare_remove_text',
			// 'title'   => __( 'Remove button text', 'fable-extra' ),
			// 'desc'    => '<br>' . __( 'Enter text which will be displayed on the remove from compare button.', 'fable-extra' ),
			// 'default' => __( 'Remove from Compare', 'fable-extra' ),
		// ),
		array(
			'type'    => 'text',
			'id'      => 'fable_extra_woocompare_page_btn_text',
			'title'   => __( 'Page button text' , 'fable-extra' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the compare page button.', 'fable-extra' ),
			'default' => __( 'Compare products' , 'fable-extra' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'fable_extra_woocompare_empty_btn_text',
			'title'   => __( 'Empty button text' , 'fable-extra' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the empty compare button.', 'fable-extra' ),
			'default' => __( 'Empty compare' , 'fable-extra' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'fable_extra_woocompare_empty_text',
			'title'   => __( 'Empty compare list text', 'fable-extra' ),
			'desc'    => '<br>' . __( 'Enter text which will be displayed on the compare page when is nothing to compare.', 'fable-extra' ),
			'default' => __( 'No products found to compare.', 'fable-extra' ),
		),
		array(
			'type'    => 'text',
			'id'      => 'fable_extra_woocompare_page_template',
			'title'   => __( 'Page template', 'fable-extra' ),
			'default' => __( 'page.tmpl', 'fable-extra' ),
		),
		array( 'type' => 'sectionend', 'id' => 'general-options' ),
	);
}

/**
 * Registers plugin settings in the WooCommerce settings array.
 *
 * @since 1.0.0
 * @action woocommerce_settings_start
 *
 * @global array $woocommerce_settings WooCommerce settings array.
 */
function fable_extra_woocompare_register_settings() {

	global $woocommerce_settings;

	$woocommerce_settings['fable_extra_woocompare_list'] = fable_extra_woocompare_get_settings();
}

/**
 * Registers WooCommerce settings tab which will display the plugin settings.
 *
 * @since 1.0.0
 * @filter woocommerce_settings_tabs_array PHP_INT_MAX
 *
 * @param array $tabs The array of already registered tabs.
 * @return array The extended array with the plugin tab.
 */
function fable_extra_woocompare_register_settings_tab( $tabs ) {

	$tabs['fable_extra_woocompare_list'] = esc_html__( 'WP Fable Compare List', 'fable-extra' );

	return $tabs;
}

/**
 * Renders plugin settings tab.
 *
 * @since 1.0.0
 * @action woocommerce_settings_fable_extra_woocompare_list
 *
 * @global array $woocommerce_settings The aggregate array of WooCommerce settings.
 * @global string $current_tab The current WooCommerce settings tab.
 */
function fable_extra_woocompare_render_settings_page() {

	global $woocommerce_settings, $current_tab;

	if ( function_exists( 'woocommerce_admin_fields' ) ) {

		woocommerce_admin_fields( $woocommerce_settings[$current_tab] );
	}
}

/**
 * Updates plugin settings after submission.
 *
 * @since 1.0.0
 * @action woocommerce_update_options_fable_extra_woocompare_list
 */
function fable_extra_woocompare_update_options() {

	if ( function_exists( 'woocommerce_update_options' ) ) {

		woocommerce_update_options( fable_extra_woocompare_get_settings() );
	}
}