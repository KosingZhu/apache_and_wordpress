<?php
/**
 * WooCommerce 导入状态检查工具
 */

// 加载WordPress环境（修复路径 - 工具文件已移至woocommerce-tools目录）
require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );

// 检查用户权限
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( '您没有权限访问此页面。' );
}

// 获取当前设置
$memory_limit = ini_get( 'memory_limit' );
$max_execution_time = ini_get( 'max_execution_time' );
$post_max_size = ini_get( 'post_max_size' );
$upload_max_filesize = ini_get( 'upload_max_filesize' );

// 检查导入修复插件是否激活
$plugin_active = class_exists( 'WC_Product_Importer' ) && has_filter( 'woocommerce_product_importer_default_time_limit', 'woocommerce_fix_import_timeout' );

// 输出HTML页面
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>WooCommerce 导入状态检查</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        .card { background: #f9f9f9; border-radius: 5px; padding: 20px; margin-bottom: 20px; }
        h1, h2 { color: #23282d; }
        .success { color: #0073aa; }
        .error { color: #dc3232; }
        ul, ol { padding-left: 20px; }
    </style>
</head>
<body>
    <h1>WooCommerce 导入状态检查</h1>
    
    <div class="card">
        <h2>系统设置</h2>
        <ul>
            <li><strong>PHP 版本:</strong> <?php echo PHP_VERSION; ?></li>
            <li><strong>WordPress 版本:</strong> <?php echo get_bloginfo( 'version' ); ?></li>
            <li><strong>WooCommerce 版本:</strong> <?php echo class_exists( 'WC_VERSION' ) ? WC_VERSION : '未安装'; ?></li>
        </ul>
    </div>
    
    <div class="card">
        <h2>PHP 配置</h2>
        <ul>
            <li><strong>内存限制:</strong> <?php echo $memory_limit; ?></li>
            <li><strong>最大执行时间:</strong> <?php echo $max_execution_time; ?> 秒</li>
            <li><strong>POST 最大大小:</strong> <?php echo $post_max_size; ?></li>
            <li><strong>上传文件最大大小:</strong> <?php echo $upload_max_filesize; ?></li>
        </ul>
    </div>
    
    <div class="card">
        <h2>导入修复状态</h2>
        <p class="<?php echo $plugin_active ? 'success' : 'error'; ?>">
            <?php echo $plugin_active ? '✅ 导入修复插件已成功应用' : '❌ 导入修复插件未激活'; ?>
        </p>
        
        <?php if ( $plugin_active ) : ?>
        <p><strong>修复设置:</strong></p>
        <ul>
            <li>导入超时限制已增加到 300 秒 (5分钟)</li>
            <li>HTTP 请求超时已增加到 300 秒</li>
            <li>内存限制已增加到 512MB (如果系统允许)</li>
            <li>批处理大小已调整为 20</li>
        </ul>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>CSV 导入建议</h2>
        <ol>
            <li>确保你的 CSV 文件格式正确，特别是列标题与WooCommerce要求匹配</li>
            <li>对于大型CSV文件(超过1000行)，建议拆分为多个较小的文件</li>
            <li>检查CSV文件编码是否为UTF-8，避免特殊字符问题</li>
            <li>在导入前备份你的数据库，以防发生意外</li>
            <li>尝试在低流量时段进行导入操作，确保服务器有足够资源</li>
        </ol>
    </div>
    
    <div class="card">
        <h2>如果问题仍然存在</h2>
        <p>请尝试以下步骤:</p>
        <ol>
            <li>清除浏览器缓存和Cookie，然后重新登录WordPress</li>
            <li>尝试使用不同的浏览器进行导入操作</li>
            <li>暂时禁用其他插件，特别是可能与导入功能冲突的插件</li>
            <li>检查服务器错误日志，查找具体的错误信息</li>
            <li>如果使用共享主机，考虑升级到性能更好的主机方案</li>
        </ol>
    </div>
</body>
</html>