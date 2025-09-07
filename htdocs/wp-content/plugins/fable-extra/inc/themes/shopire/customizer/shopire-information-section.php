<?php
function shopire_information_customize_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Information Section Panel
	=========================================*/
	$wp_customize->add_panel(
		'shopire_frontpage_options', array(
			'priority' => 32,
			'title' => esc_html__( 'Theme Frontpage', 'fable-extra' ),
		)
	);
	
	$wp_customize->add_section(
		'information_options', array(
			'title' => esc_html__( 'Information Section', 'fable-extra' ),
			'panel' => 'shopire_frontpage_options',
			'priority' => 1,
		)
	);
	
	/*=========================================
	Information Setting
	=========================================*/
	$wp_customize->add_setting(
		'shopire_information_options_setting'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_information_options_setting',
		array(
			'type' => 'hidden',
			'label' => __('Information Setting','fable-extra'),
			'section' => 'information_options',
		)
	);
	
	// Hide/Show Setting
	$wp_customize->add_setting(
		'shopire_information_options_hide_show'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'shopire_information_options_hide_show',
		array(
			'type' => 'checkbox',
			'label' => __('Hide/Show Section','fable-extra'),
			'section' => 'information_options',
		)
	);
	
	/*=========================================
	Information Content
	=========================================*/
	$wp_customize->add_setting(
		'information_options_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'information_options_head',
		array(
			'type' => 'hidden',
			'label' => __('Information Contents','fable-extra'),
			'section' => 'information_options',
		)
	);
	
	// Information 
		$wp_customize->add_setting( 'shopire_information_option', 
			array(
			 'sanitize_callback' => 'shopire_repeater_sanitize',
			 'priority' => 5,
			  'default' => shopire_information_options_default()
			)
		);
		
		$wp_customize->add_control( 
			new Shopire_Repeater( $wp_customize, 
				'shopire_information_option', 
					array(
						'label'   => esc_html__('Slide','fable-extra'),
						'section' => 'information_options',
						'add_field_label'                   => esc_html__( 'Add New Information', 'fable-extra' ),
						'item_name'                         => esc_html__( 'Information', 'fable-extra' ),
						
						'customizer_repeater_title_control' => true,
						'customizer_repeater_text_control' => true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_icon_control' => true
					) 
				) 
			);
			
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_information_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 5,
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_information_option_upsale', 
				array(
					'label'      => __( 'Information', 'fable-extra' ),
					'section'    => 'information_options'
				) 
			) 
		);
	}
	
}
add_action( 'customize_register', 'shopire_information_customize_setting' );