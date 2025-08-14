<?php  
$shopire_popular_product_options_hide_show= get_theme_mod('shopire_popular_product_options_hide_show','1'); 
$shopire_popular_product_ttl			= get_theme_mod('shopire_popular_product_ttl','Popular Product');
$shopire_popular_product_hs_tab			= get_theme_mod('shopire_popular_product_hs_tab','1'); 
$shopire_popular_product_cat			= get_theme_mod('shopire_popular_product_cat');
$shopire_popular_product_num			= get_theme_mod('shopire_popular_product_num','20');
do_action('shopire_popular_product_option_before');
if($shopire_popular_product_options_hide_show=='1'):
?>
<?php 
if ( class_exists( 'woocommerce' ) ) {
	$args                   = array(
		'post_type' => 'product',
		'posts_per_page' => $shopire_popular_product_num,
	);
	if(!empty($shopire_popular_product_cat)):
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => $shopire_popular_product_cat,
		),
	);
	endif;
?>
<section id="wf_popular_product" class="wf_popular-product popular-product-carousel wf-py-default front-popular-product">
	<div class="wf-container">
		<?php if ( ! empty( $shopire_popular_product_ttl )  || ! empty( $shopire_popular_product_hs_tab )) : ?>
			<div class="wf-row align-items-center wf-mb-5">
				<div class="wf-col-lg-6 wf-col-md-8">
					<div class="section-title wf-text-md-left wf-text-center">
						 <?php if ( ! empty( $shopire_popular_product_ttl )) : ?>
							<h3 class="title"><?php echo wp_kses_post( $shopire_popular_product_ttl); ?></h3>
						<?php endif; ?>
					</div>
				</div>
				<div class="wf-col-lg-6 wf-col-md-4">
					<div class="wf-text-md-right wf-text-center wf-md-0 wf-mt-2">
						<?php if( $shopire_popular_product_hs_tab=='1'  && !empty($shopire_popular_product_cat) && !is_customize_preview() ):
							//$product_categories = get_terms( 'product_cat', $args );
							$count = count($shopire_popular_product_cat);
							if ( $count > 0 ) {
						?>
							<nav class="owl-filter-bar">
								<?php foreach ($shopire_popular_product_cat as $i=>$product_category) { 
									$product_cat_name = get_term_by('slug', $product_category, 'product_cat'); 
									$formatted_category = str_replace(' ', '-', strtolower($product_category));
									?>
								<?php if($i == 0){ ?>
									<a href="javascript:void(0);" class="item current" data-owl-filter=".product_cat-<?php echo esc_attr($formatted_category); ?>">
										<?php echo esc_html($product_cat_name->name); ?>
									</a>
									<?php }else{ ?>
									<a href="javascript:void(0);" class="item" data-owl-filter=".product_cat-<?php echo esc_attr($formatted_category); ?>">
										<?php echo esc_html($product_cat_name->name); ?>
									</a>
								<?php }} ?>
							</nav>
						<?php } endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="wf-row wf-g-4">
			<div class="wf-col-lg-12">
				<div class="woocommerce columns-4 ">
					<ul class="products columns-4">
						<?php
							$loop = new WP_Query( $args );
							while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
						<?php get_template_part('woocommerce/content','product'); ?>
						<?php endwhile; ?>
						<?php  wp_reset_postdata(); ?>
					</ul>
					<div id="loading-indicator" style="display: none;">
						<div class="spinner"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php }  endif; do_action('shopire_popular_product_option_after'); ?>