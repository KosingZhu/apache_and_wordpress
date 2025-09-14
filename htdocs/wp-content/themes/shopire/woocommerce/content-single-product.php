<?php
/**
 * 自定义产品内容模板 - 覆盖WooCommerce默认模板
 * 将图片展示区域和产品概述区域整合到同一个容器内
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // 退出脚本
}

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    // 创建产品主内容容器，整合图片区和描述区
    echo '<div class="product-main-content-container">';
    
    // 输出产品图片区（通过woocommerce_before_single_product_summary钩子）
    do_action( 'woocommerce_before_single_product_summary' );
    
    ?>

    <div class="summary entry-summary">
        <?php
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        do_action( 'woocommerce_single_product_summary' );
        ?>
    </div>
    
    <?php
    // 关闭产品主内容容器
    echo '</div>';
    
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action( 'woocommerce_after_single_product_summary' );
    ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>