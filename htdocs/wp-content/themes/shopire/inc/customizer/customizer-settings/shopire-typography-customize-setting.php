<?php
function shopire_typography_customize( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';	

	$wp_customize->add_panel(
		'shopire_typography_options', array(
			'priority' => 38,
			'title' => esc_html__( 'Typography', 'shopire' ),
		)
	);	
	
	/*=========================================
	shopire Typography
	=========================================*/
	$wp_customize->add_section(
        'shopire_typography_options',
        array(
        	'priority'      => 1,
            'title' 		=> __('Body Typography','shopire'),
			'panel'  		=> 'shopire_typography_options',
		)
    );
	
	
	// Body Font Size // 
	if ( class_exists( 'shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_body_font_size_option',
			array(
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new shopire_Customizer_Range_Control( $wp_customize, 'shopire_body_font_size_option', 
			array(
				'label'      => __( 'Size', 'shopire' ),
				'section'  => 'shopire_typography_options',
				'priority'      => 2,
				 'media_query'   => true,
                'input_attr'    => array(
                    'mobile'  => array(
                        'min'           => 1,
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
	
	// Body Font Size // 
	if ( class_exists( 'shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_body_line_height_option',
			array(
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new shopire_Customizer_Range_Control( $wp_customize, 'shopire_body_line_height_option', 
			array(
				'label'      => __( 'Line Height', 'shopire' ),
				'section'  => 'shopire_typography_options',
				'priority'      => 3,
				 'media_query'   => true,
                'input_attr'    => array(
                    'mobile'  => array(
                        'min'           => 0,
                        'max'           => 3,
                        'step'          => 0.1,
                        'default_value' => 1.6,
                    ),
                    'tablet'  => array(
                        'min'           => 0,
                        'max'           => 3,
                        'step'          => 0.1,
                        'default_value' => 1.6,
                    ),
                    'desktop' => array(
                       'min'           => 0,
                        'max'           => 3,
                        'step'          => 0.1,
                        'default_value' => 1.6,
                    ),
				)	
			) ) 
		);
	}
	
	// Body Font Size // 
	if ( class_exists( 'shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_body_ltr_space_option',
			array(
                'default'           => '0.1',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new shopire_Customizer_Range_Control( $wp_customize, 'shopire_body_ltr_space_option', 
			array(
				'label'      => __( 'Letter Spacing', 'shopire' ),
				'section'  => 'shopire_typography_options',
				'priority'      => 4,
				 'media_query'   => true,
                'input_attr'    => array(
                    'mobile'  => array(
                        'min'           => -10,
                        'max'           => 10,
                        'step'          => 1,
                        'default_value' => 0,
                    ),
                    'tablet'  => array(
                       'min'           => -10,
                        'max'           => 10,
                        'step'          => 1,
                        'default_value' => 0,
                    ),
                    'desktop' => array(
                       'min'           => -10,
                        'max'           => 10,
                        'step'          => 1,
                        'default_value' => 0,
                    ),
				)	
			) ) 
		);
	}
	
	// Body Font weight // 
	 $wp_customize->add_setting( 'shopire_body_font_weight_option', array(
      'capability'        => 'edit_theme_options',
      'default'           => 'inherit',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'shopire_sanitize_select',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
                $wp_customize, 'shopire_body_font_weight_option', array(
            'label'       => __( 'Weight', 'shopire' ),
            'section'     => 'shopire_typography_options',
            'type'        =>  'select',
            'priority'    => 5,
            'choices'     =>  array(
                'inherit'   =>  __( 'Default', 'shopire' ),
                '100'       =>  __( 'Thin: 100', 'shopire' ),
                '200'       =>  __( 'Light: 200', 'shopire' ),
                '300'       =>  __( 'Book: 300', 'shopire' ),
                '400'       =>  __( 'Normal: 400', 'shopire' ),
                '500'       =>  __( 'Medium: 500', 'shopire' ),
                '600'       =>  __( 'Semibold: 600', 'shopire' ),
                '700'       =>  __( 'Bold: 700', 'shopire' ),
                '800'       =>  __( 'Extra Bold: 800', 'shopire' ),
                '900'       =>  __( 'Black: 900', 'shopire' ),
                ),
            )
        )
    );
	
	// Body Font style // 
	 $wp_customize->add_setting( 'shopire_body_font_style_option', array(
      'capability'        => 'edit_theme_options',
      'default'           => 'inherit',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'shopire_sanitize_select',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
                $wp_customize, 'shopire_body_font_style_option', array(
            'label'       => __( 'Font Style', 'shopire' ),
            'section'     => 'shopire_typography_options',
            'type'        =>  'select',
            'priority'    => 6,
            'choices'     =>  array(
                'inherit'   =>  __( 'Inherit', 'shopire' ),
                'normal'       =>  __( 'Normal', 'shopire' ),
                'italic'       =>  __( 'Italic', 'shopire' ),
                'oblique'       =>  __( 'oblique', 'shopire' ),
                ),
            )
        )
    );
	// Body Text Transform // 
	 $wp_customize->add_setting( 'shopire_body_text_transform_option', array(
      'capability'        => 'edit_theme_options',
      'default'           => 'inherit',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'shopire_sanitize_select',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'shopire_body_text_transform_option', array(
                'label'       => __( 'Transform', 'shopire' ),
                'section'     => 'shopire_typography_options',
                'type'        => 'select',
                'priority'    => 7,
                'choices'     => array(
                    'inherit'       =>  __( 'Default', 'shopire' ),
                    'uppercase'     =>  __( 'Uppercase', 'shopire' ),
                    'lowercase'     =>  __( 'Lowercase', 'shopire' ),
                    'capitalize'    =>  __( 'Capitalize', 'shopire' ),
                ),
            )
        )
    );
	
	// Body Text Decoration // 
	 $wp_customize->add_setting( 'shopire_body_txt_decoration_option', array(
      'capability'        => 'edit_theme_options',
      'default'           => 'inherit',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'shopire_sanitize_select',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'shopire_body_txt_decoration_option', array(
                'label'       => __( 'Text Decoration', 'shopire' ),
                'section'     => 'shopire_typography_options',
                'type'        => 'select',
                'priority'    => 8,
                'choices'     => array(
                    'inherit'       =>  __( 'Inherit', 'shopire' ),
                    'underline'     =>  __( 'Underline', 'shopire' ),
                    'overline'     =>  __( 'Overline', 'shopire' ),
                    'line-through'    =>  __( 'Line Through', 'shopire' ),
					'none'    =>  __( 'None', 'shopire' ),
                ),
            )
        )
    );
	
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_body_typography_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_body_typography_option_upsale', 
				array(
					'label'      => __( 'Typography Features', 'shopire' ),
					'section'    => 'shopire_typography_options',
					'priority' => 8,
				) 
			) 
		);	
	}
	
	/*=========================================
	 shopire Typography Headings
	=========================================*/
	$wp_customize->add_section(
        'shopire_headings_typography',
        array(
        	'priority'      => 2,
            'title' 		=> __('Headings (H1-H6) Typography','shopire'),
			'panel'  		=> 'shopire_typography_options',
		)
    );
	
	/*=========================================
	 shopire Typography H1
	=========================================*/
	for ( $i = 1; $i <= 6; $i++ ) {
	if($i  == '1'){$j=36;}elseif($i  == '2'){$j=32;}elseif($i  == '3'){$j=28;}elseif($i  == '4'){$j=24;}elseif($i  == '5'){$j=20;}else{$j=16;}
	$wp_customize->add_setting(
		'h' . $i . '_typography'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'shopire_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'h' . $i . '_typography',
		array(
			'type' => 'hidden',
			'label' => esc_html('H' . $i .' Typography','shopire'),
			'section' => 'shopire_headings_typography',
		)
	);
	
	// Heading Font Size // 
	if ( class_exists( 'shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_h' . $i . '_font_size_option',
			array(
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage'
			)
		);
		$wp_customize->add_control( 
		new shopire_Customizer_Range_Control( $wp_customize, 'shopire_h' . $i . '_font_size_option', 
			array(
				'label'      => __( 'Font Size', 'shopire' ),
				'section'  => 'shopire_headings_typography',
				'media_query'   => true,
				'input_attr'    => array(
                    'mobile'  => array(
                        'min'           => 1,
                        'max'           => 100,
                        'step'          => 1,
                        'default_value' => $j,
                    ),
                    'tablet'  => array(
                        'min'           => 1,
                        'max'           => 100,
                        'step'          => 1,
                        'default_value' => $j,
                    ),
                    'desktop' => array(
                       'min'           => 1,
                        'max'           => 100,
                        'step'          => 1,
					    'default_value' => $j,
                    ),
				)	
			) ) 
		);
	}
	
	// Heading Font Size // 
	if ( class_exists( 'shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_h' . $i . '_line_height_option',
			array(
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new shopire_Customizer_Range_Control( $wp_customize, 'shopire_h' . $i . '_line_height_option', 
			array(
				'label'      => __( 'Line Height', 'shopire' ),
				'section'  => 'shopire_headings_typography',
				'media_query'   => true,
				'input_attrs' => array(
					'min'    => 0,
					'max'    => 5,
					'step'   => 0.1,
					//'suffix' => 'px', //optional suffix
				),
				 'input_attr'    => array(
                    'mobile'  => array(
                        'min'           => 0,
                        'max'           => 3,
                        'step'          => 0.1,
                        'default_value' => 1.2,
                    ),
                    'tablet'  => array(
                        'min'           => 0,
                        'max'           => 3,
                        'step'          => 0.1,
                        'default_value' => 1.2,
                    ),
                    'desktop' => array(
                       'min'           => 0,
                        'max'           => 3,
                        'step'          => 0.1,
                        'default_value' => 1.2,
                    ),
				)	
			) ) 
		);
		}
	// Heading Letter Spacing // 
	if ( class_exists( 'shopire_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'shopire_h' . $i . '_ltr_space_option',
			array(
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'shopire_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new shopire_Customizer_Range_Control( $wp_customize, 'shopire_h' . $i . '_ltr_space_option', 
			array(
				'label'      => __( 'Letter Spacing', 'shopire' ),
				'section'  => 'shopire_headings_typography',
				 'media_query'   => true,
                'input_attr'    => array(
                    'mobile'  => array(
                        'min'           => -10,
                        'max'           => 10,
                        'step'          => 1,
                        'default_value' => 0.1,
                    ),
                    'tablet'  => array(
                       'min'           => -10,
                        'max'           => 10,
                        'step'          => 1,
                        'default_value' => 0.1,
                    ),
                    'desktop' => array(
                       'min'           => -10,
                        'max'           => 10,
                        'step'          => 1,
                        'default_value' => 0.1,
                    ),
				)	
			) ) 
		);
	}
	
	// Heading Font weight // 
	 $wp_customize->add_setting( 'shopire_h' . $i . '_font_weight_option', array(
		  'capability'        => 'edit_theme_options',
		  'default'           => '700',
		  'transport'         => 'postMessage',
		  'sanitize_callback' => 'shopire_sanitize_select',
		) );

    $wp_customize->add_control(
        new WP_Customize_Control(
                $wp_customize, 'shopire_h' . $i . '_font_weight_option', array(
            'label'       => __( 'Font Weight', 'shopire' ),
            'section'     => 'shopire_headings_typography',
            'type'        =>  'select',
            'choices'     =>  array(
                'inherit'   =>  __( 'Inherit', 'shopire' ),
                '100'       =>  __( 'Thin: 100', 'shopire' ),
                '200'       =>  __( 'Light: 200', 'shopire' ),
                '300'       =>  __( 'Book: 300', 'shopire' ),
                '400'       =>  __( 'Normal: 400', 'shopire' ),
                '500'       =>  __( 'Medium: 500', 'shopire' ),
                '600'       =>  __( 'Semibold: 600', 'shopire' ),
                '700'       =>  __( 'Bold: 700', 'shopire' ),
                '800'       =>  __( 'Extra Bold: 800', 'shopire' ),
                '900'       =>  __( 'Black: 900', 'shopire' ),
                ),
            )
        )
    );
	
	// Heading Font style // 
	 $wp_customize->add_setting( 'shopire_h' . $i . '_font_style_option', array(
      'capability'        => 'edit_theme_options',
      'default'           => 'inherit',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'shopire_sanitize_select',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
                $wp_customize, 'shopire_h' . $i . '_font_style_option', array(
            'label'       => __( 'Font Style', 'shopire' ),
            'section'     => 'shopire_headings_typography',
            'type'        =>  'select',
            'choices'     =>  array(
                'inherit'   =>  __( 'Inherit', 'shopire' ),
                'normal'       =>  __( 'Normal', 'shopire' ),
                'italic'       =>  __( 'Italic', 'shopire' ),
                'oblique'       =>  __( 'oblique', 'shopire' ),
                ),
            )
        )
    );
	
	// Heading Text Transform // 
	 $wp_customize->add_setting( 'shopire_h' . $i . '_text_transform_option', array(
      'capability'        => 'edit_theme_options',
      'default'           => 'inherit',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'shopire_sanitize_select',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'shopire_h' . $i . '_text_transform_option', array(
                'label'       => __( 'Text Transform', 'shopire' ),
                'section'     => 'shopire_headings_typography',
                'type'        => 'select',
                'choices'     => array(
                    'inherit'       =>  __( 'Default', 'shopire' ),
                    'uppercase'     =>  __( 'Uppercase', 'shopire' ),
                    'lowercase'     =>  __( 'Lowercase', 'shopire' ),
                    'capitalize'    =>  __( 'Capitalize', 'shopire' ),
                ),
            )
        )
    );
	
	// Heading Text Decoration // 
	 $wp_customize->add_setting( 'shopire_h' . $i . '_txt_decoration_option', array(
      'capability'        => 'edit_theme_options',
      'default'           => 'inherit',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'shopire_sanitize_select',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'shopire_h' . $i . '_txt_decoration_option', array(
                'label'       => __( 'Text Decoration', 'shopire' ),
                'section'     => 'shopire_headings_typography',
                'type'        => 'select',
                'choices'     => array(
                    'inherit'       =>  __( 'Inherit', 'shopire' ),
                    'underline'     =>  __( 'Underline', 'shopire' ),
                    'overline'     =>  __( 'Overline', 'shopire' ),
                    'line-through'    =>  __( 'Line Through', 'shopire' ),
					'none'    =>  __( 'None', 'shopire' ),
                ),
            )
        )
    );
	
	// Upgrade
	if ( class_exists( 'Fable_Extra_Customize_Upgrade_Control' ) ) {
		$wp_customize->add_setting(
		'shopire_h' . $i . '_typography_option_upsale', 
		array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		));
		
		$wp_customize->add_control( 
			new Fable_Extra_Customize_Upgrade_Control
			($wp_customize, 
				'shopire_h' . $i . '_typography_option_upsale', 
				array(
					'label'      => __( 'Typography Features', 'shopire' ),
					'section'    => 'shopire_headings_typography',
				) 
			) 
		);	
	}
}
}
add_action( 'customize_register', 'shopire_typography_customize' );