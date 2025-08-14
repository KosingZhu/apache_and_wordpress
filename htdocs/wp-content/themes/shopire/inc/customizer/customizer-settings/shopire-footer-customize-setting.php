<?php
function shopire_footer_customize_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Section Panel // 
	$wp_customize->add_panel( 
		'footer_options', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer Options', 'shopire'),
		) 
	);
	
	/*=========================================
	Footer Menu
	=========================================*/	
	$wp_customize->add_section(
        'shopire_footer_mm_options',
        array(
            'title' 		=> __('Footer Mobile Menu','shopire'),
			'panel'  		=> 'footer_options',
			'priority'      => 2,
		)
    );
	// Heading
	$wp_customize->add_setting(
		'shopire_footer_mm_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_head',
		array(
			'type' => 'hidden',
			'label' => __('Setting','shopire'),
			'section' => 'shopire_footer_mm_options',
			'priority' => 2,
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	
	// Home Head
	$wp_customize->add_setting(
		'shopire_footer_mm_home_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 2,
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_home_head',
		array(
			'type' => 'hidden',
			'label' => __('Home','shopire'),
			'section' => 'shopire_footer_mm_options',
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm_home' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 3,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm_home', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_home_icon',
    	array(
			'default'			=> 'far fa-home',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 3,
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_footer_mm_home_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_home_title',
    	array(
	        'default'			=> __('Home','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 4,
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_mm_home_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',
			'type'		 =>	'text'
		)  
	);
	
	
	// Shop Head
	$wp_customize->add_setting(
		'shopire_footer_mm_shop_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_shop_head',
		array(
			'type' => 'hidden',
			'label' => __('Shop','shopire'),
			'section' => 'shopire_footer_mm_options',
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm_shop' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 6,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm_shop', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_shop_icon',
    	array(
			'default'			=> 'far fa-grid-2',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 6,
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_footer_mm_shop_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_shop_title',
    	array(
	        'default'			=> __('Shop','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 7,
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_mm_shop_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',
			'type'		 =>	'text'
		)  
	);
	
	
	// Cart Head
	$wp_customize->add_setting(
		'shopire_footer_mm_cart_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_cart_head',
		array(
			'type' => 'hidden',
			'label' => __('Cart','shopire'),
			'section' => 'shopire_footer_mm_options',
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm_cart' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 7,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm_cart', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_cart_icon',
    	array(
			'default'			=> 'far fa-cart-shopping',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 7,
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_footer_mm_cart_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_cart_title',
    	array(
	        'default'			=> __('Cart','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 7,
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_mm_cart_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',
			'type'		 =>	'text'
		)  
	);
	
	
	
	// My Account Head
	$wp_customize->add_setting(
		'shopire_footer_mm_ma_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 8,
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_ma_head',
		array(
			'type' => 'hidden',
			'label' => __('My Account','shopire'),
			'section' => 'shopire_footer_mm_options',
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm_ma' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 9,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm_ma', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_ma_icon',
    	array(
			'default'			=> 'far fa-user',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 10,
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_footer_mm_ma_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_ma_title',
    	array(
	        'default'			=> __('My Account','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 11,
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_mm_ma_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',
			'type'		 =>	'text'
		)  
	);
	
	// Wishlist Head
	$wp_customize->add_setting(
		'shopire_footer_mm_wl_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 12,
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_wl_head',
		array(
			'type' => 'hidden',
			'label' => __('Wishlist','shopire'),
			'section' => 'shopire_footer_mm_options',
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm_wl' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 13,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm_wl', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_wl_icon',
    	array(
			'default'			=> 'far fa-heart',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 14,
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_footer_mm_wl_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_wl_title',
    	array(
	        'default'			=> __('Wishlist','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 15,
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_mm_wl_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',
			'type'		 =>	'text'
		)  
	);
	
	
	// Compare Head
	$wp_customize->add_setting(
		'shopire_footer_mm_cm_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_cm_head',
		array(
			'type' => 'hidden',
			'label' => __('Compare','shopire'),
			'section' => 'shopire_footer_mm_options',
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm_cm' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm_cm', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_cm_icon',
    	array(
			'default'			=> 'fas fa-exchange',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_footer_mm_cm_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_cm_title',
    	array(
	        'default'			=> __('Compare','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 19,
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_mm_cm_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',
			'type'		 =>	'text'
		)  
	);
	
	
	
	// Search Head
	$wp_customize->add_setting(
		'shopire_footer_mm_search_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 20,
		)
	);

	$wp_customize->add_control(
	'shopire_footer_mm_search_head',
		array(
			'type' => 'hidden',
			'label' => __('Search','shopire'),
			'section' => 'shopire_footer_mm_options',
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_mm_search' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 21,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_mm_search', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'shopire' ),
			'section'     => 'shopire_footer_mm_options',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_search_icon',
    	array(
			'default'			=> 'far fa-search',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 22,
		)
	);	

	$wp_customize->add_control(new Shopire_Icon_Picker_Control($wp_customize, 
		'shopire_footer_mm_search_icon',
		array(
		    'label'   		=> __('Icon','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',			
		))  
	);
	
	// title // 
	$wp_customize->add_setting(
    	'shopire_footer_mm_search_title',
    	array(
	        'default'			=> __('Search','shopire'),
			'sanitize_callback' => 'shopire_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 23,
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_mm_search_title',
		array(
		    'label'   		=> __('Title','shopire'),
		    'section' 		=> 'shopire_footer_mm_options',
			'type'		 =>	'text'
		)  
	);	
	/*=========================================
	Footer Copright
	=========================================*/
	$wp_customize->add_section(
        'shopire_footer_copyright',
        array(
            'title' 		=> __('Footer Copright','shopire'),
			'panel'  		=> 'footer_options',
			'priority'      => 4,
		)
    );
	
	// Heading
	$wp_customize->add_setting(
		'shopire_footer_copyright_first_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'shopire_footer_copyright_first_head',
		array(
			'type' => 'hidden',
			'label' => __('Copyright','shopire'),
			'section' => 'shopire_footer_copyright',
			'priority'  => 3,
		)
	);
	
	// footer third text // 
	$shopire_copyright = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'shopire' );
	$wp_customize->add_setting(
    	'shopire_footer_copyright_text',
    	array(
			'default' => $shopire_copyright,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_html',
		)
	);	

	$wp_customize->add_control( 
		'shopire_footer_copyright_text',
		array(
		    'label'   		=> __('Copyright','shopire'),
		    'section'		=> 'shopire_footer_copyright',
			'type' 			=> 'textarea',
			'priority'      => 4,
		)  
	);	

	/*=========================================
	Footer Background
	=========================================*/
	$wp_customize->add_section(
        'footer_background_options',
        array(
            'title' 		=> __('Footer Background','shopire'),
			'panel'  		=> 'footer_options',
			'priority'      => 4,
		)
    );
	
	
	//  Footer Background Color
	$wp_customize->add_setting(
	'shopire_footer_bg_color', 
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'default' => '#efefef'
    ));
	
	$wp_customize->add_control( 
		new WP_Customize_Color_Control
		($wp_customize, 
			'shopire_footer_bg_color', 
			array(
				'label'      => __( 'Footer Background Color', 'shopire' ),
				'section'    => 'footer_background_options',
			) 
		) 
	);
}
add_action( 'customize_register', 'shopire_footer_customize_settings' );