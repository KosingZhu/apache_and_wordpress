<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Shopire
 */

get_header();
?>
<section class="wf_posts wf-py-default">
	<div class="wf-container">
		<div class="wf-row wf-g-5">
			<?php if (  !is_active_sidebar( 'shopire-sidebar-primary' ) ): ?>
				<div class="wf-col-lg-12 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php else: ?>	
				<div id="wf-main" class="wf-col-lg-8 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php endif;
				if( have_posts() ):
					/* Start the Loop */
					 while( have_posts() ) : the_post();?>
						<div class="wf_post_block wow fadeInUp animated" data-wow-delay="100ms" data-wow-duration="1500ms">
							<?php get_template_part('template-parts/content','page'); ?>
						</div>
					<?php endwhile; 
					/* End the Loop */
					
					/* Post Navigation */
					the_posts_navigation();
					 else: get_template_part('template-parts/content','none'); 
			    endif; 
				?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
