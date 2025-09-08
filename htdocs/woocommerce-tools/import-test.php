<?php
/**
 * 简单的导入环境测试脚本
 * 用于验证WooCommerce导入修复是否正确应用
 */

// 显示所有错误（仅用于测试）
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

// 加载WordPress环境（修复路径 - 工具文件已移至woocommerce-tools目录）
if ( file_exists( dirname( dirname( __FILE__ ) ) . '/wp-load.php' ) ) {
    require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );
}

// 获取当前配置
$memory_limit = ini_get( 'memory_limit' );
$max_execution_time = ini_get( 'max_execution_time' );
$post_max_size = ini_get( 'post_max_size' );
$upload_max_filesize = ini_get( 'upload_max_filesize' );
$max_input_time = ini_get( 'max_input_time' );

// 检查修复插件是否加载
$timeout_filter = has_filter( 'woocommerce_product_importer_default_time_limit', 'woocommerce_fix_import_timeout' );
$batch_filter = has_filter( 'woocommerce_product_import_batch_size', 'woocommerce_fix_import_batch_size' );

// 检查WooCommerce相关类是否存在
$wc_active = class_exists( 'WooCommerce' );
$importer_available = class_exists( 'WC_Product_CSV_Importer' );

// 输出HTML格式的结果
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>WooCommerce 导入环境测试</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: #2c3e50; }
        .status-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px; }
        .status-card { background: #f9f9f9; border-radius: 8px; padding: 20px; }
        .status-card h2 { margin-top: 0; color: #34495e; font-size: 18px; }
        .status-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
        .status-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .status-label { font-weight: bold; }
        .status-value { color: #7f8c8d; }
        .status-good { color: #27ae60; }
        .status-warning { color: #f39c12; }
        .status-error { color: #e74c3c; }
        .recommendations { margin-top: 30px; background: #ecf0f1; padding: 20px; border-radius: 8px; }
        .recommendations h2 { margin-top: 0; }
        .recommendations ul { padding-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>WooCommerce 导入环境测试</h1>
        
        <div class="status-grid">
            <div class="status-card">
                <h2>PHP 配置</h2>
                <div class="status-item">
                    <span class="status-label">内存限制:</span>
                    <span class="status-value <?php echo wp_convert_hr_to_bytes( $memory_limit ) >= 256 * 1024 * 1024 ? 'status-good' : 'status-warning'; ?>">
                        <?php echo $memory_limit; ?>
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">最大执行时间:</span>
                    <span class="status-value <?php echo $max_execution_time >= 120 ? 'status-good' : 'status-warning'; ?>">
                        <?php echo $max_execution_time; ?> 秒
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">最大输入时间:</span>
                    <span class="status-value <?php echo $max_input_time >= 120 ? 'status-good' : 'status-warning'; ?>">
                        <?php echo $max_input_time; ?> 秒
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">POST 最大大小:</span>
                    <span class="status-value <?php echo wp_convert_hr_to_bytes( $post_max_size ) >= 16 * 1024 * 1024 ? 'status-good' : 'status-warning'; ?>">
                        <?php echo $post_max_size; ?>
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">上传文件最大大小:</span>
                    <span class="status-value <?php echo wp_convert_hr_to_bytes( $upload_max_filesize ) >= 16 * 1024 * 1024 ? 'status-good' : 'status-warning'; ?>">
                        <?php echo $upload_max_filesize; ?>
                    </span>
                </div>
            </div>
            
            <div class="status-card">
                <h2>修复插件状态</h2>
                <div class="status-item">
                    <span class="status-label">WooCommerce 激活:</span>
                    <span class="status-value <?php echo $wc_active ? 'status-good' : 'status-error'; ?>">
                        <?php echo $wc_active ? '是' : '否'; ?>
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">CSV导入器可用:</span>
                    <span class="status-value <?php echo $importer_available ? 'status-good' : 'status-error'; ?>">
                        <?php echo $importer_available ? '是' : '否'; ?>
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">超时修复应用:</span>
                    <span class="status-value <?php echo $timeout_filter ? 'status-good' : 'status-error'; ?>">
                        <?php echo $timeout_filter ? '是' : '否'; ?>
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">批处理大小修复:</span>
                    <span class="status-value <?php echo $batch_filter ? 'status-good' : 'status-error'; ?>">
                        <?php echo $batch_filter ? '是' : '否'; ?>
                    </span>
                </div>
                <div class="status-item">
                    <span class="status-label">修复插件版本:</span>
                    <span class="status-value status-good">1.1</span>
                </div>
            </div>
        </div>
        
        <div class="recommendations">
            <h2>CSV导入建议</h2>
            <ul>
                <li>确保你的CSV文件格式正确，特别是列标题与WooCommerce要求匹配</li>
                <li>对于大型CSV文件，建议拆分为多个较小的文件（每个文件不超过1000行）</li>
                <li>检查CSV文件编码是否为UTF-8，避免特殊字符导致的导入错误</li>
                <li>在导入前备份你的数据库，以防发生意外</li>
                <li>导入过程中保持浏览器窗口打开，不要刷新页面</li>
                <li>如果导入过程中出现问题，可以尝试刷新页面后使用"更新现有产品"选项继续</li>
                <li>在WordPress管理后台可以找到"WooCommerce 导入修复"工具页面，提供更详细的导入指南</li>
            </ul>
        </div>
    </div>
</body>
</html>