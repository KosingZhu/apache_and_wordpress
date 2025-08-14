<?php
/**
 * Shopire functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shopire
 */
 
if ( ! function_exists( 'shopire_theme_setup' ) ) :
function shopire_theme_setup() {
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Shopire, use a find and replace
	 * to change 'Shopire' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'shopire' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	add_theme_support( 'custom-header' );
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary_menu' => esc_html__( 'Primary Menu', 'shopire' )
	) );
	
	//Add selective refresh for sidebar widget
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	// woocommerce support
	add_theme_support( 'woocommerce' );
	
	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support('custom-logo');
	
	/**
	 * Custom background support.
	 */
	add_theme_support( 'custom-background', apply_filters( 'shopire_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	/**
	 * Set default content width.
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = 800;
	}	
}
endif;
add_action( 'after_setup_theme', 'shopire_theme_setup' );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function shopire_widgets_init() {	
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar( array(
			'name' => __( 'WooCommerce Widget Area', 'shopire' ),
			'id' => 'shopire-woocommerce-sidebar',
			'description' => __( 'This Widget area for WooCommerce Widget', 'shopire' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h5 class="widget-title">',
			'after_title' => '</h5>',
		) );
	}
	
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'shopire' ),
		'id' => 'shopire-sidebar-primary',
		'description' => __( 'The Primary Widget Area', 'shopire' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title"><span></span>',
		'after_title' => '</h5>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Header Top Bar Widget Area', 'shopire' ),
		'id' => 'shopire-header-top-sidebar',
		'description' => __( 'Header Top Bar Widget Area', 'shopire' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>'
	) );
	
	register_sidebar( array(
		'name' => __( 'Header Side Docker Area', 'shopire' ),
		'id' => 'shopire-header-docker-sidebar',
		'description' => __( 'Header Side Docker Area', 'shopire' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title"><span></span>',
		'after_title' => '</h5>',
	) );
	
	$shopire_footer_widget_column = get_theme_mod('shopire_footer_widget_column','4');
	for ($i=1; $i<=$shopire_footer_widget_column; $i++) {
		register_sidebar( array(
			'name' => __( 'Footer  ', 'shopire' )  . $i,
			'id' => 'shopire-footer-widget-' . $i,
			'description' => __( 'The Footer Widget Area', 'shopire' )  . $i,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h5 class="widget-title">',
			'after_title' => '</h5>',
		) );
	}
}
add_action( 'widgets_init', 'shopire_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function shopire_scripts() {
	
	/**
	 * Styles.
	 */
	// Owl Crousel	
	wp_enqueue_style('owl-carousel-min',get_template_directory_uri().'/assets/vendors/css/owl.carousel.min.css');
	
	// Font Awesome
	wp_enqueue_style('all-css',get_template_directory_uri().'/assets/vendors/css/all.min.css');
	
	// Animate
	wp_enqueue_style('animate',get_template_directory_uri().'/assets/vendors/css/animate.css');

	// Fancybox
	wp_enqueue_style('Fancybox',get_template_directory_uri().'/assets/vendors/css/jquery.fancybox.min.css');
	
	// Shopire Core
	wp_enqueue_style('shopire-core',get_template_directory_uri().'/assets/css/core.css');

	// Shopire Theme
	wp_enqueue_style('shopire-theme', get_template_directory_uri() . '/assets/css/themes.css');
	
	// Shopire WooCommerce
	wp_enqueue_style('shopire-woocommerce',get_template_directory_uri().'/assets/css/woo-styles.css');
	
	// Shopire Style
	wp_enqueue_style( 'shopire-style', get_stylesheet_uri() );
	
	// Scripts
	wp_enqueue_script( 'jquery' );
	
	// Imagesloaded
	wp_enqueue_script( 'imagesloaded' );
	
	// Owl Crousel
	wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/vendors/js/owl.carousel.js', array('jquery'), true);
	
	// Wow
	wp_enqueue_script('wow-min', get_template_directory_uri() . '/assets/vendors/js/wow.min.js', array('jquery'), false, true);
	
	// fancybox
	wp_enqueue_script('fancybox', get_template_directory_uri() . '/assets/vendors/js/jquery.fancybox.js', array('jquery'), false, true);
	
	// Shopire Theme
	wp_enqueue_script('shopire-theme', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), false, true);

	// Shopire custom
	wp_enqueue_script('shopire-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), false, true);
		
	  
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shopire_scripts' );


/**
 * Enqueue admin scripts and styles.
 */
function shopire_admin_enqueue_scripts(){
	wp_enqueue_style('shopire-admin-style', get_template_directory_uri() . '/inc/admin/assets/css/admin.css');
	wp_enqueue_script( 'shopire-admin-script', get_template_directory_uri() . '/inc/admin/assets/js/shopire-admin-script.js', array( 'jquery' ), '', true );
    wp_localize_script( 'shopire-admin-script', 'shopire_ajax_object',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce('shopire_nonce')
        )
    );
}
add_action( 'admin_enqueue_scripts', 'shopire_admin_enqueue_scripts' );

