<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */


defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php wc_product_class( '', $product ); ?>>
	<div class="product">
		<div class="product-single">
			<div class="product-img">
				<?php
					/**
					 * Hook: woocommerce_before_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_open - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item' );
					
					
					/**
					 * Hook: woocommerce_before_shop_loop_item_title.
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
				<?php
				$attachment_ids = $product->get_gallery_image_ids();
				$image_found = false;

				if( !empty( $attachment_ids ) ):
					foreach( $attachment_ids as $i => $attachment_id ) {
						$image_url2 = wp_get_attachment_url( $attachment_id );
						if( $i == 0 && !empty( $image_url2 ) ):
							$image_found = true;
							?>
							<a href="<?php echo esc_url(get_the_permalink()); ?>">
								<img width="801" height="801" src="<?php echo esc_url($image_url2); ?>" class="info attachment-post-thumbnail size-post-thumbnail wp-post-image" />
							</a>
							<?php
							break; // Exit the loop after the first image is found
						endif;
					}
				endif;

				if ( !$image_found ):
					$thumbnail_url = get_the_post_thumbnail_url();
					if ( !empty( $thumbnail_url ) ):
						?>
						<a href="<?php echo esc_url(get_the_permalink()); ?>">
							<img width="801" height="801" src="<?php echo esc_url($thumbnail_url); ?>" class="info attachment-post-thumbnail size-post-thumbnail wp-post-image" />
						</a>
						<?php
					endif;
				endif;
				?>
				<a href="javascript:void(0)" class="button quickview-trigger" data-product_id="<?php echo esc_attr($product->get_id()); ?>"><?php esc_html_e('Quick View','shopire'); ?></a>
			</div>
			<div class="product-content-outer">
				<div class="product-content">
					<h3><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h3>
					<?php 
					$product_instance = wc_get_product($product);
					echo $product_instance->get_short_description(); 
					?>
					<!--div class="price"-->
					<?php  
						do_action( 'woocommerce_after_shop_loop_item_title' ); 
					?>
					<!--/div-->
					<div class="pro-rating"></div>
				</div>
				<div class="product-action">
					<?php
					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					 do_action('fable_extra_woocompare_add_button_loop');
					 do_action( 'woocommerce_after_shop_loop_item' );
					 do_action('fable_extra_woowishlist_add_button_loop'); 
					?>
				</div>
			</div>
		</div>
	</div>
</li>
