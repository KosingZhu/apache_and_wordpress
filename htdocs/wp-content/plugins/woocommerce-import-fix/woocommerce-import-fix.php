<?php
/**
 * Plugin Name: WooCommerce Import Fix
 * Description: Fixes WooCommerce CSV import stuck issue by increasing timeout, memory and upload limits
 * Version: 1.1
 * Author: System
 */

// 防止直接访问
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 定义插件路径
define( 'WC_IMPORT_FIX_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// 引入必要的文件
require_once WC_IMPORT_FIX_PLUGIN_DIR . 'includes/class-wc-import-fix-settings.php';
require_once WC_IMPORT_FIX_PLUGIN_DIR . 'includes/class-wc-import-fix-functions.php';
require_once WC_IMPORT_FIX_PLUGIN_DIR . 'includes/admin/class-wc-import-fix-admin.php';

// 初始化插件
function wc_import_fix_init() {
    // 声明为全局变量，以便其他类可以访问
    global $wc_import_fix_settings;
    
    // 初始化设置类
    $wc_import_fix_settings = new WC_Import_Fix_Settings();
    $wc_import_fix_settings->init();
    
    // 初始化功能类
    $wc_import_fix_functions = new WC_Import_Fix_Functions();
    $wc_import_fix_functions->init();
    
    // 初始化管理类
    if ( is_admin() ) {
        $wc_import_fix_admin = new WC_Import_Fix_Admin();
        $wc_import_fix_admin->init();
    }
}
add_action( 'plugins_loaded', 'wc_import_fix_init' );