<?php
function shopire_header_customize_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Header Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'header_options', 
		array(
			'priority'      => 2,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Header Options', 'shopire'),
		) 
	);
	
	/*=========================================
	Shopire Site Identity
	=========================================*/
	$wp_customize->add_section(
        'title_tagline',
        array(
        	'priority'      => 1,
            'title' 		=> __('Site Identity','shopire'),
			'panel'  		=> 'header_options',
		)
    );
	
	// Logo Width // 
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'hdr_logo_size',
			array(
				'default'			=> '150',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'hdr_logo_size', 
			array(
				'label'      => __( 'Logo Size', 'shopire' ),
				'section'  => 'title_tagline',
				 'media_query'   => true,
					'input_attr'    => array(
						'mobile'  => array(
							'min'           => 0,
							'max'           => 500,
							'step'          => 1,
							'default_value' => 150,
						),
						'tablet'  => array(
							'min'           => 0,
							'max'           => 500,
							'step'          => 1,
							'default_value' => 150,
						),
						'desktop' => array(
							'min'           => 0,
							'max'           => 500,
							'step'          => 1,
							'default_value' => 150,
						),
					),
			) ) 
		);
	}
	
	
	// Site Title Size // 
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'hdr_site_title_size',
			array(
				'default'			=> '30',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'hdr_site_title_size', 
			array(
				'label'      => __( 'Site Title Size', 'shopire' ),
				'section'  => 'title_tagline',
				 'media_query'   => true,
					'input_attr'    => array(
						'mobile'  => array(
							'min'           => 0,
							'max'           => 100,
							'step'          => 1,
							'default_value' => 30,
						),
						'tablet'  => array(
							'min'           => 0,
							'max'           => 100,
							'step'          => 1,
							'default_value' => 30,
						),
						'desktop' => array(
							'min'           => 0,
							'max'           => 100,
							'step'          => 1,
							'default_value' => 30,
						),
					),
			) ) 
		);
	}
	
	// Site Tagline Size // 
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'hdr_site_desc_size',
			array(
				'default'			=> '16',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'hdr_site_desc_size', 
			array(
				'label'      => __( 'Site Tagline Size', 'shopire' ),
				'section'  => 'title_tagline',
				 'media_query'   => true,
					'input_attr'    => array(
						'mobile'  => array(
							'min'           => 0,
							'max'           => 50,
							'step'          => 1,
							'default_value' => 16,
						),
						'tablet'  => array(
							'min'           => 0,
							'max'           => 50,
							'step'          => 1,
							'default_value' => 16,
						),
						'desktop' => array(
							'min'           => 0,
							'max'           => 50,
							'step'          => 1,
							'default_value' => 16,
						),
					),
			) ) 
		);
	}
	
	
	// Hide / Show
	$wp_customize->add_setting( 
		'shopire_title_tagline_seo' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_title_tagline_seo', 
		array(
			'label'	      => esc_html__( 'Enable Hidden Title (h1 missing SEO issue)', 'shopire' ),
			'section'     => 'title_tagline',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Top Header
	=========================================*/
	$wp_customize->add_section(
        'shopire_top_header',
        array(
        	'priority'      => 2,
            'title' 		=> __('Top Header','shopire'),
			'panel'  		=> 'header_options',
		)
    );	
	
	/*=========================================
	Global Setting
	=========================================*/
	$wp_customize->add_setting(
		'shopire_hdr_top'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_top',
		array(
			'type' => 'hidden',
			'label' => __('Global Setting','shopire'),
			'section' => 'shopire_top_header',
		)
	);
	
	// Hide / Show
	$wp_customize->add_setting( 
		'shopire_hs_hdr' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_top_header',
			'type'        => 'checkbox'
		) 
	);		
	
	/*=========================================
	Contact
	=========================================*/
	$wp_customize->add_setting(
		'shopire_hdr_top_contact'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 11,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_top_contact',
		array(
			'type' => 'hidden',
			'label' => __('Contact','shopire'),
			'section' => 'shopire_top_header',
			
		)
	);
	$wp_customize->add_setting( 
		'shopire_hs_hdr_top_contact', 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 11,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_top_contact', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_top_header',
			'type'        => 'checkbox'
		) 
	);	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_hdr_top_contact_icon',
    	array(
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_hdr_top_contact_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_top_header',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_hdr_top_contact_title',
    	array(
	        'default'			=> __('🔥  Free shipping on all U.S. orders $50+','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'transport'         => $selective_refresh,
			'capability' => 'edit_theme_options',
			'priority' => 11,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_top_contact_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_top_header',
			'type'		 =>	'text'
		)  
	);
	
	// Link // 
	$wp_customize->add_setting(
    	'shopire_hdr_top_contact_link',
    	array(
			'sanitize_callback' => 'shopire_sanitize_url',
			'capability' => 'edit_theme_options',
			'priority' => 11,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_top_contact_link',
		array(
		    'label'   		=> __('Link','shopire'),
		    'section' 		=> 'shopire_top_header',
			'type'		 =>	'text'
		)  
	);
		
	/*=========================================
	Social
	=========================================*/
	$wp_customize->add_setting(
		'Shopire_hdr_social_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 24,
		)
	);

	$wp_customize->add_control(
	'Shopire_hdr_social_head',
		array(
			'type' => 'hidden',
			'label' => __('Social Icons','shopire'),
			'section' => 'shopire_top_header',
		)
	);
	
	
	$wp_customize->add_setting( 
		'shopire_hs_hdr_social' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 25,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_social', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_top_header',
			'type'        => 'checkbox'
		) 
	);
	
	/**
	 * Customizer Repeater
	 */
		$wp_customize->add_setting( 'shopire_hdr_social', 
			array(
			 'sanitize_callback' => 'shopire_repeater_sanitize',
			 'priority' => 26,
			 'default' => shopire_get_social_icon_default()
		)
		);
		
		$wp_customize->add_control( 
			new SHOPIRE_Repeater( $wp_customize, 
				'shopire_hdr_social', 
					array(
						'label'   => esc_html__('Social Icons','shopire'),
						'section' => 'shopire_top_header',
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_link_control' => true,
					) 
				) 
			);
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_social_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 26,
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_social_option_upsale', 
				array(
					'label'      => __( 'Icons', 'shopire' ),
					'section'    => 'shopire_top_header'
				) 
			) 
		);
	}
	
	/*=========================================
	Header Navigation
	=========================================*/	
	$wp_customize->add_section(
        'shopire_hdr_nav',
        array(
        	'priority'      => 4,
            'title' 		=> __('Navigation Bar','shopire'),
			'panel'  		=> 'header_options',
		)
    );
	
	/*=========================================
	Header Account
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_account'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_account',
		array(
			'type' => 'hidden',
			'label' => __('My Account','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	
	
	$wp_customize->add_setting( 
		'shopire_hs_hdr_account' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_account', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);	
	
	/*=========================================
	Header Docker
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_docker'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_docker',
		array(
			'type' => 'hidden',
			'label' => __('Side Docker','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	$wp_customize->add_setting( 
		'shopire_hs_side_docker' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_side_docker', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);		
	
	/*=========================================
	Header Cart
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_cart'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_cart',
		array(
			'type' => 'hidden',
			'label' => __('WooCommerce Cart','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	
	
	$wp_customize->add_setting( 
		'shopire_hs_hdr_cart' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_cart', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);	
	
	
	/*=========================================
	Header Compare
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_compare'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 2,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_compare',
		array(
			'type' => 'hidden',
			'label' => __('WooCommerce Compare','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	
	
	$wp_customize->add_setting( 
		'shopire_hs_hdr_compare' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_compare', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Header Wishlist
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_wishlist'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 2,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_wishlist',
		array(
			'type' => 'hidden',
			'label' => __('WooCommerce Wishlist','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	
	
	$wp_customize->add_setting( 
		'shopire_hs_hdr_wishlist' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_wishlist', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Header Search
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_search'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_search',
		array(
			'type' => 'hidden',
			'label' => __('Site Search','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	$wp_customize->add_setting( 
		'shopire_hs_hdr_search' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 4,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_search', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);	
	
	/*=========================================
	Header Button
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_button'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_button',
		array(
			'type' => 'hidden',
			'label' => __('Button','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);	

	$wp_customize->add_setting(
		'shopire_hs_hdr_btn' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 8,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_btn', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_hdr_btn_icon',
    	array(
	        'default' => 'fas fa-bolt',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_hdr_btn_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'iconset' => 'fa',
			
		))  
	);
	
	// Button Label // 
	$wp_customize->add_setting(
    	'shopire_hdr_btn_lbl',
    	array(
	        'default'			=> __('Flash Sale','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
			'priority' => 9,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_btn_lbl',
		array(
		    'label'   		=> __('Button Label','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'type'		 =>	'text'
		)  
	);
	
	// Button Link // 
	$wp_customize->add_setting(
    	'shopire_hdr_btn_link',
    	array(
			'default'			=> '#',
			'sanitize_callback' => 'shopire_sanitize_url',
			'capability' => 'edit_theme_options',
			'priority' => 10,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_btn_link',
		array(
		    'label'   		=> __('Button Link','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'type'		 =>	'text'
		)  
	);
	
	
	// Open New Tab
	$wp_customize->add_setting( 
		'shopire_hdr_btn_target' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 11,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hdr_btn_target', 
		array(
			'label'	      => esc_html__( 'Open in New Tab ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);	
	
	/*=========================================
	Header Browse Category
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_bcat'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 11,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_bcat',
		array(
			'type' => 'hidden',
			'label' => __('Browse Category','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	

	$wp_customize->add_setting( 
		'shopire_hs_hdr_bcat' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 11,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_bcat', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_hdr_bcat_icon',
    	array(
	        'default' => 'fas fa-list-ul',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_hdr_bcat_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			
		))  
	);
	
	// Title // 
	$wp_customize->add_setting(
    	'shopire_hdr_bcat_ttl',
    	array(
	        'default'			=> __('Browse Categories','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 12,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_bcat_ttl',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'type'		 =>	'text'
		)  
	);
	
	/*=========================================
	Header Contact
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_contact'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 12,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_contact',
		array(
			'type' => 'hidden',
			'label' => __('Contact','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	

	$wp_customize->add_setting( 
		'shopire_hs_hdr_contact' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 13,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_contact', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_hdr_nav',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_hdr_contact_icon',
    	array(
	        'default' => 'fal fa-phone-volume',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_hdr_contact_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'iconset' => 'fa',
			
		))  
	);
	
	// Title // 
	$wp_customize->add_setting(
    	'shopire_hdr_contact_ttl',
    	array(
	        'default'			=> __('Call Anytime','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
			'priority' => 9,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_contact_ttl',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'type'		 =>	'text'
		)  
	);
	
	// Text // 
	$wp_customize->add_setting(
    	'shopire_hdr_contact_txt',
    	array(
			'default'			=> '<a href="tel:+8898006802">+ 88 ( 9800 ) 6802</a>',
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
			'priority' => 10,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_contact_txt',
		array(
		    'label'   		=> __('Text','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'type'		 =>	'text'
		)  
	);
	
	/*=========================================
	Header Mobile
	=========================================*/	
	$wp_customize->add_setting(
		'shopire_hdr_mobile_nav'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 12,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_mobile_nav',
		array(
			'type' => 'hidden',
			'label' => __('Mobile Navigation','shopire'),
			'section' => 'shopire_hdr_nav',
		)
	);
	
	// Menu Title // 
	$wp_customize->add_setting(
    	'shopire_hdr_mobile_nav_ttl',
    	array(
	        'default'			=> __('Main Menu','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 12,
		)
	);	

	$wp_customize->add_control( 
		'shopire_hdr_mobile_nav_ttl',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_hdr_nav',
			'type'		 =>	'text'
		)  
	);
	
	/*=========================================
	Sticky Header
	=========================================*/	
	$wp_customize->add_section(
        'shopire_sticky_header_set',
        array(
        	'priority'      => 4,
            'title' 		=> __('Header Sticky','shopire'),
			'panel'  		=> 'header_options',
		)
    );
	
	// Heading
	$wp_customize->add_setting(
		'shopire_hdr_sticky'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'shopire_hdr_sticky',
		array(
			'type' => 'hidden',
			'label' => __('Sticky Header','shopire'),
			'section' => 'shopire_sticky_header_set',
		)
	);
	$wp_customize->add_setting( 
		'shopire_hs_hdr_sticky' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_hdr_sticky', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_sticky_header_set',
			'type'        => 'checkbox'
		) 
	);	
}
add_action( 'customize_register', 'shopire_header_customize_settings' );