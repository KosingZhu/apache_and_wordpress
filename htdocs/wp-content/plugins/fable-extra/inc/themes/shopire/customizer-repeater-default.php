<?php
/*
 *
 * Slider Default
 */
 function shopire_slider_options_default() {
	return apply_filters(
		'shopire_slider_options_default', json_encode(
				 array(
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/slider01.png'),
					'image_url2'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-img-1.png'),
					'title'           => esc_html__( 'Mega Sale Madness! Enjoy 30% off', 'fable-extra' ),
					'subtitle'         => esc_html__( 'Mobile Madness - Save Big Today!', 'fable-extra' ),
					'text'            => esc_html__( 'New Electronics Deals Added! Explore the latest discounts on cameras, wearables, and smart home devices.', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					"slide_align" => "left", 
					'id'              => 'shopire_customizer_repeater_slider_001',
				),
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/slider02.png'),
					'image_url2'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-img-2.png'),
					'title'           => esc_html__( 'Mega Sale Madness! Enjoy 50% off', 'fable-extra' ),
					'subtitle'         => esc_html__( 'Wrist Tech Marvels on a Budget!', 'fable-extra' ),
					'text'            => esc_html__( 'New Electronics Deals Added! Explore the latest discounts on cameras, wearables, and smart home devices.', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					"slide_align" => "left", 
					'id'              => 'shopire_customizer_repeater_slider_002',
				),
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/slider03.png'),
					'image_url2'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-img-3.png'),
					'title'           => esc_html__( 'Mega Sale Madness! Enjoy 30% off', 'fable-extra' ),
					'subtitle'         => esc_html__( 'Mobile Madness - Save Big Today!', 'fable-extra' ),
					'text'            => esc_html__( 'New Electronics Deals Added! Explore the latest discounts on cameras, wearables, and smart home devices.', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					"slide_align" => "left", 
					'id'              => 'shopire_customizer_repeater_slider_003',
				)
			)
		)
	);
}


