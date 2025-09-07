<?php
/**
Template Name: Fullwidth Page
**/

get_header();
?>
<section class="wf-py-default">
	<div class="wf-container">
		<div class="wf-row wf-g-5">
			<div class="wf-col-lg-12 wf-col-md-12 wf-col-12 wow fadeInUp">
				<?php 		
					the_post(); the_content(); 
					
					if( $post->comment_status == 'open' ) { 
						 comments_template( '', true ); // show comments 
					}
				?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>

