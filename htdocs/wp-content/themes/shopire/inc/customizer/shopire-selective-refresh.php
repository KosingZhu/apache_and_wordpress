<?php
function shopire_site_selective_partials( $wp_customize ){
	// shopire_hdr_top_contact_title
	$wp_customize->selective_refresh->add_partial( 'shopire_hdr_top_contact_title', array(
		'selector'            => '.wf_header .wf_header-widget .widget--left .widget_contact .title',
		'settings'            => 'shopire_hdr_top_contact_title',
		'render_callback'  => 'shopire_hdr_top_contact_title_render_callback',
	) );
	
	// shopire_hdr_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'shopire_hdr_btn_lbl', array(
		'selector'            => '.wf_header .wf_navbar-button-item a',
		'settings'            => 'shopire_hdr_btn_lbl',
		'render_callback'  => 'shopire_hdr_btn_lbl_render_callback',
	) );
	
	// shopire_hdr_bcat_ttl
	$wp_customize->selective_refresh->add_partial( 'shopire_hdr_bcat_ttl', array(
		'selector'            => '.wf_header .product-categories .product-categories-btn',
		'settings'            => 'shopire_hdr_bcat_ttl',
		'render_callback'  => 'shopire_hdr_bcat_ttl_render_callback',
	) );
	
	// shopire_hdr_contact_ttl
	$wp_customize->selective_refresh->add_partial( 'shopire_hdr_contact_ttl', array(
		'selector'            => '.wf_header .wf_navbar-info-contact .title',
		'settings'            => 'shopire_hdr_contact_ttl',
		'render_callback'  => 'shopire_hdr_contact_ttl_render_callback',
	) );
	
	// shopire_hdr_contact_txt
	$wp_customize->selective_refresh->add_partial( 'shopire_hdr_contact_txt', array(
		'selector'            => '.wf_header .wf_navbar-info-contact .description',
		'settings'            => 'shopire_hdr_contact_txt',
		'render_callback'  => 'shopire_hdr_contact_txt_render_callback',
	) );

	// shopire_footer_copyright_text
	$wp_customize->selective_refresh->add_partial( 'shopire_footer_copyright_text', array(
		'selector'            => '.wf_footer_copyright-text',
		'settings'            => 'shopire_footer_copyright_text',
		'render_callback'  => 'shopire_footer_copyright_text_render_callback',
	) );
	}
add_action( 'customize_register', 'shopire_site_selective_partials' );