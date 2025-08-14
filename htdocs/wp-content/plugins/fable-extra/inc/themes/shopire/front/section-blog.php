<?php  
$shopire_blog_options_hide_show = get_theme_mod('shopire_blog_options_hide_show','1');
$shopire_blog_ttl		= get_theme_mod('shopire_blog_ttl','Blog & News'); 
$shopire_blog_subttl	= get_theme_mod('shopire_blog_subttl','Get Update Blog & News'); 
$shopire_blog_text		= get_theme_mod('shopire_blog_text','At worst the discussion is at least working towards the final goal of your site where questions about lorem ipsum don’t.'); 
$shopire_blog_column		= get_theme_mod('shopire_blog_column','3'); 
$shopire_blog_cat			= get_theme_mod('shopire_blog_cat'); 
$shopire_blog_num			= get_theme_mod('shopire_blog_num','4');
if($shopire_blog_options_hide_show=='1'): 
?>
<section id="wf_posts" class="wf_posts wf-py-default front-posts">
	<div class="wf-container">
		<?php if ( ! empty( $shopire_blog_ttl )  || ! empty( $shopire_blog_subttl ) || ! empty( $shopire_blog_text )) : ?>
			<div class="wf-row">
				<div class="wf-row justify-content-center">
					<div class="wf-col-lg-7">
						<div class="section-title wf-text-center wf-mb-6">
							<?php if ( ! empty( $shopire_blog_ttl ) ) : ?>
								<span class="sub-title"><?php echo wp_kses_post($shopire_blog_ttl); ?></span>
							<?php endif; ?>	
							
							<?php if ( ! empty( $shopire_blog_subttl ) ) : ?>
								<h2 class="title"><?php echo wp_kses_post($shopire_blog_subttl); ?></h2>
							<?php endif; ?>	
							<?php if ( ! empty( $shopire_blog_text ) ) : ?>
								<p class="wf-mb-2"><?php echo wp_kses_post($shopire_blog_text); ?></p>
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="wf-row wf-g-4">
			<?php 
				$shopire_post_args = array( 'post_type' => 'post', 'category__in' => $shopire_blog_cat, 'posts_per_page' => $shopire_blog_num,'post__not_in'=>get_option("sticky_posts")) ; 	
				
				$shopire_wp_query = new WP_Query($shopire_post_args);
				if($shopire_wp_query)
				{	
				$i = 0;
				while($shopire_wp_query->have_posts()):$shopire_wp_query->the_post();
			?>
				<div class="wf-col-lg-<?php echo esc_attr($shopire_blog_column); ?> wf-col-sm-6 wf-col-12 wow fadeInUp animated" data-wow-delay="<?php echo esc_attr(($i+1)*100); ?>ms" data-wow-duration="1500ms">
					<?php get_template_part('template-parts/content','page');  ?>
				</div>
			<?php $i=(int)$i + 1; endwhile; } wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>