/*
*
* Slider Default
*/
$fable_axtra_activated_theme = wp_get_theme(); // gets the current theme
if( 'EazyShop' == $fable_axtra_activated_theme->name  ||  'EasyBuy' == $fable_axtra_activated_theme->name){
 function shopire_slider_data_options_default() {
	return apply_filters(
		'shopire_slider_data_options_default', json_encode(
				 array(
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-01.png'),
					'title'           => esc_html__( 'HUAWEI Phones', 'fable-extra' ),
					'subtitle'         => esc_html__( 'From $629 <br>Offer Limited', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_slider_data_001'
				),
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-02.png'),
					'title'           => esc_html__( '100% Wooden', 'fable-extra' ),
					'subtitle'         => esc_html__( 'Table Cabinet', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_slider_data_002'
				),
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-03.png'),
					'title'           => esc_html__( 'Top Deals', 'fable-extra' ),
					'subtitle'         => esc_html__( 'Honor Speaker', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_slider_data_003'
				)
			)
		)
	);
}
}else{
   function shopire_slider_data_options_default() {
	return apply_filters(
		'shopire_slider_data_options_default', json_encode(
				 array(
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-01.png'),
					'title'           => esc_html__( 'HUAWEI Phones', 'fable-extra' ),
					'subtitle'         => esc_html__( 'From $629 <br>Offer Limited', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_slider_data_001'
				),
				array(
					'image_url'       => esc_url(WPFE_URL . '/inc/themes/shopire/assets/images/banner-02.png'),
					'title'           => esc_html__( '100% Wooden', 'fable-extra' ),
					'subtitle'         => esc_html__( 'Table Cabinet', 'fable-extra' ),
					'text2'	  =>  esc_html__( 'Shop Now', 'fable-extra' ),
					'link'	  =>  esc_html__( '#', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_slider_data_002'
				)
			)
		)
	);
}		
}


/*
 *
 * Information Default
 */
 function shopire_information_options_default() {
	return apply_filters(
		'shopire_information_options_default', json_encode(
				 array(
				array(
					'icon_value'       => 'fas fa-truck',
					'title'           => esc_html__( 'Fast Delivery', 'fable-extra' ),
					'text'            => esc_html__( 'Experience Lightning-Fast Delivery', 'fable-extra' ),
					'link'	  =>  '#',
					'id'              => 'shopire_customizer_repeater_information_001'
				),
				array(
					'icon_value'       => 'fas fa-sack-dollar',
					'title'           => esc_html__( 'Secured Payment', 'fable-extra' ),
					'text'            => esc_html__( 'Shop with Confidence', 'fable-extra' ),
					'link'	  =>  '#',
					'id'              => 'shopire_customizer_repeater_information_002'
				),
				array(
					'icon_value'       => 'fas fa-check',
					'title'           => esc_html__( 'Money Back', 'fable-extra' ),
					'text'            => esc_html__( 'Experience Lightning-Fast Delivery', 'fable-extra' ),
					'link'	  =>  '#',
					'id'              => 'shopire_customizer_repeater_information_003'
				),
				array(
					'icon_value'       => 'fas fa-headphones',
					'title'           => esc_html__( '24/7 Support', 'fable-extra' ),
					'text'            => esc_html__( 'Always Here for You', 'fable-extra' ),
					'link'	  =>  '#',
					'id'              => 'shopire_customizer_repeater_information_004'
				)
			)
		)
	);
}

/*
 *
 * Footer Top  Default
 */
 function shopire_footer_top_ct_option_default() {
	return apply_filters(
		'shopire_footer_top_ct_option_default', json_encode(
				 array(
				array(
					'icon_value'       => 'fas fa-truck',
					'title'           => esc_html__( 'Fast Delivery', 'fable-extra' ),
					'text'            => esc_html__( 'Experience Lightning-Fast Delivery', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_footer_top_001'
				),
				array(
					'icon_value'       => 'fas fa-sack-dollar',
					'title'           => esc_html__( 'Secured Payment', 'fable-extra' ),
					'text'            => esc_html__( 'Shop with Confidence', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_footer_top_002'
				),
				array(
					'icon_value'       => 'fas fa-check',
					'title'           => esc_html__( 'Money Back', 'fable-extra' ),
					'text'            => esc_html__( 'Experience Lightning-Fast Delivery', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_footer_top_003'
				),
				array(
					'icon_value'       => 'fas fa-headphones',
					'title'           => esc_html__( '24/7 Support', 'fable-extra' ),
					'text'            => esc_html__( 'Always Here for You', 'fable-extra' ),
					'id'              => 'shopire_customizer_repeater_footer_top_004'
				)
			)
		)
	);
}

/*=========================================
Shopire Footer Top
=========================================*/
if ( ! function_exists( 'shopire_footer_top' ) ) :
function shopire_footer_top() {
$shopire_hs_footer_top		 = get_theme_mod('shopire_hs_footer_top','1'); 
$shopire_footer_top_ct_option= get_theme_mod('shopire_footer_top_ct_option',shopire_footer_top_ct_option_default());
if ($shopire_hs_footer_top == '1'): 
?>
<div class="wf_footer-top">
	<div class="wf-container">
		<div class="wf-row wf-g-4 justify-content-center">
			<?php
				if ( ! empty( $shopire_footer_top_ct_option ) ) {
					$allowed_html = array(
							'br'     => array(),
							'em'     => array(),
							'strong' => array(),
							'span' => array(),
							'b'      => array(),
							'i'      => array(),
							);
				$shopire_footer_top_ct_option = json_decode( $shopire_footer_top_ct_option );
				foreach ( $shopire_footer_top_ct_option as $item ) {
					$title = ! empty( $item->title ) ? apply_filters( 'shopire_translate_single_string', $item->title, 'Footer Top section' ) : '';
					$text = ! empty( $item->text ) ? apply_filters( 'shopire_translate_single_string', $item->text, 'Footer Top section' ) : '';
					$link = ! empty( $item->link ) ? apply_filters( 'shopire_translate_single_string', $item->link, 'Footer Top section' ) : '';
					$icon = ! empty( $item->icon_value ) ? apply_filters( 'shopire_translate_single_string', $item->icon_value, 'Footer Top section' ) : ''; 
				?>
				<div class="wf-col-lg-3 wf-col-sm-6">
					<aside class="widget widget_contact">
						<div class="contact__list">
							<?php if ( ! empty( $icon ) ) : ?>
								<i class="<?php echo esc_attr($icon); ?>"></i>
							<?php endif; ?>
							<div class="contact__body">
							
								<?php if ( ! empty( $title ) ) : ?>
									<?php if ( ! empty( $link ) ) : ?>
										<h6 class="title"><a href="<?php echo esc_url($link); ?>"><?php echo wp_kses( html_entity_decode( $title ), $allowed_html ); ?></a></h6>
									<?php else: ?>	
										<h6 class="title"><?php echo wp_kses( html_entity_decode( $title ), $allowed_html ); ?></h6>
									<?php endif; ?>
								<?php endif; ?>
								
								<?php if ( ! empty( $text ) ) : ?>
									<p class="description"><?php echo wp_kses( html_entity_decode( $text ), $allowed_html ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</aside>
				</div>
			<?php } } ?>
		</div>
	</div>
</div>
<?php endif; 		
	} 
endif;
add_action( 'shopire_footer_top', 'shopire_footer_top' );