<?php
/**
 * Shopire Customizer Class
 *
 * @package Shopire
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

 if ( ! class_exists( 'Shopire_Customizer' ) ) :

	class Shopire_Customizer {

		// Constructor customizer
		public function __construct() {
			add_action( 'customize_register',array( $this, 'shopire_customizer_register' ) );
			add_action( 'customize_register',array( $this, 'shopire_customizer_sainitization_selective_refresh' ) );
			add_action( 'customize_register',array( $this, 'shopire_customizer_control' ) );
			add_action( 'customize_preview_init',array( $this, 'shopire_customize_preview_js' ) );
			add_action( 'customize_controls_enqueue_scripts',array( $this, 'shopire_customizer_navigation_script' ) );
			add_action( 'after_setup_theme',array( $this, 'shopire_customizer_settings' ) );
		}
		
		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function shopire_customizer_register( $wp_customize ) {
			
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
			$wp_customize->get_setting('custom_logo')->transport = 'refresh';
		}
		
		// Register custom controls
		public function shopire_customizer_control( $wp_customize ) {
			
			$shopire_control_dir =  SHOPIRE_THEME_INC_DIR . '/customizer/controls';
			
			// Load custom control classes.
			$wp_customize->register_control_type( 'Shopire_Customizer_Range_Control' );
			require $shopire_control_dir . '/code/shopire-slider-control.php';
			require $shopire_control_dir . '/code/shopire-icon-picker-control.php';
			require $shopire_control_dir . '/code/shopire-category-dropdown-control.php';
			require $shopire_control_dir . '/code/shopire-product-category-control.php';

		}
		
		
		// selective refresh.
		public function shopire_customizer_sainitization_selective_refresh() {

			require SHOPIRE_THEME_INC_DIR . '/customizer/sanitization.php';

		}

		// Theme Customizer preview reload changes asynchronously.
		public function shopire_customize_preview_js() {
			wp_enqueue_script( 'shopire-customizer', SHOPIRE_THEME_INC_URI . '/customizer/assets/js/customizer-preview.js', array( 'customize-preview' ), SHOPIRE_THEME_VERSION, true );
		}
		
		public function shopire_customizer_navigation_script() {
			 wp_enqueue_script( 'shopire-customizer-section', SHOPIRE_THEME_INC_URI .'/customizer/assets/js/customizer-section.js', array("jquery"),'', true  );	
		}
		

		// Include customizer settings.
			
		public function shopire_customizer_settings() {
			// Recommended Plugin
			require SHOPIRE_THEME_INC_DIR . '/customizer/customizer-plugin-notice/shopire-notify-plugin.php';
			
			// Upsale
			require SHOPIRE_THEME_INC_DIR . '/customizer/controls/code/upgrade/class-customize.php';
			
			$shopire_customize_dir =  SHOPIRE_THEME_INC_DIR . '/customizer/customizer-settings';
			require $shopire_customize_dir . '/shopire-header-customize-setting.php';
			require $shopire_customize_dir . '/shopire-footer-customize-setting.php';
			require $shopire_customize_dir . '/shopire-theme-customize-setting.php';
			require $shopire_customize_dir . '/shopire-typography-customize-setting.php';
			require SHOPIRE_THEME_INC_DIR . '/customizer/shopire-selective-partial.php';
			require SHOPIRE_THEME_INC_DIR . '/customizer/shopire-selective-refresh.php';
		}

	}
endif;
new Shopire_Customizer();