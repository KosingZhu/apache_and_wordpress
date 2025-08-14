<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopire
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
			<?php endif; ?>
				<?php if( have_posts() ): ?>
					<div class="wf-row">
						<?php 
						// Start the loop.
						while( have_posts() ) : the_post(); ?>
							<div class="wf-col-lg-4 wf-col-md-12 wf-col-12">
								<div class="wf_post_block wow fadeInUp animated" data-wow-delay="100ms" data-wow-duration="1500ms">
									<?php get_template_part('template-parts/content','page'); ?>
								</div>
							</div>
						<?php endwhile; ?>						
					</div>	
					<?php  // Pagination.
						the_posts_pagination( array(
							'prev_text'          => '<i class="fa fa-angle-double-left"></i>',
							'next_text'          => '<i class="fa fa-angle-double-right"></i>'
						) );
						
						// If no content, include the "No posts found" template.
				 else: 
					 get_template_part('template-parts/content','none'); 
				 endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
