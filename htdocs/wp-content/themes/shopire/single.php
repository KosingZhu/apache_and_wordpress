<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shopire
 */

get_header();
$shopire_enable_post_cat		= get_theme_mod('shopire_enable_post_cat','1'); 
$shopire_enable_post_date		= get_theme_mod('shopire_enable_post_date','1'); 
$shopire_enable_post_author		= get_theme_mod('shopire_enable_post_author','1'); 
$shopire_enable_post_comments	= get_theme_mod('shopire_enable_post_comments'); 
$shopire_enable_post_views		= get_theme_mod('shopire_enable_post_views'); 
$shopire_enable_post_rt			= get_theme_mod('shopire_enable_post_rt'); 
$shopire_enable_post_tag		= get_theme_mod('shopire_enable_post_tag'); 
$shopire_enable_post_ttl		= get_theme_mod('shopire_enable_post_ttl','1'); 
?>
<section id="wf_posts" class="wf_posts wf-py-default">
	<div class="wf-container">
		<div class="wf-row wf-g-4">
			<?php if (  !is_active_sidebar( 'shopire-sidebar-primary' ) ): ?>
				<div class="wf-col-lg-12 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php else: ?>	
				<div id="wf-main" class="wf-col-lg-8 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php endif; ?>	
				<div class="wf-row wf-g-4">
					<div class="wf-col-lg-12 wf-col-sm-12 wf-col-12"> 
						<?php 
							if( have_posts() ): 
							// Start the loop.
							while( have_posts() ): the_post();
						?>
						<article class="post single-post wf-mb-4">
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="image">
									<?php the_post_thumbnail(); ?>
									<a href="<?php echo esc_url( get_permalink() ); ?>"></a>
								</div>
							<?php } ?>
							
							<div class="inner">
								<?php     
									if($shopire_enable_post_ttl=='1'):
										the_title('<h3 class="title">', '</h3>' );
									endif; 
								?> 
								<div class="meta">
									<ul>    
										<?php if($shopire_enable_post_date=='1'): ?>
											<li>
												<div class="date">
													<i class="far fa-calendar" aria-hidden="true"></i> 
													<?php echo esc_html(get_the_date('M, d, Y')); ?>
												</div>
											</li>
										<?php endif; ?>	
										
										<?php if($shopire_enable_post_author=='1'): ?>
											<li>
												<div class="author">                                                    
													<i class="far fa-user" aria-hidden="true"></i>
													<a href="<?php echo esc_url(get_author_posts_url( absint(get_the_author_meta( 'ID' )) ));?>"><span><?php esc_html(the_author()); ?></span></a>
												</div>
											</li>
										<?php endif; ?>	
										
										<?php if($shopire_enable_post_cat=='1'): ?>
											<li>
												<div class="catetag">
													<i class="far fa-tags"></i>
													<a href="<?php echo esc_url( get_permalink() ); ?>" rel="category tag"><?php the_category(' , '); ?></a>
												</div>
											</li>
										<?php endif; ?>
										
										<?php if($shopire_enable_post_comments=='1'): ?>
											<li><i class="far fa-comments"></i> <?php echo esc_html(get_comments_number($post->ID)); ?></li>
										<?php endif; ?>	
										
										<?php if($shopire_enable_post_views=='1'): ?>
											<li><i class="far fa-eye"></i> <?php echo wp_kses_post(shopire_get_post_view(get_the_ID())); ?></li>
										<?php endif; ?>	
										
										<?php if($shopire_enable_post_rt=='1'): ?>
											<li><i class="fa-solid fa-eye"></i> <?php echo esc_html(shopire_read_time()); ?></li>
										<?php endif; ?>
									</ul>
								</div>
								<div class="content clear">
									<?php the_content(); ?>
								</div>
							</div>
						</article>
						<?php 
							endwhile; // End the loop.
							endif; 
						?>
						<div class="wf-row nextprev-post-wrapper">
							<?php
							  the_post_navigation(array(
								'prev_text' => '<div class="nextprev-post prev"><h5 class="post-title"><i class="fas fa-angle-left"></i> %title </h5></div>',
								'next_text' => '<div class="nextprev-post prev"><h5 class="post-title"> %title <i class="fas fa-angle-right"></i></h5></div>',
								'in_same_term' => true,
							  ));
							?>
						</div>
					</div>
						<?php comments_template( '', true ); // show comments  ?>
					</div>
				</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
