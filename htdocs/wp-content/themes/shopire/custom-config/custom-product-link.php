<?php
/**
 * Shopire主题产品轮播图链接配置文件
 * 用户可以在此文件中自定义产品轮播图右上角动态文本的链接URL
 * 
 * 使用说明：
 * 1. 修改下方的$custom_product_link变量值为您希望使用的链接
 * 2. 如需使用WooCommerce商店页面链接，保持默认值即可
 * 3. 链接格式必须为完整的URL格式（例如：https://example.com/shop）
 */

// 自定义产品轮播图链接
// 默认值为null，表示使用WooCommerce商店页面链接
// 您可以将其修改为任何有效的URL字符串
// $custom_product_link = "http://localhost/index.php/privacypolicy-cn/";
$custom_product_link = null;

/**
 * 获取自定义产品链接
 * 此函数供主题内部使用，请勿修改
 * 
 * @return string 产品链接URL
 */
function shopire_get_custom_product_link() {
    global $custom_product_link;
    
    // 如果用户设置了自定义链接，则使用该链接
    if (!empty($custom_product_link) && is_string($custom_product_link)) {
        return esc_url($custom_product_link);
    }
    
    // 否则，使用WooCommerce商店页面链接作为默认值
    $shop_page_id = wc_get_page_id('shop');
    if ($shop_page_id) {
        return get_permalink($shop_page_id);
    }
    
    // 如果WooCommerce未配置，返回首页链接
    return home_url('/');
}