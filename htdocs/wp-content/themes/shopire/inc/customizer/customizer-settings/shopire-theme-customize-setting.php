<?php
function shopire_theme_options_customize( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'shopire_theme_options', array(
			'priority' => 31,
			'title' => esc_html__( 'Theme Options', 'shopire' ),
		)
	);
	
	/*=========================================
	General Options
	=========================================*/
	$wp_customize->add_section(
		'site_general_options', array(
			'title' => esc_html__( 'General Options', 'shopire' ),
			'priority' => 1,
			'panel' => 'shopire_theme_options',
		)
	);
	
	
	/*=========================================
	Preloader
	=========================================*/
	// Heading
	$wp_customize->add_setting(
		'shopire_preloader_option'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_preloader_option',
		array(
			'type' => 'hidden',
			'label' => __('Site Preloader','shopire'),
			'section' => 'site_general_options',
		)
	);
	
	
	// Hide/ Show
	$wp_customize->add_setting( 
		'shopire_hs_preloader_option' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_preloader_option', 
		array(
			'label'	      => esc_html__( 'Hide / Show Preloader', 'shopire' ),
			'section'     => 'site_general_options',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Scroller
	=========================================*/
	// Heading
	$wp_customize->add_setting(
		'shopire_scroller_option'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'shopire_scroller_option',
		array(
			'type' => 'hidden',
			'label' => __('Top Scroller','shopire'),
			'section' => 'site_general_options',
		)
	);
	
	// Hide/show
	$wp_customize->add_setting( 
		'shopire_hs_scroller_option' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 4,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_scroller_option', 
		array(
			'label'	      => esc_html__( 'Hide / Show Scroller', 'shopire' ),
			'section'     => 'site_general_options',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Shopire Container
	=========================================*/
	// Heading
	$wp_customize->add_setting(
		'shopire_site_container_option'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 6,
		)
	);

	$wp_customize->add_control(
	'shopire_site_container_option',
		array(
			'type' => 'hidden',
			'label' => __('Site Container','shopire'),
			'section' => 'site_general_options',
		)
	);
	
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		//container width
		$wp_customize->add_setting(
			'shopire_site_container_width',
			array(
				'default'			=> '1440',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
				'priority'      => 6,
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_site_container_width', 
			array(
				'label'      => __( 'Container Width', 'shopire' ),
				'section'  => 'site_general_options',
				 'media_query'   => false,
                'input_attr'    => array(
                    'desktop' => array(
                        'min'           => 768,
                        'max'           => 3000,
                        'step'          => 1,
                        'default_value' => 1440,
                    ),
                ),
			) ) 
		);
	}
	
	/*=========================================
	Breadcrumb  Section
	=========================================*/
	$wp_customize->add_section(
		'shopire_site_breadcrumb', array(
			'title' => esc_html__( 'Site Breadcrumb', 'shopire' ),
			'priority' => 12,
			'panel' => 'shopire_theme_options',
		)
	);
	
	// Heading
	$wp_customize->add_setting(
		'shopire_site_breadcrumb_option'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_site_breadcrumb_option',
		array(
			'type' => 'hidden',
			'label' => __('Settings','shopire'),
			'section' => 'shopire_site_breadcrumb',
		)
	);
	
	// Breadcrumb Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'shopire_hs_site_breadcrumb' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_site_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'shopire' ),
			'section'     => 'shopire_site_breadcrumb',
			'type'        => 'checkbox'
		) 
	);
	
	// Breadcrumb Content Section // 
	$wp_customize->add_setting(
		'shopire_site_breadcrumb_content'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'shopire_site_breadcrumb_content',
		array(
			'type' => 'hidden',
			'label' => __('Content','shopire'),
			'section' => 'shopire_site_breadcrumb',
		)
	);
	
	
	// Type
	$wp_customize->add_setting( 
		'shopire_breadcrumb_type' , 
			array(
			'default' => 'theme',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 5,
		) 
	);

	$wp_customize->add_control(
	'shopire_breadcrumb_type' , 
		array(
			'label'          => __( 'Select Breadcrumb Type', 'shopire' ),
			'description'          => __( 'You need to install and activate the respected plugin to show their Breadcrumb. Otherwise, your default theme Breadcrumb will appear. If you see error in search console, then we recommend to use plugin Breadcrumb.', 'shopire' ),
			'section'        => 'shopire_site_breadcrumb',
			'type'           => 'select',
			'choices'        => 
			array(
				'theme' 	=> __( 'Theme Default', 'shopire' ),
				'yoast' 	=> __( 'Yoast Plugin', 'shopire' ),
				'rankmath' 	=> __( 'Rank Math Plugin', 'shopire' ),
				'navxt' 	=> __( 'NavXT Plugin', 'shopire' ),
			) 
		) 
	);
	
	// Height // 
	$wp_customize->add_setting(
    	'shopire_breadcrumb_height_option',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_range_value',
			'transport'         => 'postMessage',
			'priority' => 8,
		)
	);
	$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_breadcrumb_height_option', 
			array(
				'label'      => __( 'Top/Bottom Padding', 'shopire'),
				'section'  => 'shopire_site_breadcrumb',
				'media_query'   => true,
				'input_attr'    => array(
					'mobile'  => array(
						'min'           => 0,
						'max'           => 20,
						'step'          => 0.1,
						'default_value' => 4.5,
					),
					'tablet'  => array(
						'min'           => 0,
						'max'           => 20,
						'step'          => 0.1,
						'default_value' => 4.5,
					),
					'desktop' => array(
						'min'           => 0,
						'max'           => 20,
						'step'          => 0.1,
						'default_value' => 4.5,
					),
				),
			) ) 
		);
		
	// Background // 
	$wp_customize->add_setting(
		'shopire_breadcrumb_bg_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 9,
		)
	);

	$wp_customize->add_control(
	'shopire_breadcrumb_bg_options',
		array(
			'type' => 'hidden',
			'label' => __('Background','shopire'),
			'section' => 'shopire_site_breadcrumb',
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'shopire_breadcrumb_bg_img' , 
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'shopire_breadcrumb_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'shopire'),
			'section'        => 'shopire_site_breadcrumb',
		) 
	));
	
	// Opacity // 
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
	$wp_customize->add_setting(
    	'shopire_breadcrumb_img_opacity',
    	array(
	        'default'			=> '0.5',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_range_value',
			'priority'  => 11,
		)
	);
	$wp_customize->add_control( 
	new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_breadcrumb_img_opacity', 
		array(
			'label'      => __( 'Opacity', 'shopire'),
			'section'  => 'shopire_site_breadcrumb',
			 'media_query'   => false,
                'input_attr'    => array(
                    'desktop' => array(
                        'min'           => 0,
                        'max'           => 1,
                        'step'          => 0.1,
                        'default_value' => 0.5,
                    ),
                ),
		) ) 
	);
	}
	
	$wp_customize->add_setting(
	'shopire_breadcrumb_opacity_color', 
	array(
		'default' => '#000',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'priority'  => 12,
    ));
	
	$wp_customize->add_control( 
		new WP_Customize_Color_Control
		($wp_customize, 
			'shopire_breadcrumb_opacity_color', 
			array(
				'label'      => __( 'Opacity Color', 'shopire'),
				'section'    => 'shopire_site_breadcrumb',
			) 
		) 
	);
	
	// Typography
	$wp_customize->add_setting(
		'shopire_breadcrumb_typography'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority'  => 13,
		)
	);

	$wp_customize->add_control(
	'shopire_breadcrumb_typography',
		array(
			'type' => 'hidden',
			'label' => __('Typography','shopire'),
			'section' => 'shopire_site_breadcrumb',
		)
	);
	
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
	// Title size // 
	$wp_customize->add_setting(
    	'shopire_breadcrumb_title_size',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_range_value',
			'transport'         => 'postMessage',
			'priority'  => 14,
		)
	);
	$wp_customize->add_control( 
	new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_breadcrumb_title_size', 
		array(
			'label'      => __( 'Title Font Size', 'shopire' ),
			'section'  => 'shopire_site_breadcrumb',
			'media_query'   => true,
			'input_attr'    => array(
				'mobile'  => array(
					'min'           => 0,
					'max'           => 10,
					'step'          => 0.1,
					'default_value' => 4.5,
				),
				'tablet'  => array(
					'min'           => 0,
					'max'           => 10,
					'step'          => 0.1,
					'default_value' => 4.5,
				),
				'desktop' => array(
					'min'           => 0,
					'max'           => 10,
					'step'          => 0.1,
					'default_value' => 4.5,
				),
			),
		) ) 
	);
	// Content size // 
	$wp_customize->add_setting(
    	'shopire_breadcrumb_content_size',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_range_value',
			'transport'         => 'postMessage',
			'priority'  => 15,
		)
	);
	$wp_customize->add_control( 
	new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_breadcrumb_content_size', 
		array(
			'label'      => __( 'Content Font Size', 'shopire' ),
			'section'  => 'shopire_site_breadcrumb',
			'media_query'   => true,
			'input_attr'    => array(
				'mobile'  => array(
					'min'           => 0,
					'max'           => 10,
					'step'          => 1,
					'default_value' => 2,
				),
				'tablet'  => array(
					'min'           => 0,
					'max'           => 10,
					'step'          => 1,
					'default_value' => 2,
				),
				'desktop' => array(
					'min'           => 0,
					'max'           => 10,
					'step'          => 1,
					'default_value' => 2,
				),
			),
		) ) 
	);
	}
	
	/*=========================================
	Shopire Blog 
	=========================================*/
	$wp_customize->add_section(
        'site_blog_options',
        array(
        	'priority'      => 8,
            'title' 		=> __('Blog Options','shopire'),
			'panel'  		=> 'shopire_theme_options',
		)
    );
	
	/*=========================================
	Excerpt
	=========================================*/
	$wp_customize->add_setting(
		'shopire_blog_excerpt_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'shopire_blog_excerpt_options',
		array(
			'type' => 'hidden',
			'label' => __('Post Excerpt','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	
	// Enable Excerpt
	$wp_customize->add_setting(
		'shopire_enable_post_excerpt'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 5,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_excerpt',
		array(
			'type' => 'checkbox',
			'label' => __('Enable Excerpt','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	
	// post Exerpt // 
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_post_excerpt_length',
			array(
				'default'     	=> '30',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'priority'      => 5,
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_post_excerpt_length', 
			array(
				'label'      => __( 'Excerpt Length', 'shopire' ),
				'section'  => 'site_blog_options',
				 'media_query'   => false,
                'input_attr'    => array(
                    'desktop' => array(
                       'min'           => 0,
                        'max'           => 1000,
                        'step'          => 1,
                        'default_value' => 30,
                    ),
				)	
			) ) 
		);
	}
	
	// excerpt more // 
	$wp_customize->add_setting(
    	'shopire_blog_excerpt_more',
    	array(
			'default'      => '...',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority'      => 5,
		)
	);	

	$wp_customize->add_control( 
		'shopire_blog_excerpt_more',
		array(
		    'label'   => esc_html__('Excerpt More','shopire'),
		    'section' => 'site_blog_options',
			'type' => 'text',
		)  
	);
	
	
	// Enable Excerpt
	$wp_customize->add_setting(
		'shopire_show_post_btn'
			,array(
			'default'      => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 5,
		)
	);

	$wp_customize->add_control(
	'shopire_show_post_btn',
		array(
			'type' => 'checkbox',
			'label' => __('Enable Read More Button','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Readmore button
	$wp_customize->add_setting(
		'shopire_read_btn_txt'
			,array(
			'default' => __('Read more','shopire'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
			'priority'      => 5,
		)
	);

	$wp_customize->add_control(
	'shopire_read_btn_txt',
		array(
			'type' => 'text',
			'label' => __('Read More Button Text','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	
	// Hide/Show Category
	$wp_customize->add_setting(
		'shopire_enable_post_cat'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_cat',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Category ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Date
	$wp_customize->add_setting(
		'shopire_enable_post_date'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_date',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Date ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Author
	$wp_customize->add_setting(
		'shopire_enable_post_author'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_author',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Author ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Comments
	$wp_customize->add_setting(
		'shopire_enable_post_comments'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_comments',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Comments ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Views
	$wp_customize->add_setting(
		'shopire_enable_post_views'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_views',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Views ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Reading Time
	$wp_customize->add_setting(
		'shopire_enable_post_rt'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_rt',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Reading Time ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Tag
	$wp_customize->add_setting(
		'shopire_enable_post_tag'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_tag',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Tag ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Title
	$wp_customize->add_setting(
		'shopire_enable_post_ttl'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_ttl',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Title ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	// Hide/Show Social
	$wp_customize->add_setting(
		'shopire_enable_post_social'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority'      => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_enable_post_social',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Social ?','shopire'),
			'section' => 'site_blog_options',
		)
	);
	
	
	
	/*=========================================
	Shopire Sidebar
	=========================================*/
	$wp_customize->add_section(
        'shopire_sidebar_options',
        array(
        	'priority'      => 8,
            'title' 		=> __('Sidebar Options','shopire'),
			'panel'  		=> 'shopire_theme_options',
		)
    );
	
	//  Pages Layout // 
	$wp_customize->add_setting(
		'shopire_pages_sidebar_option'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_pages_sidebar_option',
		array(
			'type' => 'hidden',
			'label' => __('Sidebar Layout','shopire'),
			'section' => 'shopire_sidebar_options',
		)
	);
	
	// Default Page
	$wp_customize->add_setting( 
		'shopire_default_pg_sidebar_option' , 
			array(
			'default' => 'right_sidebar',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 2,
		) 
	);

	$wp_customize->add_control(
	'shopire_default_pg_sidebar_option' , 
		array(
			'label'          => __( 'Default Page Sidebar Option', 'shopire' ),
			'section'        => 'shopire_sidebar_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'left_sidebar' 	=> __( 'Left Sidebar', 'shopire' ),
				'right_sidebar' 	=> __( 'Right Sidebar', 'shopire' ),
				'no_sidebar' 	=> __( 'No Sidebar', 'shopire' ),
			) 
		) 
	);
	
	// Archive Page
	$wp_customize->add_setting( 
		'shopire_archive_pg_sidebar_option' , 
			array(
			'default' => 'right_sidebar',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 3,
		) 
	);

	$wp_customize->add_control(
	'shopire_archive_pg_sidebar_option' , 
		array(
			'label'          => __( 'Archive Page Sidebar Option', 'shopire' ),
			'section'        => 'shopire_sidebar_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'left_sidebar' 	=> __( 'Left Sidebar', 'shopire' ),
				'right_sidebar' => __( 'Right Sidebar', 'shopire' ),
				'no_sidebar' 	=> __( 'No Sidebar', 'shopire' ),
			) 
		) 
	);
	
	
	// Single Page
	$wp_customize->add_setting( 
		'shopire_single_pg_sidebar_option' , 
			array(
			'default' => 'right_sidebar',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 4,
		) 
	);

	$wp_customize->add_control(
	'shopire_single_pg_sidebar_option' , 
		array(
			'label'          => __( 'Single Page Sidebar Option', 'shopire' ),
			'section'        => 'shopire_sidebar_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'left_sidebar' 	=> __( 'Left Sidebar', 'shopire' ),
				'right_sidebar' => __( 'Right Sidebar', 'shopire' ),
				'no_sidebar' 	=> __( 'No Sidebar', 'shopire' ),
			) 
		) 
	);
	
	
	// Blog Page
	$wp_customize->add_setting( 
		'shopire_blog_pg_sidebar_option' , 
			array(
			'default' => 'right_sidebar',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 5,
		) 
	);

	$wp_customize->add_control(
	'shopire_blog_pg_sidebar_option' , 
		array(
			'label'          => __( 'Blog Page Sidebar Option', 'shopire' ),
			'section'        => 'shopire_sidebar_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'left_sidebar' 	=> __( 'Left Sidebar', 'shopire' ),
				'right_sidebar' => __( 'Right Sidebar', 'shopire' ),
				'no_sidebar' 	=> __( 'No Sidebar', 'shopire' ),
			) 
		) 
	);
	
	// Search Page
	$wp_customize->add_setting( 
		'shopire_search_pg_sidebar_option' , 
			array(
			'default' => 'right_sidebar',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 5,
		) 
	);

	$wp_customize->add_control(
	'shopire_search_pg_sidebar_option' , 
		array(
			'label'          => __( 'Search Page Sidebar Option', 'shopire' ),
			'section'        => 'shopire_sidebar_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'left_sidebar' 	=> __( 'Left Sidebar', 'shopire' ),
				'right_sidebar' => __( 'Right Sidebar', 'shopire' ),
				'no_sidebar' 	=> __( 'No Sidebar', 'shopire' ),
			) 
		) 
	);
	
	
	// WooCommerce Page
	$wp_customize->add_setting( 
		'shopire_shop_pg_sidebar_option' , 
			array(
			'default' => 'right_sidebar',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 6,
		) 
	);

	$wp_customize->add_control(
	'shopire_shop_pg_sidebar_option' , 
		array(
			'label'          => __( 'WooCommerce Page Sidebar Option', 'shopire' ),
			'section'        => 'shopire_sidebar_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'left_sidebar' 	=> __( 'Left Sidebar', 'shopire' ),
				'right_sidebar' => __( 'Right Sidebar', 'shopire' ),
				'no_sidebar' 	=> __( 'No Sidebar', 'shopire' ),
			) 
		) 
	);
	
	// Company Page
	$wp_customize->add_setting( 
		'shopire_company_pg_sidebar_option' , 
			array(
			'default' => 'right_sidebar',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_select',
			'priority' => 6,
		) 
	);

	$wp_customize->add_control(
	'shopire_company_pg_sidebar_option' , 
		array(
			'label'          => __( 'Company Page Sidebar Option', 'shopire' ),
			'section'        => 'shopire_sidebar_options',
			'type'           => 'select',
			'choices'        => 
			array(
				'left_sidebar' 	=> __( 'Left Sidebar', 'shopire' ),
				'right_sidebar' => __( 'Right Sidebar', 'shopire' ),
				'no_sidebar' 	=> __( 'No Sidebar', 'shopire' ),
			) 
		) 
	);
	
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_sidebar_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 7,
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_sidebar_option_upsale', 
				array(
					'label'      => __( 'Sidebar Features', 'shopire' ),
					'section'    => 'shopire_sidebar_options'
				) 
			) 
		);	
	}
	
	// Widget options
	$wp_customize->add_setting(
		'sidebar_options'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority'  => 6
		)
	);

	$wp_customize->add_control(
	'sidebar_options',
		array(
			'type' => 'hidden',
			'label' => __('Options','shopire'),
			'section' => 'shopire_sidebar_options',
		)
	);
	// Sidebar Width 
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_sidebar_width',
			array(
				'default'	      => esc_html__( '33', 'shopire' ),
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
				'priority'  => 7
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_sidebar_width', 
			array(
				'label'      => __( 'Sidebar Width', 'shopire' ),
				'section'  => 'shopire_sidebar_options',
				 'media_query'   => false,
					'input_attr'    => array(
						'desktop' => array(
							'min'           => 25,
							'max'           => 50,
							'step'          => 1,
							'default_value' => 33,
						),
					),
			) ) 
		);
	}
	
	// Widget Typography
	$wp_customize->add_setting(
		'sidebar_typography'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'sidebar_typography',
		array(
			'type' => 'hidden',
			'label' => __('Typography','shopire'),
			'section' => 'shopire_sidebar_options',
			'priority'  => 21,
		)
	);
	
	// Widget Title // 
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_widget_ttl_size',
			array(
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage'
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_widget_ttl_size', 
			array(
				'label'      => __( 'Widget Title Font Size', 'shopire' ),
				'section'  => 'shopire_sidebar_options',
				'priority'  => 22,
				 'media_query'   => true,
                'input_attr'    => array(
                    'mobile'  => array(
                        'min'           => 5,
                        'max'           => 100,
                        'step'          => 1,
                        'default_value' => 35,
                    ),
                    'tablet'  => array(
                        'min'           => 5,
                        'max'           => 100,
                        'step'          => 1,
                        'default_value' => 35,
                    ),
                    'desktop' => array(
                        'min'           => 5,
                        'max'           => 100,
                        'step'          => 1,
                        'default_value' => 35,
                    ),
                ),
			) ) 
		);
	}	
}
add_action( 'customize_register', 'shopire_theme_options_customize' );
