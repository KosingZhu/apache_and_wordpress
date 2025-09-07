<?php
function shopire_slider_customize_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Slider Section Panel
	=========================================*/
	$wp_customize->add_panel(
		'shopire_frontpage_options', array(
			'priority' => 32,
			'title' => esc_html__( 'Theme Frontpage', 'fable-extra' ),
		)
	);
	
	$wp_customize->add_section(
		'slider_options', array(
			'title' => esc_html__( 'Slider Section', 'fable-extra' ),
			'panel' => 'shopire_frontpage_options',
			'priority' => 1,
		)
	);
	
	/*=========================================
	Slider Setting
	=========================================*/
	$wp_customize->add_setting(
		'shopire_slider_options_setting'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_slider_options_setting',
		array(
			'type' => 'hidden',
			'label' => __('Slider Setting','fable-extra'),
			'section' => 'slider_options',
		)
	);
	
	// Hide/Show Setting
	$wp_customize->add_setting(
		'shopire_slider_options_hide_show'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_slider_options_hide_show',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Section','fable-extra'),
			'section' => 'slider_options',
		)
	);
	
	/*=========================================
	Slider Content
	=========================================*/
	$wp_customize->add_setting(
		'slider_options_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'slider_options_head',
		array(
			'type' => 'hidden',
			'label' => __('Slider Contents','fable-extra'),
			'section' => 'slider_options',
		)
	);
	
	// Slider 
	$fable_axtra_activated_theme = wp_get_theme(); // gets the current theme
	if( 'MiniCart' == $fable_axtra_activated_theme->name  ||  'EazyShop' == $fable_axtra_activated_theme->name  ||  'EasyBuy' == $fable_axtra_activated_theme->name){
		$wp_customize->add_setting( 'shopire_slider_option', 
			array(
			 'sanitize_callback' => 'shopire_repeater_sanitize',
			 'priority' => 5,
			  'default' => shopire_slider_options_default()
			)
		);
		
		$wp_customize->add_control( 
			new Shopire_Repeater( $wp_customize, 
				'shopire_slider_option', 
					array(
						'label'   => esc_html__('Slide','fable-extra'),
						'section' => 'slider_options',
						'add_field_label'                   => esc_html__( 'Add New Slider', 'fable-extra' ),
						'item_name'                         => esc_html__( 'Slider', 'fable-extra' ),
						
						'customizer_repeater_title_control' => true,
						'customizer_repeater_subtitle_control' => true,
						'customizer_repeater_text_control' => true,
						'customizer_repeater_text2_control'=> true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_slide_align' => true,
						'customizer_repeater_image_control' => true,
					) 
				) 
			);
	}else{ 
		$wp_customize->add_setting( 'shopire_slider_option', 
			array(
			 'sanitize_callback' => 'shopire_repeater_sanitize',
			 'priority' => 5,
			  'default' => shopire_slider_options_default()
			)
		);
		
		$wp_customize->add_control( 
			new Shopire_Repeater( $wp_customize, 
				'shopire_slider_option', 
					array(
						'label'   => esc_html__('Slide','fable-extra'),
						'section' => 'slider_options',
						'add_field_label'                   => esc_html__( 'Add New Slider', 'fable-extra' ),
						'item_name'                         => esc_html__( 'Slider', 'fable-extra' ),
						
						'customizer_repeater_title_control' => true,
						'customizer_repeater_subtitle_control' => true,
						'customizer_repeater_text_control' => true,
						'customizer_repeater_text2_control'=> true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_slide_align' => true,
						'customizer_repeater_image2_control' => true,
					) 
				) 
			);
	}
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_slider_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 5,
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_slider_option_upsale', 
				array(
					'label'      => __( 'Slides', 'fable-extra' ),
					'section'    => 'slider_options'
				) 
			) 
		);
	}
	
if( 'MiniCart' == $fable_axtra_activated_theme->name  ||  'EazyShop' == $fable_axtra_activated_theme->name  ||  'EasyBuy' == $fable_axtra_activated_theme->name){
		// Slider Data
		$wp_customize->add_setting( 'shopire_slider_data_option', 
			array(
			 'sanitize_callback' => 'shopire_repeater_sanitize',
			 'priority' => 5,
			  'default' => shopire_slider_data_options_default()
			)
		);
		
		$wp_customize->add_control( 
			new Shopire_Repeater( $wp_customize, 
				'shopire_slider_data_option', 
					array(
						'label'   => esc_html__('Slider More Data','fable-extra'),
						'section' => 'slider_options',
						'add_field_label'                   => esc_html__( 'Add New Slider', 'fable-extra' ),
						'item_name'                         => esc_html__( 'Slider Data', 'fable-extra' ),
						
						'customizer_repeater_title_control' => true,
						'customizer_repeater_subtitle_control' => true,
						'customizer_repeater_text2_control'=> true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_image_control' => true
					) 
				) 
			);
			
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_slider_data_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 5,
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_slider_data_option_upsale', 
				array(
					'label'      => __( 'Slides Data', 'fable-extra' ),
					'section'    => 'slider_options'
				) 
			) 
		);
	}	
	}
	// slider opacity
	if ( class_exists( 'Shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_slider_opacity',
			array(
				'default'	      => '0',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'priority' => 7,
			)
		);
		$wp_customize->add_control( 
		new Shopire_Customizer_Range_Control( $wp_customize, 'shopire_slider_opacity', 
			array(
				'label'      => __( 'opacity', 'fable-extra' ),
				'section'  => 'slider_options',
				 'media_query'   => false,
					'input_attr'    => array(
						'desktop' => array(
							'min'           => 0,
							'max'           => 0.9,
							'step'          => 0.1,
							'default_value' => 0,
						),
					),
			) ) 
		);
	}
	
	 // Overlay Color
	$wp_customize->add_setting(
	'shopire_slider_overlay', 
	array(
		'default'	      => '#000000',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'priority' => 8,
    ));
	
	$wp_customize->add_control( 
		new WP_Customize_Color_Control
		($wp_customize, 
			'shopire_slider_overlay', 
			array(
				'label'      => __( 'Overlay Color', 'fable-extra' ),
				'section'    => 'slider_options'
			) 
		) 
	);
}
add_action( 'customize_register', 'shopire_slider_customize_setting' );