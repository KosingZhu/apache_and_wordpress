<?php 
$shopire_information_options_hide_show = get_theme_mod('shopire_information_options_hide_show','1'); 
$shopire_information_option 		   = get_theme_mod('shopire_information_option',shopire_information_options_default());
if($shopire_information_options_hide_show=='1'):
?>	
<section id="wf_information" class="wf_information wf_information--two wf-pt-4">
    <div class="wf-container">
        <div class="wf-row wf-g-4 justify-content-center">
			<?php
					if ( ! empty( $shopire_information_option ) ) {
						$allowed_html = array(
								'br'     => array(),
								'em'     => array(),
								'strong' => array(),
								'span' => array(),
								'b'      => array(),
								'i'      => array(),
								);
					$shopire_information_option = json_decode( $shopire_information_option );
					foreach ( $shopire_information_option as $item ) {
						$title = ! empty( $item->title ) ? apply_filters( 'shopire_translate_single_string', $item->title, 'Information section' ) : '';
						$text = ! empty( $item->text ) ? apply_filters( 'shopire_translate_single_string', $item->text, 'Information section' ) : '';
						$link = ! empty( $item->link ) ? apply_filters( 'shopire_translate_single_string', $item->link, 'Information section' ) : '';
						$icon = ! empty( $item->icon_value ) ? apply_filters( 'shopire_translate_single_string', $item->icon_value, 'Information section' ) : '';
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
</section>
<?php endif; ?>