/**
 * Enqueue User Custom styles.
 */
 if( ! function_exists( 'shopire_user_custom_style' ) ):
    function shopire_user_custom_style() {

		$shopire_print_style = '';
		
		 /*=========================================
		 Shopire Page Title
		=========================================*/
		$shopire_print_style   .= shopire_customizer_value( 'shopire_breadcrumb_height_option', '.wf_pagetitle', array( 'padding-top' ), array( 12, 12, 12 ), 'rem' );
		$shopire_print_style   .= shopire_customizer_value( 'shopire_breadcrumb_height_option', '.wf_pagetitle', array( 'padding-bottom' ), array( 12, 12, 12 ), 'rem' );
		 $shopire_print_style   .=  shopire_customizer_value( 'shopire_breadcrumb_title_size', '.wf_pagetitle .wf_pagetitle_content .title > *', array( 'font-size' ), array( 6, 6, 6 ), 'rem' );
		  $shopire_print_style   .=  shopire_customizer_value( 'shopire_breadcrumb_content_size', '.wf_pagetitle .wf_pagetitle_content .wf_pagetitle_breadcrumb li', array( 'font-size' ), array( 2, 2, 2 ), 'rem' );
		
		
		$shopire_breadcrumb_bg_img 			= get_theme_mod('shopire_breadcrumb_bg_img');
		$shopire_breadcrumb_img_opacity 	= get_theme_mod('shopire_breadcrumb_img_opacity','0.5');
		$shopire_breadcrumb_opacity_color 	= get_theme_mod('shopire_breadcrumb_opacity_color','#000');
		if(!empty($shopire_breadcrumb_bg_img)):
			$shopire_print_style .=".wf_pagetitle{
				    background-image: url(" .esc_url($shopire_breadcrumb_bg_img). ");
			}.wf_pagetitle:before {
				content: '';
				position: absolute;
				left: 0;
				top: 0;
				right: 0;
				bottom: 0;
				opacity: " .esc_attr($shopire_breadcrumb_img_opacity). ";
				background: " .esc_attr($shopire_breadcrumb_opacity_color). ";
			}.wf_pagetitle .wf_pagetitle_content .title > *,
			.wf_pagetitle .wf_pagetitle_content .wf_pagetitle_breadcrumb li,
			.wf_pagetitle .wf_pagetitle_content .wf_pagetitle_breadcrumb li a:hover,
			.wf_pagetitle .wf_pagetitle_content .wf_pagetitle_breadcrumb li a:focus,
			.wf_pagetitle .wf_pagetitle_content .wf_pagetitle_breadcrumb li a{
				color:#fff;
			}\n";
		endif;		
		
	
		 /*=========================================
		 Shopire Logo Size
		=========================================*/
		$shopire_print_style   .= shopire_customizer_value( 'hdr_logo_size', '.site--logo img', array( 'max-width' ), array( 150, 150, 150 ), 'px !important' );
		$shopire_print_style   .= shopire_customizer_value( 'hdr_site_title_size', '.site--logo .site-title', array( 'font-size' ), array( 30, 30, 30 ), 'px !important' );
		$shopire_print_style   .= shopire_customizer_value( 'hdr_site_desc_size', '.site--logo .site-description', array( 'font-size' ), array( 16, 16, 16 ), 'px !important' );
		
		

				
		$shopire_site_container_width 			 = get_theme_mod('shopire_site_container_width','1440');
			if($shopire_site_container_width >=768 && $shopire_site_container_width <=3000){
				$shopire_print_style .=".wf-container,.wf_slider .wf_owl_carousel.owl-carousel .owl-nav,.wf_slider .wf_owl_carousel.owl-carousel .owl-dots {
						max-width: " .esc_attr($shopire_site_container_width). "px;
					}.header--eight .wf-container {
						max-width: calc(" .esc_attr($shopire_site_container_width). "px + 7.15rem);
					}\n";
			}
					
		/**
		 *  Sidebar Width
		 */
		$shopire_sidebar_width = get_theme_mod('shopire_sidebar_width',33);
		if($shopire_sidebar_width !== '') { 
			$shopire_primary_width   = absint( 100 - $shopire_sidebar_width );
				$shopire_print_style .="	@media (min-width: 992px) {#wf-main {
					max-width:" .esc_attr($shopire_primary_width). "%;
					flex-basis:" .esc_attr($shopire_primary_width). "%;
				}\n";
				$shopire_print_style .="#wf-sidebar {
					max-width:" .esc_attr($shopire_sidebar_width). "%;
					flex-basis:" .esc_attr($shopire_sidebar_width). "%;
				}}\n";
        }
		$shopire_print_style   .= shopire_customizer_value( 'shopire_widget_ttl_size', '.wf_widget-area .widget .widget-title', array( 'font-size' ), array( 20, 20, 20 ), 'px' );
		
		/**
		 *  Typography Body
		 */
		 $shopire_body_font_weight_option	 	 = get_theme_mod('shopire_body_font_weight_option','inherit');
		 $shopire_body_text_transform_option	 = get_theme_mod('shopire_body_text_transform_option','inherit');
		 $shopire_body_font_style_option	 	 = get_theme_mod('shopire_body_font_style_option','inherit');
		 $shopire_body_txt_decoration_option	 = get_theme_mod('shopire_body_txt_decoration_option','none');
		
		 $shopire_print_style   .= shopire_customizer_value( 'shopire_body_font_size_option', 'body', array( 'font-size' ), array( 16, 16, 16 ), 'px' );
		 $shopire_print_style   .= shopire_customizer_value( 'shopire_body_line_height_option', 'body', array( 'line-height' ), array( 1.6, 1.6, 1.6 ) );
		 $shopire_print_style   .= shopire_customizer_value( 'shopire_body_ltr_space_option', 'body', array( 'letter-spacing' ), array( 0, 0, 0 ), 'px' );
		 $shopire_print_style .=" body{ 
			font-weight: " .esc_attr($shopire_body_font_weight_option). ";
			text-transform: " .esc_attr($shopire_body_text_transform_option). ";
			font-style: " .esc_attr($shopire_body_font_style_option). ";
			text-decoration: " .esc_attr($shopire_body_txt_decoration_option). ";
		}\n";		 
		
		/**
		 *  Typography Heading
		 */
		 for ( $i = 1; $i <= 6; $i++ ) {
			 $shopire_heading_font_weight_option	 	= get_theme_mod('shopire_h' . $i . '_font_weight_option','700');
			 $shopire_heading_text_transform_option 	= get_theme_mod('shopire_h' . $i . '_text_transform_option','inherit');
			 $shopire_heading_font_style_option	 	= get_theme_mod('shopire_h' . $i . '_font_style_option','inherit');
			 $shopire_heading_txt_decoration_option	= get_theme_mod('shopire_h' . $i . '_txt_decoration_option','inherit');
			 
			 $shopire_print_style   .= shopire_customizer_value( 'shopire_h' . $i . '_font_size_option', 'h' . $i .'', array( 'font-size' ), array( 36, 36, 36 ), 'px' );
			 $shopire_print_style   .= shopire_customizer_value( 'shopire_h' . $i . '_line_height_option', 'h' . $i . '', array( 'line-height' ), array( 1.2, 1.2, 1.2 ) );
			 $shopire_print_style   .= shopire_customizer_value( 'shopire_h' . $i . '_ltr_space_option', 'h' . $i . '', array( 'letter-spacing' ), array( 0, 0, 0 ), 'px' );
			 $shopire_print_style .=" h" . $i . "{ 
				font-weight: " .esc_attr($shopire_heading_font_weight_option). ";
				text-transform: " .esc_attr($shopire_heading_text_transform_option). ";
				font-style: " .esc_attr($shopire_heading_font_style_option). ";
				text-decoration: " .esc_attr($shopire_heading_txt_decoration_option). ";
			}\n";
		 }
		
		
		/*=========================================
		Footer 
		=========================================*/
		$shopire_footer_bg_color			= get_theme_mod('shopire_footer_bg_color','#efefef');
		if(!empty($shopire_footer_bg_color)):
			 $shopire_print_style .=".wf_footer--one{ 
				    background-color: ".esc_attr($shopire_footer_bg_color).";
			}\n";
		endif;
        wp_add_inline_style( 'shopire-style', $shopire_print_style );
    }
endif;
add_action( 'wp_enqueue_scripts', 'shopire_user_custom_style' );


/**
 * Define Constants
 */
 
$shopire_theme = wp_get_theme();
define( 'SHOPIRE_THEME_VERSION', $shopire_theme->get( 'Version' ) );

// Root path/URI.
define( 'SHOPIRE_THEME_DIR', get_template_directory() );
define( 'SHOPIRE_THEME_URI', get_template_directory_uri() );

// Root path/URI.
define( 'SHOPIRE_THEME_INC_DIR', SHOPIRE_THEME_DIR . '/inc');
define( 'SHOPIRE_THEME_INC_URI', SHOPIRE_THEME_URI . '/inc');


/**
 * Implement the Custom Header feature.
 */
require_once get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer/shopire-customizer.php';
require get_template_directory() . '/inc/customizer/controls/code/customizer-repeater/inc/customizer.php';
/**
 * Nav Walker for Bootstrap Dropdown Menu.
 */
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Control Style
 */

require SHOPIRE_THEME_INC_DIR . '/customizer/controls/code/control-function/style-functions.php';

/**
 * Getting Started
 */
require SHOPIRE_THEME_INC_DIR . '/admin/getting-started.php';