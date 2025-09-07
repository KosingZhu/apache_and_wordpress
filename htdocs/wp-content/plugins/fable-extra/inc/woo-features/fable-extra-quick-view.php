<?php
/**
 * Fable Extra Quick View Callback
 */
add_action( 'wp_ajax_fable_extra_quick_view', 'fable_extra_quick_view_callback' );
add_action( 'wp_ajax_nopriv_fable_extra_quick_view', 'fable_extra_quick_view_callback' );

function fable_extra_quick_view_callback() {
    check_ajax_referer( 'my-special-string', 'security' );
    $fable_extra_product_d = intval( $_POST['fable_extra_product_d'] );

    if ( class_exists( 'woocommerce' ) ) {
        // Ensure we have a valid product ID
        $product = wc_get_product( $fable_extra_product_d );
        if ( ! $product ) {
            echo 'Invalid product';
            die();
        }

        $image_id = $product->get_image_id();
        $attachment_ids = $product->get_gallery_image_ids();
        ?>
        <div id="product-<?php echo esc_attr($fable_extra_product_d); ?>" class="quickview-product product">
            <div class="product-thumb img-thumbnail">
                <?php if ( $product->is_on_sale() ) : ?>
                    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale', 'fable-extra' ) . '</span>', $product ); ?>
                <?php endif; ?>

                <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">
                    <?php if ( ! empty( $attachment_ids ) ): ?>
                        <figure class="woocommerce-product-gallery__wrapper owl-carousel owl-theme">
                            <?php 
                            $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                            ?>
                            <div data-thumb="<?php echo esc_url( $image_url ); ?>" class="woocommerce-product-gallery__image">
                                <a href="<?php echo esc_url( $image_url ); ?>">
                                    <img src="<?php echo esc_url( $image_url ); ?>" class="wp-post-image" alt="" loading="lazy">
                                </a>
                            </div>

                            <?php foreach ( $attachment_ids as $attachment_id ) :
                                $image_url2 = wp_get_attachment_url( $attachment_id ); ?>
                                <div data-thumb="<?php echo esc_url( $image_url2 ); ?>" class="woocommerce-product-gallery__image">
                                    <a href="<?php echo esc_url( $image_url2 ); ?>">
                                        <img src="<?php echo esc_url( $image_url2 ); ?>" class="wp-post-image" alt="" loading="lazy">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </figure>

                        <ol class="product-control-nav owl-carousel owl-theme">
                            <?php foreach ( $attachment_ids as $attachment_id ) :
                                $image_url = wp_get_attachment_url( $attachment_id ); ?>
                                <li><img src="<?php echo esc_url( $image_url ); ?>" alt="Thumbnail"></li>
                            <?php endforeach; ?>
                        </ol>

                    <?php else: ?>
                        <figure class="woocommerce-product-gallery__wrapper owl-carousel owl-theme">
                            <?php $image_url = wp_get_attachment_image_url( $image_id, 'full' ); ?>
                            <div data-thumb="<?php echo esc_url( $image_url ); ?>" class="woocommerce-product-gallery__image">
                                <a href="<?php echo esc_url( $image_url ); ?>">
                                    <img src="<?php echo esc_url( $image_url ); ?>" class="wp-post-image" alt="" loading="lazy">
                                </a>
                            </div>
                        </figure>
                    <?php endif; ?>
                </div>
            </div>

            <div class="product-content entry-summary">
                <h1 class="product_title entry-title"><?php echo esc_html( $product->get_title() ); ?></h1>
                <p class="price"><?php echo $product->get_price_html(); ?></p>

                <div class="woocommerce-product-details__short-description">
                    <p><?php echo $product->get_short_description(); ?></p>
                </div>

                <div class="quickview-actions">
                    <form class="cart" method="post" enctype="multipart/form-data">
                        <div class="quantity">
                            <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Quantity" class="input-text qty text" size="4">
                        </div>
                        <button type="submit" data-quantity="1" data-product_id="<?php echo $fable_extra_product_d; ?>" class="button alt ajax_add_to_cart add_to_cart_button product_type_simple">
                            <?php esc_html_e( 'Add to cart', 'fable-extra' ); ?>
                        </button>
                    </form>

                    <div class="product_meta">
                        <?php
                        $terms = get_the_terms( $fable_extra_product_d, 'product_cat' );
                        if ( ! empty( $terms ) ) :
                            echo '<span class="posted_in">Category: ';
                            foreach ( $terms as $term ) {
                                echo '<a href="' . esc_url( get_term_link( $term ) ) . '" rel="tag">' . esc_html( $term->name ) . '</a> ';
                            }
                            echo '</span>';
                        endif;
                        ?>
                    </div>

                    <?php do_action( 'woocommerce_share' ); ?>
                </div>
            </div>
        </div>
        <?php
    }
    die(); // Required to return a proper result
}


if ( ! function_exists( 'fable_extra_quick_view' ) ) :
function fable_extra_quick_view() {
     if ( class_exists( 'woocommerce' ) ) {
         $args = array(
             'post_type' => 'product'
         );

         // Ensure the tax_query array is valid (check for null or undefined values)
         $tax_query = array();
         if ( isset( $args['tax_query'] ) && is_array( $args['tax_query'] ) ) {
             // Only add the tax query if it is valid
             $tax_query[] = array(
                 'taxonomy' => 'product_visibility',
                 'field'    => 'name',
                 'terms'    => 'exclude-from-catalog',
                 'operator' => 'NOT IN',
             );
         }
         $args['tax_query'] = $tax_query;

         ?>
         <div class="quickview-overlay">
             <div class="quickview-model-details">
                 <button class="quickview-close" role="button" type="button">
                     <i class="fas fa-close"></i>
                 </button>
                 <div id="theme-quickview-body" class="woocommerce single-product"></div>
             </div>
         </div>
         <?php
     }
 }
endif;
add_action( 'wp_footer', 'fable_extra_quick_view' );