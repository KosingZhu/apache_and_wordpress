<?php
function fable_extra_shopire_site_selective_partials( $wp_customize ){
	// shopire_product_cat_ttl
	$wp_customize->selective_refresh->add_partial( 'shopire_product_cat_ttl', array(
		'selector'            => '.front-product-cat .section-title .title',
		'settings'            => 'shopire_product_cat_ttl',
		'render_callback'  => 'shopire_product_cat_ttl_render_callback',
	) );
	
	// shopire_product_cat_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'shopire_product_cat_btn_lbl', array(
		'selector'            => '.front-product-cat .more-link',
		'settings'            => 'shopire_product_cat_btn_lbl',
		'render_callback'  => 'shopire_product_cat_btn_lbl_render_callback',
	) );
	
	// shopire_popular_product_ttl
	$wp_customize->selective_refresh->add_partial( 'shopire_popular_product_ttl', array(
		'selector'            => '.front-popular-product .section-title .title',
		'settings'            => 'shopire_popular_product_ttl',
		'render_callback'  => 'shopire_popular_product_ttl_render_callback',
	) );
	
	// shopire_cta_ttl
	$wp_customize->selective_refresh->add_partial( 'shopire_cta_ttl', array(
		'selector'            => '.front-cta .sub-title',
		'settings'            => 'shopire_cta_ttl',
		'render_callback'  => 'shopire_cta_ttl_render_callback',
	) );
	
	// shopire_cta_subttl
	$wp_customize->selective_refresh->add_partial( 'shopire_cta_subttl', array(
		'selector'            => '.front-cta .title',
		'settings'            => 'shopire_cta_subttl',
		'render_callback'  => 'shopire_cta_subttl_render_callback',
	) );
	
	// shopire_cta_text
	$wp_customize->selective_refresh->add_partial( 'shopire_cta_text', array(
		'selector'            => '.front-cta .wf-mt-2',
		'settings'            => 'shopire_cta_text',
		'render_callback'  => 'shopire_cta_text_render_callback',
	) );
	
	// shopire_cta_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'shopire_cta_btn_lbl', array(
		'selector'            => '.front-cta .wf-btn',
		'settings'            => 'shopire_cta_btn_lbl',
		'render_callback'  => 'shopire_cta_btn_lbl_render_callback',
	) );
	
	// shopire_blog_ttl
	$wp_customize->selective_refresh->add_partial( 'shopire_blog_ttl', array(
		'selector'            => '.front-posts .section-title .sub-title',
		'settings'            => 'shopire_blog_ttl',
		'render_callback'  => 'shopire_blog_ttl_render_callback',
	) );
	
	// shopire_blog_subttl
	$wp_customize->selective_refresh->add_partial( 'shopire_blog_subttl', array(
		'selector'            => '.front-posts .section-title .title',
		'settings'            => 'shopire_blog_subttl',
		'render_callback'  => 'shopire_blog_subttl_render_callback',
	) );
	
	// shopire_blog_text
	$wp_customize->selective_refresh->add_partial( 'shopire_blog_text', array(
		'selector'            => '.front-posts .section-title p.wf-mb-2',
		'settings'            => 'shopire_blog_text',
		'render_callback'  => 'shopire_blog_text_render_callback',
	) );
	}
add_action( 'customize_register', 'fable_extra_shopire_site_selective_partials' );