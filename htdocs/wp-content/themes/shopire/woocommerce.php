<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Shopire
 */

get_header();
?>
<section class="woo-products wf-py-default">
	<div class="wf-container">
		<div class="wf-row wf-g-5">
			<?php if (  !is_active_sidebar( 'shopire-woocommerce-sidebar' ) ): ?>
				<div class="wf-col-lg-12 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php else: ?>	
				<div id="wf-main" class="wf-col-lg-8 wf-col-md-12 wf-col-12 wow fadeInUp">
			<?php endif; ?>	
				<?php woocommerce_content();  // WooCommerce Content ?>
			</div>
			<?php get_sidebar('woocommerce'); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>

