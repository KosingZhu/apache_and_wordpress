<?php 
$shopire_slider_options_hide_show = get_theme_mod('shopire_slider_options_hide_show','1'); 
$shopire_slider_option 		= get_theme_mod('shopire_slider_option',shopire_slider_options_default());
if($shopire_slider_options_hide_show=='1'):
?>
<section id="wf_slider" class="wf_slider wf_slider_banner wf_slider--eleven">
	<div class="wf-container">
		<div class="wf-row wf-g-4">
			<div class="wf-col-lg-12 wf-col-md-12">
				<div class="wf_owl_carousel owl-theme owl-carousel slider" data-owl-options='{
					"loop": true,
					"items": 1,
					"autoplay": true,
					"autoplayTimeout": 7000,
					"smartSpeed": 1000,
					"nav": true,
					"navText": ["<i class=\"fal fa-arrow-left\"></i>","<i class=\"fal fa-arrow-right\"></i>"],
					"dots": false,
					"responsive": {
                        "0": {
                            "dots": true,
                            "nav": false
                        },
                        "576": {
                            "dots": true,
                            "nav": false
                        },
                        "768": {
                            "margin": 8,
                            "stagePadding": 30,
                            "dots": false,
                            "nav": true
                        },
                        "992": {
                            "margin": 20,
                            "stagePadding": 150,
                            "dots": false,
                            "nav": true
                        }
                    },
					"margin": 0
					}'>
					<?php
						if ( ! empty( $shopire_slider_option ) ) {
							$allowed_html = array(
									'br'     => array(),
									'em'     => array(),
									'strong' => array(),
									'span' => array(),
									'b'      => array(),
									'i'      => array(),
									);
						$shopire_slider_option = json_decode( $shopire_slider_option );
						foreach ( $shopire_slider_option as $item ) {
							$title = ! empty( $item->title ) ? apply_filters( 'shopire_translate_single_string', $item->title, 'slider section' ) : '';
							$subtitle = ! empty( $item->subtitle ) ? apply_filters( 'shopire_translate_single_string', $item->subtitle, 'slider section' ) : '';
							$text = ! empty( $item->text ) ? apply_filters( 'shopire_translate_single_string', $item->text, 'slider section' ) : '';
							$button = ! empty( $item->text2) ? apply_filters( 'shopire_translate_single_string', $item->text2,'slider section' ) : '';
							$link = ! empty( $item->link ) ? apply_filters( 'shopire_translate_single_string', $item->link, 'slider section' ) : '';
							$image = ! empty( $item->image_url2 ) ? apply_filters( 'shopire_translate_single_string', $item->image_url2, 'slider section' ) : '';
							$align = ! empty( $item->slide_align ) ? apply_filters( 'shopire_translate_single_string', $item->slide_align, 'slider section' ) : '';
					?>
						<div class="wf_slider-item">							
							<div class="wf_slider-wrapper">
								<div class="wf_slider-inner">
									<div class="wf_slider-innercell">
										<div class="wf-container">
											<div class="wf-row wf-text-<?php echo esc_attr($align); ?>">
												<div class="wf-col-lg-7 wf-col-md-8 wf-col-sm-8 first wf-my-auto">
													<div class="wf_slider-content">
														<?php if ( ! empty( $title ) ) : ?>
															<h5 class="subtitle"><i class="far fa-bolt"></i> <?php echo wp_kses( html_entity_decode( $title ), $allowed_html ); ?></h5>
														<?php endif; ?>
														
														<?php if ( ! empty( $subtitle ) ) : ?>
															<h2 class="title"><?php echo wp_kses( html_entity_decode( $subtitle ), $allowed_html ); ?></h2>
														<?php endif; ?>
														
														<?php if ( ! empty( $text ) ) : ?>
															<p class="text"><?php echo wp_kses( html_entity_decode( $text ), $allowed_html ); ?></p>
														<?php endif; ?>
														
														<div class="wf_btn-group">
															<?php if ( ! empty( $button ) ) : ?>
																<a href="<?php echo esc_url($link); ?>" class="wf-btn wf-btn-primary"><?php echo wp_kses( html_entity_decode( $button ), $allowed_html ); ?></a>
															<?php endif; ?>
														</div>
													</div>
												</div>
												<?php if(! empty( $image )): ?>
												<div class="wf-col-lg-5 wf-col-md-4 wf-col-sm-4 last wf-my-auto wf-d-sm-block wf-d-none">
													<div class="banner-img">
														<img src="<?php echo esc_url($image); ?>" alt="<?php echo wp_kses( html_entity_decode( $title ), $allowed_html ); ?>"/>
													</div>
												</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>