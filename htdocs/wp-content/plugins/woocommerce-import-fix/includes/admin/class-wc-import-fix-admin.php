<?php
/**
 * WooCommerce Import Fix Admin Class
 *
 * 包含所有与管理相关的功能
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Import_Fix_Admin {
    
    /**
     * 初始化管理功能
     */
    public function init() {
        // 添加管理工具页面
        add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
        
        // 添加导入进度监控脚本
        add_action( 'admin_footer', array( $this, 'add_importer_script' ) );
    }
    
    /**
     * 添加一个管理工具页面，显示导入状态
     */
    public function add_admin_page() {
        // 添加到WooCommerce菜单下，更容易找到
        add_submenu_page(
            'woocommerce',
            'WooCommerce 导入修复',
            '导入修复',
            'manage_options',
            'woocommerce-import-fix',
            array( $this, 'admin_page_content' )
        );
    }
    
    /**
     * 管理页面内容
     */
    public function admin_page_content() {
        // 获取设置对象
        global $wc_import_fix_settings;
        
        // 获取当前设置（从插件设置中获取）
        $memory_limit = $wc_import_fix_settings->get( 'memory_limit' );
        $max_execution_time = $wc_import_fix_settings->get( 'max_execution_time' );
        $post_max_size = $wc_import_fix_settings->get( 'post_max_size' );
        $upload_max_filesize = $wc_import_fix_settings->get( 'upload_max_filesize' );
        
        // 检查WooCommerce状态
        $woocommerce_active = class_exists( 'WooCommerce' );
        $importer_available = class_exists( 'WC_Product_CSV_Importer' );
        
        ?>
        <div class="wrap">
            <h1>WooCommerce 导入修复工具</h1>
            
            <div class="card">
                <h2 class="title">系统状态</h2>
                <ul>
                    <li><strong>PHP 版本:</strong> <?php echo PHP_VERSION; ?></li>
                    <li><strong>WordPress 版本:</strong> <?php echo get_bloginfo( 'version' ); ?></li>
                    <li><strong>WooCommerce 状态:</strong> <?php echo $woocommerce_active ? '已激活' : '未激活'; ?></li>
                    <li><strong>CSV导入器:</strong> <?php echo $importer_available ? '可用' : '不可用'; ?></li>
                </ul>
            </div>
            
            <div class="card">
                <h2 class="title">当前设置</h2>
                <ul>
                    <li><strong>导入超时限制:</strong> 300秒 (5分钟)</li>
                    <li><strong>PHP最大执行时间:</strong> <?php echo $max_execution_time; ?> 秒</li>
                    <li><strong>内存限制:</strong> <?php echo $memory_limit; ?></li>
                    <li><strong>POST最大大小:</strong> <?php echo $post_max_size; ?></li>
                    <li><strong>上传文件最大大小:</strong> <?php echo $upload_max_filesize; ?></li>
                    <li><strong>批处理大小:</strong> 20</li>
                </ul>
            </div>
        </div>
        <?php
    }
    
    /**
     * 添加修复导入进度条卡住的JavaScript脚本
     */
    public function add_importer_script() {
        if ( isset( $_GET['page'] ) && 'product_importer' === $_GET['page'] ) {
            ?>
            <script>
            // 增强导入进度监控
            jQuery(document).ready(function($) {
                var lastProgress = 0;
                var stuckCounter = 0;
                
                // 监控导入进度
                setInterval(function() {
                    var progress = $('.woocommerce-importer-progress').val();
                    
                    if (progress && progress == lastProgress) {
                        stuckCounter++;
                        
                        // 如果进度在60秒内没有变化，尝试自动刷新或显示提示
                        if (stuckCounter >= 12) { // 12 * 5秒 = 60秒
                            $('.woocommerce-importer-progress').after('<div class="notice notice-info"><p>导入可能正在后台继续处理，请耐心等待。如长时间无响应，可以刷新页面重试。</p></div>');
                            stuckCounter = 0;
                        }
                    } else {
                        lastProgress = progress;
                        stuckCounter = 0;
                    }
                }, 5000); // 每5秒检查一次
            });
            </script>
            <?php
        }
    }
}