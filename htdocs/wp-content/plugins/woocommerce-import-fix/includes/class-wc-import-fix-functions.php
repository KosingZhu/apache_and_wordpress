<?php
/**
 * WooCommerce Import Fix Functions Class
 *
 * 包含所有修复功能的主要逻辑
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Import_Fix_Functions {
    
    /**
     * 设置对象
     */
    private $settings = null;
    
    /**
     * 初始化功能
     */
    public function init() {
        // 获取设置对象
        global $wc_import_fix_settings;
        $this->settings = $wc_import_fix_settings;
        
        // 添加过滤器和动作
        $this->add_filters_actions();
    }
    
    /**
     * 添加过滤器和动作
     */
    private function add_filters_actions() {
        // 增加WooCommerce CSV导入器的超时限制
        add_filter( 'woocommerce_product_importer_default_time_limit', array( $this, 'fix_import_timeout' ) );
        
        // 增加HTTP请求超时限制
        add_filter( 'http_request_timeout', array( $this, 'fix_request_timeout' ) );
        
        // 增加PHP内存限制和上传限制
        add_action( 'init', array( $this, 'increase_limits' ) );
        add_action( 'admin_init', array( $this, 'increase_limits' ) );
        
        // 增加WooCommerce导入器的批处理大小
        add_filter( 'woocommerce_product_import_batch_size', array( $this, 'fix_import_batch_size' ) );
        
        // 确保WooCommerce导入器正确加载
        add_action( 'init', array( $this, 'ensure_importer_loaded' ) );
        
        // 增加CSV导入文件大小限制
        add_filter( 'import_upload_size_limit', array( $this, 'fix_import_upload_size_limit' ) );
    }
    
    /**
     * 增加WooCommerce CSV导入器的超时限制
     */
    public function fix_import_timeout( $timeout ) {
        return $this->settings->get( 'import_timeout' );
    }
    
    /**
     * 增加HTTP请求超时限制
     */
    public function fix_request_timeout( $timeout ) {
        return $this->settings->get( 'import_timeout' );
    }
    
    /**
     * 增加PHP内存限制和上传限制
     */
    public function increase_limits() {
        if ( function_exists( 'ini_set' ) ) {
            // 增加内存限制
            $memory_limit = $this->settings->get( 'memory_limit' );
            $current_limit = ini_get( 'memory_limit' );
            $current_value = wp_convert_hr_to_bytes( $current_limit );
            $target_value = wp_convert_hr_to_bytes( $memory_limit );
            
            if ( $current_value < $target_value ) {
                ini_set( 'memory_limit', $memory_limit );
            }
            
            // 增加上传文件大小限制
            ini_set( 'upload_max_filesize', $this->settings->get( 'upload_max_filesize' ) );
            ini_set( 'post_max_size', $this->settings->get( 'post_max_size' ) );
            ini_set( 'max_execution_time', $this->settings->get( 'max_execution_time' ) );
            ini_set( 'max_input_time', $this->settings->get( 'max_input_time' ) );
        }
    }
    
    /**
     * 增加WooCommerce导入器的批处理大小
     */
    public function fix_import_batch_size( $batch_size ) {
        return $this->settings->get( 'batch_size' );
    }
    
    /**
     * 确保WooCommerce导入器正确加载
     */
    public function ensure_importer_loaded() {
        if ( ! class_exists( 'WC_Product_CSV_Importer' ) && file_exists( WP_PLUGIN_DIR . '/woocommerce/includes/import/class-wc-product-csv-importer.php' ) ) {
            include_once WP_PLUGIN_DIR . '/woocommerce/includes/import/class-wc-product-csv-importer.php';
        }
    }
    
    /**
     * 增加CSV导入文件大小限制
     * 
     * @param int $bytes 当前的字节限制
     * @return int 修改后的字节限制
     */
    public function fix_import_upload_size_limit( $bytes ) {
        // 获取设置的上传文件大小
        $upload_max_filesize = $this->settings->get( 'upload_max_filesize' );
        
        // 将设置值转换为字节
        $target_bytes = wp_convert_hr_to_bytes( $upload_max_filesize );
        
        // 如果我们的设置值大于当前值，则返回我们的设置值
        return max( $bytes, $target_bytes );
    }
}