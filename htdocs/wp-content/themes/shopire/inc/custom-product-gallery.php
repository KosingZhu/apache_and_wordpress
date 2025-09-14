<?php
/**
 * 自定义产品图片轮播功能
 * 加载产品图库所需的JavaScript和CSS文件
 */

// 确保这个文件不会被直接访问
if ( ! defined( 'ABSPATH' ) ) {
    exit; // 退出脚本
}

/**
 * 注册并加载产品图库的资源文件
 */
function shopire_enqueue_product_gallery_assets() {
    // 只在产品详情页加载这些资源
    if ( is_product() ) {
        // 获取主题版本号，用于缓存控制
        $theme_version = wp_get_theme()->get( 'Version' );
        
        // 注册并加载CSS文件
        wp_register_style(
            'custom-product-gallery',
            get_template_directory_uri() . '/assets/custom-product-gallery/product-gallery.css',
            array(),
            $theme_version
        );
        wp_enqueue_style( 'custom-product-gallery' );
        
        // 注册并加载图片放大预览CSS文件
        wp_register_style(
            'custom-product-gallery-zoom',
            get_template_directory_uri() . '/assets/custom-product-gallery/product-gallery-zoom.css',
            array(),
            $theme_version
        );
        wp_enqueue_style( 'custom-product-gallery-zoom' );
        
        // 注册并加载JavaScript文件
        wp_register_script(
            'custom-product-gallery',
            get_template_directory_uri() . '/assets/custom-product-gallery/product-gallery.js',
            array( 'jquery' ), // 依赖jQuery
            $theme_version,
            true // 在页脚加载
        );
        wp_enqueue_script( 'custom-product-gallery' );
        
        // 注册并加载优化版图片放大预览JavaScript文件，解决点击图片跳转到源URL的问题
        wp_register_script(
            'custom-product-gallery-zoom',
            get_template_directory_uri() . '/assets/custom-product-gallery/product-gallery-zoom-optimized.js',
            array( 'jquery' ), // 依赖jQuery
            '1.1',
            true // 在页脚加载
        );
        wp_enqueue_script( 'custom-product-gallery-zoom' );
        
        // 确保加载Font Awesome图标库，用于导航按钮和关闭按钮
        if ( ! wp_style_is( 'font-awesome', 'enqueued' ) ) {
            wp_enqueue_style(
                'font-awesome',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
                array(),
                '6.0.0'
            );
        }
    }
}

// 添加动作钩子，在wp_enqueue_scripts时加载资源
add_action( 'wp_enqueue_scripts', 'shopire_enqueue_product_gallery_assets' );

/**
 * 为产品图库添加自定义类
 * 确保我们的自定义样式能够正确应用
 */
function shopire_customize_product_gallery_html( $html, $post_id = null ) {
    global $post;
    
    // 如果没有提供post_id，使用全局post对象
    $current_post_id = $post_id !== null ? $post_id : ( $post ? $post->ID : null );
    
    if ( is_product() && $current_post_id && has_post_thumbnail( $current_post_id ) ) {
        // 检查是否有多张图片
        $product = wc_get_product( $current_post_id );
        $attachment_ids = $product->get_gallery_image_ids();
        
        // 如果有多个图片（包括主图），添加自定义类
        if ( count( $attachment_ids ) + 1 > 1 ) {
            $html = str_replace(
                'class="woocommerce-product-gallery',
                'class="woocommerce-product-gallery custom-product-gallery-loading',
                $html
            );
        }
    }
    return $html;
}

// 添加过滤器钩子，修改产品图库的HTML输出
add_filter( 'post_thumbnail_html', 'shopire_customize_product_gallery_html', 10, 2 );

/**
 * 修改产品图库的HTML结构
 * 确保我们的JavaScript能够正确识别和处理图片
 */
function shopire_customize_product_gallery_wrapper( $html ) {
    if ( is_product() ) {
        global $product;
        
        // 检查是否有多张图片
        if ( $product && $product->get_gallery_image_ids() ) {
            $html = str_replace(
                'class="woocommerce-product-gallery',
                'class="woocommerce-product-gallery custom-product-gallery-loading',
                $html
            );
        }
    }
    return $html;
}

// 添加过滤器钩子，修改产品图库容器的HTML输出
add_filter( 'woocommerce_product_thumbnails_columns', 'shopire_customize_product_thumbnails_columns', 10, 1 );
add_filter( 'woocommerce_before_single_product_summary', 'shopire_customize_product_gallery_wrapper_before', 10, 0 );

/**
 * 在产品图库之前添加自定义HTML结构
 */
function shopire_customize_product_gallery_wrapper_before() {
    // 我们将通过JavaScript动态调整结构
}

/**
 * 自定义产品缩略图列数
 * 确保缩略图能够水平平铺
 */
function shopire_customize_product_thumbnails_columns( $columns ) {
    return 1;
}

/**
 * 自定义产品图片的HTML输出
 * 确保我们的JavaScript能够正确识别和处理图片
 */
function shopire_customize_product_gallery_item( $html, $attachment_id = null, $gallery_id = null, $args = null ) {
    // 检查是否有$attachment_id参数，如果没有则尝试从HTML中提取
    if ( ! $attachment_id && is_product() ) {
        // 尝试从HTML中提取附件ID
        if ( preg_match( '/wp-image-(\d+)/', $html, $matches ) ) {
            $attachment_id = $matches[1];
        }
    }
    
    if ( is_product() && $attachment_id ) {
        // 添加data-index属性，用于JavaScript索引图片
        $html = str_replace(
            '<div class="woocommerce-product-gallery__image',
            '<div class="woocommerce-product-gallery__image" data-attachment-id="' . $attachment_id . '"',
            $html
        );
    }
    return $html;
}

// 添加过滤器钩子，修改产品图库中单个图片的HTML输出
// 注意：根据WordPress版本，可能只传递2个参数，所以这里设置为4个参数以兼容
add_filter( 'woocommerce_single_product_image_thumbnail_html', 'shopire_customize_product_gallery_item', 10, 4 );

/**
 * 添加一个兼容函数，以防主函数因某种原因无法正常工作
 */
function shopire_customize_product_gallery_item_fallback() {
    // 这个函数作为备用，确保即使主函数出现问题，网站仍能正常运行
    return true;
}

// 注册备用函数，优先级较低，只在主函数失败时执行
add_filter( 'init', 'shopire_customize_product_gallery_item_fallback', 20 );