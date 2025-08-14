<?php
function shopire_popular_product_customize_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Product  Section
	=========================================*/
	$wp_customize->add_section(
		'popular_product_options', array(
			'title' => esc_html__( 'Popular Product Section', 'fable-extra' ),
			'priority' => 4,
			'panel' => 'shopire_frontpage_options',
		)
	);
	
	/*=========================================
	Popular Product Setting
	=========================================*/
	$wp_customize->add_setting(
		'shopire_popular_product_options_setting'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_popular_product_options_setting',
		array(
			'type' => 'hidden',
			'label' => __('Popular Product Setting','fable-extra'),
			'section' => 'popular_product_options',
		)
	);
	
	// Hide/Show Setting
	$wp_customize->add_setting(
		'shopire_popular_product_options_hide_show'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_popular_product_options_hide_show',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Section','fable-extra'),
			'section' => 'popular_product_options',
		)
	);
	
	/*=========================================
	Header  Section
	=========================================*/
	$wp_customize->add_setting(
		'shopire_popular_product_header_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_popular_product_header_options',
		array(
			'type' => 'hidden',
			'label' => __('Header','fable-extra'),
			'section' => 'popular_product_options',
		)
	);
	
	//  Title // 
	$wp_customize->add_setting(
    	'shopire_popular_product_ttl',
    	array(
	        'default'			=> __('Popular Product','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_popular_product_ttl',
		array(
		    'label'   	=> __('Title','fable-extra'),
		    'section' 	=> 'popular_product_options',
			'type'		=> 'text',
		)  
	);
	
	/*=========================================
	Content
	=========================================*/
	$wp_customize->add_setting(
		'shopire_popular_product_content'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
		'shopire_popular_product_content',
		array(
			'type' => 'hidden',
			'label' => __('Content','fable-extra'),
			'section' => 'popular_product_options',
		)
	);
	
	
	// Hide / Show Tab
	$wp_customize->add_setting(
		'shopire_popular_product_hs_tab'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
		'shopire_popular_product_hs_tab',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show Tab','fable-extra'),
			'section' => 'popular_product_options',
		)
	);
	
	// Product Category
	if ( class_exists( 'Shopire_Product_Category_Control' )  && class_exists( 'WooCommerce' )) {
		$wp_customize->add_setting(
		'shopire_popular_product_cat',
			array(
			'capability' => 'edit_theme_options',
			'default' => 1,
			'priority' => 5,
			)
		);	
		$wp_customize->add_control( new Shopire_Product_Category_Control( $wp_customize, 
		'shopire_popular_product_cat', 
			array(
			'label'   => __('Select category','fable-extra'),
			'section' => 'popular_product_options',
			) 
		) );
	}
	
	// No. of Products Display
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_popular_product_num',
			array(
				'default' => '20',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'priority' => 6,
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_popular_product_num', 
			array(
				'label'      => __( 'No of Products Display', 'fable-extra' ),
				'section'  => 'popular_product_options',
				 'media_query'   => false,
					'input_attr'    => array(
						'desktop' => array(
							'min'    => 1,
							'max'    => 500,
							'step'   => 1,
							'default_value' => 20,
						),
					),
			) ) 
		);
	}
			
	
	/*=========================================
	Banner After Before
	=========================================*/
	$wp_customize->add_setting(
		'popular_product_option_before_after'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 12,
		)
	);

	$wp_customize->add_control(
	'popular_product_option_before_after',
		array(
			'type' => 'hidden',
			'label' => __('Before / After Content','fable-extra'),
			'section' => 'popular_product_options',
		)
	);
	
	// Before
	$wp_customize->add_setting(
	'shopire_popular_product_option_before',
		array(
			'default' => '0',
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'shopire_sanitize_integer',
			'priority' => 13,
		)
	);
		
	$wp_customize->add_control(
	'shopire_popular_product_option_before',
		array(
			'type'	=> 'dropdown-pages',
			'allow_addition' => true,
			'label'	=> __('Select Page For Before Section','fable-extra'),
			'section'	=> 'popular_product_options',
		)
	);	
	
	// After
	$wp_customize->add_setting(
	'shopire_popular_product_option_after',
		array(
			'default' => '0',
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'shopire_sanitize_integer',
			'priority' => 14,
		)
	);
		
	$wp_customize->add_control(
	'shopire_popular_product_option_after',
		array(
			'type'	=> 'dropdown-pages',
			'allow_addition' => true,
			'label'	=> __('Select Page For After Section','fable-extra'),
			'section'	=> 'popular_product_options',
		)
	);
	
}
add_action( 'customize_register', 'shopire_popular_product_customize_setting' );