<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopire
 */

get_header();
$shopire_default_pg_sidebar_option= get_theme_mod('shopire_default_pg_sidebar_option', 'right_sidebar'); 
?>
<section class="wf_posts wf-py-default">
	<div class="wf-container">
		<div class="wf-row wf-g-5">
			<?php if($shopire_default_pg_sidebar_option == 'left_sidebar'): 
					if ( class_exists( 'WooCommerce' ) ) {
						if( is_account_page() || is_cart() || is_checkout() ) {
							get_sidebar('woocommerce'); 
						}else{ 
							get_sidebar(); 
						}	
					}else{ 
						get_sidebar(); 
					}	
			endif; ?>
			<?php if($shopire_default_pg_sidebar_option == 'no_sidebar'): ?>
				<div class="wf-col-lg-12 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php else: ?>	
				<div id="wf-main" class="wf-col-lg-8 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php endif;		
					if( have_posts()) :  the_post(); ?>
				<div class="post single-post clear wf-mb-4">
			<?php	the_content(); ?> 
				</div>
			<?php endif;
					if( $post->comment_status == 'open' ) { 
						 comments_template( '', true ); // show comments 
					}
				?>
			</div>
			<?php if($shopire_default_pg_sidebar_option == 'right_sidebar'): 
					if ( class_exists( 'WooCommerce' ) ) {
						if( is_account_page() || is_cart() || is_checkout() ) {
							get_sidebar('woocommerce'); 
						}else{ 
							get_sidebar(); 
						}	
					}else{ 
						get_sidebar(); 
					}	
			endif; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>