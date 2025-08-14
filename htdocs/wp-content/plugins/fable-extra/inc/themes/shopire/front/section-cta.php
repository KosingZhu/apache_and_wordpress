<?php  
$shopire_cta_options_hide_show = get_theme_mod('shopire_cta_options_hide_show','1'); 
$shopire_cta_ttl		= get_theme_mod('shopire_cta_ttl','Hurry Up!');
$shopire_cta_subttl 	= get_theme_mod('shopire_cta_subttl','Year Ending Sale Up To 70% Off!');
$shopire_cta_text 		= get_theme_mod('shopire_cta_text','Explore our exclusive sale on cutting-edge electronics devices.');
$shopire_cta_btn_lbl	= get_theme_mod('shopire_cta_btn_lbl','Shop Now');
$shopire_cta_btn_link 	= get_theme_mod('shopire_cta_btn_link','#');
$shopire_cta_img  		= get_theme_mod('shopire_cta_img',esc_url(WPFE_URL . 'inc/themes/shopire/assets/images/iphone.png'));
if($shopire_cta_options_hide_show=='1'):
?>	
<div id="wf_hurry_section" class="wf_hurry_section front-cta">
	<div class="wf-container">
		<div class="wf-row">
			<div class="wf-col-12">
				<div class="wf_hurry">
					<div class="wf-row align-items-end">
						<div class="wf-col-lg-6">
							<div class="hurry-content">
								<div class="section-title">
									<?php if ( ! empty( $shopire_cta_ttl )) : ?>
										<span class="sub-title"><?php echo wp_kses_post( $shopire_cta_ttl); ?></span>
									<?php endif; ?>
									
									<?php if ( ! empty( $shopire_cta_subttl )) : ?>
										<h2 class="title"><?php echo wp_kses_post( $shopire_cta_subttl); ?></h2>
									<?php endif; ?>
									
									<?php if ( ! empty( $shopire_cta_text )) : ?>
										<p class="wf-mt-2 wf-mb-4"><?php echo wp_kses_post( $shopire_cta_text); ?></p>
									<?php endif; ?>
									
									<?php if ( ! empty( $shopire_cta_btn_lbl )) : ?>
										<a href="<?php echo esc_url($shopire_cta_btn_link); ?>" class="wf-btn wf-btn-primary"><?php echo wp_kses_post( $shopire_cta_btn_lbl); ?> <i class="fas fa-arrow-right"></i></a>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="wf-col-lg-6">
							<?php if ( ! empty( $shopire_cta_img )) : ?>
								<div class="hurry-img wf-text-center">
									<img src="<?php echo esc_url($shopire_cta_img); ?>">
								</div>
							<?php endif; ?>
						</div>
					</div>
					<img src="<?php echo esc_url(WPFE_URL); ?>inc/themes/shopire/assets/images/bg-shape01.png" class="hurry-img-bg" alt="bg-shape01">
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>