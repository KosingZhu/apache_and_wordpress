<?php
/**
 * Enqueue User Custom styles.
 */
if( ! function_exists( 'desert_shopire_user_custom_style' ) ):
    function desert_shopire_user_custom_style() {

		$shopire_print_style = '';
		
		/*=========================================
		Slider 
		=========================================*/
		$shopire_slider_overlay 	= get_theme_mod('shopire_slider_overlay','#000000');
		$shopire_slider_opacity	= get_theme_mod('shopire_slider_opacity','0');
		list($color1, $color2, $color3) = sscanf($shopire_slider_overlay, "#%02x%02x%02x");
		$shopire_print_style .=".wf_slider .wf_slider-wrapper, .wf_slider .wf_slider-item img+.wf_slider-wrapper {
			background-color: rgba($color1, $color2, $color3, $shopire_slider_opacity);
		}\n";
				
        wp_add_inline_style( 'shopire-style', $shopire_print_style );
    }
endif;
add_action( 'wp_enqueue_scripts', 'desert_shopire_user_custom_style' );