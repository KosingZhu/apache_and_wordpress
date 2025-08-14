<?php
function fable_extra_shopire_footer_customize_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Footer Top
	=========================================*/	
	$wp_customize->add_section(
        'shopire_footer_top_options',
        array(
            'title' 		=> __('Footer Top','fable-extra'),
			'panel'  		=> 'footer_options',
			'priority'      => 2,
		)
    );
	// Heading
	$wp_customize->add_setting(
		'shopire_footer_top_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'shopire_footer_top_head',
		array(
			'type' => 'hidden',
			'label' => __('Footer Top','fable-extra'),
			'section' => 'shopire_footer_top_options',
			'priority' => 2,
		)
	);
	
	// hide/show
	$wp_customize->add_setting( 
		'shopire_hs_footer_top' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_checkbox',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'shopire_hs_footer_top', 
		array(
			'label'	      => esc_html__( 'Hide/Show ?', 'fable-extra' ),
			'section'     => 'shopire_footer_top_options',
			'type'        => 'checkbox'
		) 
	);	
	
	
	// Content Head
	$wp_customize->add_setting(
		'shopire_footer_top_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'shopire_footer_top_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Content','fable-extra'),
			'section' => 'shopire_footer_top_options',
		)
	);
	
	// Contact 
	$wp_customize->add_setting( 'shopire_footer_top_ct_option', 
		array(
		 'sanitize_callback' => 'shopire_repeater_sanitize',
		 'priority' => 5,
		  'default' => shopire_footer_top_ct_option_default()
		)
	);
	
	$wp_customize->add_control( 
		new Shopire_Repeater( $wp_customize, 
			'shopire_footer_top_ct_option', 
				array(
					'label'   => esc_html__('Contact','fable-extra'),
					'section' => 'shopire_footer_top_options',
					'add_field_label'                   => esc_html__( 'Add New Contact', 'fable-extra' ),
					'item_name'                         => esc_html__( 'Contact', 'fable-extra' ),
					
					'customizer_repeater_title_control' => true,
					'customizer_repeater_text_control' => true,
					'customizer_repeater_link_control' => true,
					'customizer_repeater_icon_control' => true,
				) 
			) 
		);
		
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_footer_top_ct_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 5,
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_footer_top_ct_option_upsale', 
				array(
					'label'      => __( 'Contact', 'fable-extra' ),
					'section'    => 'shopire_footer_top_options'
				) 
			) 
		);
	}	
}
add_action( 'customize_register', 'fable_extra_shopire_footer_customize_settings' );