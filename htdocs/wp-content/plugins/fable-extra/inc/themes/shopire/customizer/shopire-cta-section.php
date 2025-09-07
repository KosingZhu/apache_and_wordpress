<?php
function shopire_cta_customize_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	CTA  Section
	=========================================*/
	$wp_customize->add_section(
		'cta_options', array(
			'title' => esc_html__( 'CTA Section', 'fable-extra' ),
			'priority' => 6,
			'panel' => 'shopire_frontpage_options',
		)
	);
	
	/*=========================================
	CTA Setting
	=========================================*/
	$wp_customize->add_setting(
		'shopire_cta_options_setting'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_cta_options_setting',
		array(
			'type' => 'hidden',
			'label' => __('CTA Setting','fable-extra'),
			'section' => 'cta_options',
		)
	);
	
	// Hide/Show Setting
	$wp_customize->add_setting(
		'shopire_cta_options_hide_show'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_cta_options_hide_show',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Section','fable-extra'),
			'section' => 'cta_options',
		)
	);
	
	/*=========================================
	Content  Section
	=========================================*/
	$wp_customize->add_setting(
		'shopire_cta_content_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_cta_content_options',
		array(
			'type' => 'hidden',
			'label' => __('CTA Content','fable-extra'),
			'section' => 'cta_options',
		)
	);
	
	
	//  Title // 
	$wp_customize->add_setting(
    	'shopire_cta_ttl',
    	array(
	        'default'			=> __('Hurry Up!','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_cta_ttl',
		array(
		    'label'   => __('Title','fable-extra'),
		    'section' => 'cta_options',
			'type'           => 'text',
		)  
	);
	
	//  Subtitle // 
	$wp_customize->add_setting(
    	'shopire_cta_subttl',
    	array(
	        'default'			=> __('Year Ending Sale Up To 70% Off!','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_cta_subttl',
		array(
		    'label'   => __('Subtitle','fable-extra'),
		    'section' => 'cta_options',
			'type'           => 'text',
		)  
	);

	//  Text // 
	$wp_customize->add_setting(
    	'shopire_cta_text',
    	array(
	        'default'			=> __('Explore our exclusive sale on cutting-edge electronics devices.','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_cta_text',
		array(
		    'label'   => __('Description','fable-extra'),
		    'section' => 'cta_options',
			'type'           => 'textarea',
		)  
	);
	
	// Button Label // 
	$wp_customize->add_setting(
    	'shopire_cta_btn_lbl',
    	array(
	        'default'			=> __('Shop Now','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_cta_btn_lbl',
		array(
		    'label'   => __('Button Label','fable-extra'),
		    'section' => 'cta_options',
			'type'           => 'text',
		)  
	);
	
	// Button Link // 
	$wp_customize->add_setting(
    	'shopire_cta_btn_link',
    	array(
	        'default'			=> '#',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_url',
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_cta_btn_link',
		array(
		    'label'   => __('Button Link','fable-extra'),
		    'section' => 'cta_options',
			'type'           => 'text',
		)  
	);
	
	// Image
	$wp_customize->add_setting( 
    	'shopire_cta_img' , 
    	array(
			'default' 			=> esc_url(WPFE_URL . 'inc/themes/shopire/assets/images/iphone.png'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_url',	
			'priority' => 5,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'shopire_cta_img' ,
		array(
			'label'          => __( 'Image', 'fable-extra' ),
			'section'        => 'cta_options',
		) 
	));
}
add_action( 'customize_register', 'shopire_cta_customize_setting' );