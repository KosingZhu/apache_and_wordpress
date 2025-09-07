<?php
function shopire_blog_customize_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Blog  Section
	=========================================*/
	$wp_customize->add_section(
		'blog_options', array(
			'title' => esc_html__( 'Blog Section', 'fable-extra' ),
			'priority' => 7,
			'panel' => 'shopire_frontpage_options',
		)
	);
	
	/*=========================================
	Blog Setting
	=========================================*/
	$wp_customize->add_setting(
		'shopire_blog_options_setting'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_blog_options_setting',
		array(
			'type' => 'hidden',
			'label' => __('Blog Setting','fable-extra'),
			'section' => 'blog_options',
		)
	);
	
	// Hide/Show Setting
	$wp_customize->add_setting(
		'shopire_blog_options_hide_show'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_blog_options_hide_show',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Section','fable-extra'),
			'section' => 'blog_options',
		)
	);
	
	/*=========================================
	Header  Section
	=========================================*/
	$wp_customize->add_setting(
		'shopire_blog_header_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_blog_header_options',
		array(
			'type' => 'hidden',
			'label' => __('Header','fable-extra'),
			'section' => 'blog_options',
		)
	);
	
	
	
	//  Title // 
	$wp_customize->add_setting(
    	'shopire_blog_ttl',
    	array(
	        'default'			=> __('Blog & News','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_blog_ttl',
		array(
		    'label'   => __('Title','fable-extra'),
		    'section' => 'blog_options',
			'type'           => 'text',
		)  
	);
	
	
	
	//  Subtitle // 
	$wp_customize->add_setting(
    	'shopire_blog_subttl',
    	array(
	        'default'			=> __('Get Update Blog & News','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 3,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_blog_subttl',
		array(
		    'label'   => __('Subtitle','fable-extra'),
		    'section' => 'blog_options',
			'type'           => 'text',
		)  
	);
	
	
	//  Description // 
	$wp_customize->add_setting(
    	'shopire_blog_text',
    	array(
	        'default'			=> __('At worst the discussion is at least working towards the final goal of your site where questions about lorem ipsum don’t.','fable-extra'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 3,
		)
	);	
	
	$wp_customize->add_control( 
		'shopire_blog_text',
		array(
		    'label'   => __('Description','fable-extra'),
		    'section' => 'blog_options',
			'type'           => 'textarea',
		)  
	);
	
	
	/*=========================================
	Content  Section
	=========================================*/
	$wp_customize->add_setting(
		'shopire_blog_content_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_blog_content_options',
		array(
			'type' => 'hidden',
			'label' => __('Content','fable-extra'),
			'section' => 'blog_options',
		)
	);
	// Select Blog Category
	$wp_customize->add_setting(
    'shopire_blog_cat',
		array(
		'default'	      => '0',	
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'priority' => 4,
		)
	);	
	$wp_customize->add_control( new Shopire_Post_Category_Custom_Control( $wp_customize, 
	'shopire_blog_cat', 
		array(
		'label'   => __('Select category for Blog','fable-extra'),
		'section' => 'blog_options',
		) 
	) );
	
	// Column
	$wp_customize->add_setting( 
		'shopire_blog_column' , 
			array(
			'default' => '3',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 6,
		) 
	);

	$wp_customize->add_control(
	'shopire_blog_column' , 
		array(
			'label'          => __( 'Select Column', 'fable-extra' ),
			'section'        => 'blog_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'6' 	=> __( '2 Column', 'fable-extra' ),
				'4' 	=> __( '3 Column', 'fable-extra' ),
				'3' 	=> __( '4 Column', 'fable-extra' ),
			) 
		) 
	);
	
	
	// No. of Blog Display
	if ( class_exists( 'Corpiva_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_blog_num',
			array(
				'default' => '4',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'priority' => 8,
			)
		);
		$wp_customize->add_control( 
		new Corpiva_Customizer_Range_Control( $wp_customize, 'shopire_blog_num', 
			array(
				'label'      => __( 'Number of Blog Display', 'fable-extra' ),
				'section'  => 'blog_options',
				 'media_query'   => false,
					'input_attr'    => array(
						'desktop' => array(
							'min'    => 1,
							'max'    => 100,
							'step'   => 1,
							'default_value' => 4,
						),
					),
			) ) 
		);
	}
	
}
add_action( 'customize_register', 'shopire_blog_customize_setting' );