<?php
/**
 * @package   Minicart
 */

require WPFE_PATH . 'inc/themes/shopire/customizer-repeater-default.php';
require WPFE_PATH . 'inc/themes/shopire/custom-style.php';
require WPFE_PATH . 'inc/themes/shopire/customizer/shopire-footer-section.php';
require WPFE_PATH . '/inc/themes/shopire/customizer/shopire-slider-section.php';
require WPFE_PATH . '/inc/themes/shopire/customizer/shopire-cat-section.php';
require WPFE_PATH . '/inc/themes/shopire/customizer/shopire-popular-product-section.php';
require WPFE_PATH . '/inc/themes/shopire/customizer/shopire-cta-section.php';
require WPFE_PATH . '/inc/themes/shopire/customizer/shopire-blog-section.php';
require WPFE_PATH . 'inc/themes/shopire/customizer/shopire-selective-refresh.php';
require WPFE_PATH . 'inc/themes/shopire/customizer/shopire-selective-partial.php';

if ( ! function_exists( 'fable_extra_shopire_frontpage_sections' ) ) :
	function fable_extra_shopire_frontpage_sections() {	
		require WPFE_PATH . 'inc/themes/minicart/front/section-slider.php';
		require WPFE_PATH . 'inc/themes/minicart/front/section-product-cat.php';
		require WPFE_PATH . 'inc/themes/shopire/front/section-popular-product.php';
		require WPFE_PATH . 'inc/themes/shopire/front/section-cta.php';
		require WPFE_PATH . 'inc/themes/shopire/front/section-blog.php';
    }
	add_action( 'Fable_Extra_Shopire_frontpage', 'fable_extra_shopire_frontpage_sections' );
endif;