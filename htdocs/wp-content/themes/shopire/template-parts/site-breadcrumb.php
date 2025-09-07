<?php 
$shopire_hs_site_breadcrumb = get_theme_mod('shopire_hs_site_breadcrumb','1');
$shopire_breadcrumb_type    = get_theme_mod('shopire_breadcrumb_type','theme');
if($shopire_hs_site_breadcrumb == '1'):	
?>
<section id="wf_pagetitle" class="wf_pagetitle wf-text-center">
	<div class="wf-container">
		<div class="wf_pagetitle_content">
			<?php if($shopire_breadcrumb_type == 'yoast' && (function_exists('yoast_breadcrumb'))):  yoast_breadcrumb(); ?>
			<?php elseif($shopire_breadcrumb_type == 'rankmath' && (function_exists('rank_math_the_breadcrumbs'))):  rank_math_the_breadcrumbs(); ?>	
			<?php elseif($shopire_breadcrumb_type == 'navxt' && (function_exists('bcn_display'))):  bcn_display(); else: ?>
				<div class="title">
					<?php
							if(is_home() || is_front_page()) {
								echo '<h2>'; echo single_post_title(); echo '</h2>';
							} else {
							    shopire_theme_page_header_title();
							} 
						?>
				</div>
				<ul class="wf_pagetitle_breadcrumb">
					<?php shopire_page_header_breadcrumbs(); ?>
				</ul>
			<?php endif; ?>		
		</div>
	</div>
	<div class="patterns-layer pattern_1"></div>
	<div class="patterns-layer pattern_2"></div>
</section>
<?php endif; ?>	