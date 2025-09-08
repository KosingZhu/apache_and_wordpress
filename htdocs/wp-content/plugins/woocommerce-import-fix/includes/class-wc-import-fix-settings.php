<?php
/**
 * WooCommerce Import Fix Settings Class
 *
 * 管理插件的设置和配置
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Import_Fix_Settings {
    
    /**
     * 设置选项
     */
    private $settings = array();
    
    /**
     * 初始化设置
     */
    public function init() {
        // 定义默认设置
        $this->settings = array(
            'import_timeout'        => 300, // 秒
            'memory_limit'          => '512M',
            'upload_max_filesize'   => '8M',  // 根据用户要求调整为8M
            'post_max_size'         => '20M', // 根据用户要求调整为20M
            'max_execution_time'    => 300, // 秒
            'max_input_time'        => 300, // 秒
            'batch_size'            => 20,
        );
        
        // 注册设置
        $this->register_settings();
    }
    
    /**
     * 注册设置
     */
    private function register_settings() {
        // 在需要时注册WordPress设置
    }
    
    /**
     * 获取设置值
     */
    public function get( $key, $default = null ) {
        return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : $default;
    }
    
    /**
     * 设置设置值
     */
    public function set( $key, $value ) {
        $this->settings[ $key ] = $value;
    }
}