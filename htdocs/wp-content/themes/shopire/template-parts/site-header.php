<?php  do_action('shopire_site_preloader'); ?>	
<?php  do_action('shopire_wp_hdr_image'); ?>
<?php 
$shopire_hs_hdr_sticky = get_theme_mod( 'shopire_hs_hdr_sticky','1');
$shopire_hs_hdr_bcat   = get_theme_mod( 'shopire_hs_hdr_bcat','1'); 
?>
<header id="wf_header" class="wf_header header--one">
	<div class="wf_header-inner">
		<div class="wf_header-topbar wf-d-lg-block wf-d-none">
			<?php do_action('shopire_site_header'); ?>
		</div>
		<div class="wf_header-navwrapper">
			<div class="wf_header-navwrapperinner">
				<!--=== / Start: WF_Navbar / === -->
				<div class="wf_navbar wf-d-none wf-d-lg-block">
					<div class="wf_navbar-wrapper <?php if($shopire_hs_hdr_sticky=='1'): esc_attr_e('is--sticky','shopire'); endif; ?>">
						<div class="wf-container">
							<div class="wf-row align-items-center">
								<div class="wf-col-2">
									<div class="site--logo">
										<?php do_action('shopire_site_logo'); ?>
									</div>
								</div>
								<div class="wf-col-10">
									<div class="wf_navbar-menu">
										<nav class="wf_navbar-nav">
											<?php do_action('shopire_site_header_navigation'); ?>
										</nav>
										<div class="wf_navbar-right">
											<ul class="wf_navbar-list-right">
												<?php do_action('shopire_hdr_account'); ?>
												<?php do_action('shopire_hdr_side_docker'); ?>
												<?php do_action('shopire_header_button'); ?>                                                       
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="wf-row align-items-center">
								<?php if(class_exists( 'woocommerce' )): ?>
									<div class="wf-col-lg-3 wf-col-12">
										<?php do_action('shopire_header_bcat'); ?>
									</div>
								<?php endif; ?>	
								<div class="wf-col-lg-<?php if(!class_exists( 'woocommerce' )): esc_attr_e('9','shopire'); else: esc_attr_e('6','shopire'); endif; ?> wf-col-12">
									<?php do_action('shopire_hdr_product_search'); ?>
								</div>
								<div class="wf-col-lg-3 wf-col-12">
									<div class="wf_navbar-right">
										<ul class="wf_navbar-list-right">
											<?php do_action('shopire_header_contact'); ?>
											<?php do_action('shopire_woo_cart'); ?>                                                   
											<?php do_action('shopire_hcompare'); ?>    
											<?php do_action('shopire_hwishlist'); ?> 
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--=== / End: WF_Navbar / === -->
				<!--=== / Start: WF_Mobile Menu / === -->
				<div class="wf_mobilenav wf-d-lg-none <?php if($shopire_hs_hdr_sticky=='1'): esc_attr_e('is--sticky','shopire'); endif; ?>">
					<div class="wf_mobilenav-topbar">
						<button type="button" class="wf_mobilenav-topbar-toggle"><i class="fas fa-angle-double-down" aria-hidden="true"></i></button>
						<div class="wf_mobilenav-topbar-content">
							<div class="wf-container">
								<div class="wf-row">
									<div class="wf-col-12">
										<?php do_action('shopire_site_header'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="wf-container">
						<div class="wf-row">
							<div class="wf-col-12">
								<div class="wf_mobilenav-menu">
									<div class="wf_mobilenav-mainmenu">
										<button type="button" class="hamburger wf_mobilenav-mainmenu-toggle">
											<span></span>
											<span></span>
											<span></span>
										</button>
										<nav class="wf_mobilenav-mainmenu-content">
											<div class="wf_header-closemenu off--layer"></div>
											<div class="wf_mobilenav-mainmenu-inner">
												<button type="button" class="wf_header-closemenu site--close"></button>
												<div class="wf_mobilenav-mainmenu-wrap">
													<?php
													$shopire_hs_hdr_bcat 		= get_theme_mod( 'shopire_hs_hdr_bcat','1'); 
													$shopire_hs_hdr_bcat 		= get_theme_mod( 'shopire_hs_hdr_bcat','1'); 
													$shopire_hdr_bcat_ttl 		= get_theme_mod( 'shopire_hdr_bcat_ttl','Browse Categories'); 
													$shopire_hdr_mobile_nav_ttl = get_theme_mod( 'shopire_hdr_mobile_nav_ttl','Main Menu'); 
													if(!empty($shopire_hdr_mobile_nav_ttl) && $shopire_hs_hdr_bcat=='1' && !empty($shopire_hdr_bcat_ttl) && class_exists( 'woocommerce' )):
													?>
													<h5 class="title"><?php echo wp_kses_post($shopire_hdr_mobile_nav_ttl);?></h5>
													<?php 
														endif;
													?>
													<?php do_action('shopire_site_header_navigation'); ?>
													<?php
														if($shopire_hs_hdr_bcat=='1' && !empty($shopire_hdr_bcat_ttl) && class_exists( 'woocommerce' )):
													?>
														<h5 class="title"><?php echo wp_kses_post($shopire_hdr_bcat_ttl);?></h5>
													<?php 
														do_action('shopire_header_bcat_base'); 
														endif;
													?>
												</div>
											</div>
										</nav>
									</div>
									<div class="wf_mobilenav-logo">
										<div class="site--logo">
											<?php do_action('shopire_site_logo'); ?>
										</div>
									</div>
									<div class="wf_mobilenav-toggles">
										<div class="wf_mobilenav-right">
											<ul class="wf_navbar-list-right">                                                    
												<?php do_action('shopire_hdr_account'); ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--=== / End: WF_Mobile Menu / === -->
			</div>
		</div>
	</div>
</header>