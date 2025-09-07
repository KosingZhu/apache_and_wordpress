<?php
function shopire_product_cat_customize_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Product Category  Section
	=========================================*/
	$wp_customize->add_section(
		'product_cat_options', array(
			'title' => esc_html__( 'Product Category Section', 'fable-extra' ),
			'priority' => 2,
			'panel' => 'shopire_frontpage_options',
		)
	);
	
	/*=========================================
	Product Category Setting
	=========================================*/
	$wp_customize->add_setting(
		'shopire_product_cat_options_setting'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_product_cat_options_setting',
		array(
			'type' => 'hidden',
			'label' => __('Product Category  Setting','fable-extra'),
			'section' => 'product_cat_options',
		)
	);
	
	// Hide/Show Setting
	$wp_customize->add_setting(
		'shopire_product_cat_options_hide_show'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_product_cat_options_hide_show',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Section','fable-extra'),
			'section' => 'product_cat_options',
		)
	);
	
	/*=========================================
	Header  Section
	=========================================*/
	$wp_customize->add_setting(
		'shopire_product_cat_header_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_product_cat_header_options',
		array(
			'type' => 'hidden',
			'label' => __('Header','fable-extra'),
			'section' => 'product_cat_options',
		)
	);
	
	
	
	//  Title // 
	$wp_customize->add_setting(
    	'shopire_product_cat_ttl',
    	array(
	        'default'			=> __('Popular Categories','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_product_cat_ttl',
		array(
		    'label'   => __('Title','fable-extra'),
		    'section' => 'product_cat_options',
			'type'           => 'text',
		)  
	);
	
	//  Button Label // 
	$wp_customize->add_setting(
    	'shopire_product_cat_btn_lbl',
    	array(
	        'default'			=> __('See All Deals','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_product_cat_btn_lbl',
		array(
		    'label'   => __('Button Label','fable-extra'),
		    'section' => 'product_cat_options',
			'type'           => 'text',
		)  
	);
	
	//  Button Link // 
	$wp_customize->add_setting(
    	'shopire_product_cat_btn_url',
    	array(
	        'default'			=> '#',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_url',
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_product_cat_btn_url',
		array(
		    'label'   => __('Button Link','fable-extra'),
		    'section' => 'product_cat_options',
			'type'           => 'text',
		)  
	);
	
	/*=========================================
	Content  Section
	=========================================*/
	$wp_customize->add_setting(
		'shopire_product_cat_content_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_product_cat_content_options',
		array(
			'type' => 'hidden',
			'label' => __('Content','fable-extra'),
			'section' => 'product_cat_options',
		)
	);
	// Select Product Category
	if ( class_exists( 'Shopire_Product_Category_Control' )  && class_exists( 'WooCommerce' )) {
		$wp_customize->add_setting(
		'shopire_product_cat',
			array(
			'capability' => 'edit_theme_options',
			'priority' => 4,
			)
		);	
		$wp_customize->add_control( new Shopire_Product_Category_Control( $wp_customize, 
		'shopire_product_cat', 
			array(
			'label'   => __('Select Product category','fable-extra'),
			'section' => 'product_cat_options',
			) 
		) );
	}
	
	// Column
	$wp_customize->add_setting( 
		'shopire_product_cat_column' , 
			array(
			'default' => '6',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 6,
		) 
	);

	$wp_customize->add_control(
	'shopire_product_cat_column' , 
		array(
			'label'          => __( 'Select Column', 'fable-extra' ),
			'section'        => 'product_cat_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'2' 	=> __( '2 Column', 'fable-extra' ),
				'3' 	=> __( '3 Column', 'fable-extra' ),
				'4' 	=> __( '4 Column', 'fable-extra' ),
				'5' 	=> __( '5 Column', 'fable-extra' ),
				'6' 	=> __( '6 Column', 'fable-extra' ),
			) 
		) 
	);
	
}
add_action( 'customize_register', 'shopire_product_cat_customize_setting' );