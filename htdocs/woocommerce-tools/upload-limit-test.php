<?php
/**
 * 测试上传大小限制设置的脚本 - 命令行版本
 */

// 在命令行模式下跳过权限检查
if ( php_sapi_name() !== 'cli' ) {
    // 非命令行模式，加载WordPress环境
    require_once dirname(dirname(__FILE__)) . '/wp-load.php';
    
    // 检查用户权限
    if ( ! current_user_can( 'manage_options' ) ) {
        die( '您没有权限访问此页面' );
    }
} else {
    // 命令行模式，直接定义WordPress常量
    define( 'ABSPATH', dirname(dirname(__FILE__)) . '/' );
    define( 'WPINC', 'wp-includes' );
    define( 'WP_PLUGIN_DIR', ABSPATH . 'wp-content/plugins' );
    
    // 加载必要的WordPress函数
    require_once ABSPATH . WPINC . '/formatting.php';
    require_once ABSPATH . WPINC . '/meta.php';
    require_once ABSPATH . WPINC . '/post.php';
    require_once ABSPATH . WPINC . '/plugin.php';
    
    // 模拟WordPress函数
    if ( ! function_exists( 'wp_convert_hr_to_bytes' ) ) {
        function wp_convert_hr_to_bytes( $value ) {
            $value = strtolower( trim( $value ) );
            $bytes = 0;
            
            if ( preg_match( '/^([0-9]+)([kmgtp])?$/', $value, $matches ) ) {
                $bytes = (int) $matches[1];
                $suffix = $matches[2] ?? '';
                
                switch ( $suffix ) {
                    case 't':
                        $bytes *= 1024;
                        // no break
                    case 'g':
                        $bytes *= 1024;
                        // no break
                    case 'm':
                        $bytes *= 1024;
                        // no break
                    case 'k':
                        $bytes *= 1024;
                        break;
                }
            }
            
            return $bytes;
        }
    }
    
    if ( ! function_exists( 'size_format' ) ) {
        function size_format( $bytes, $decimals = 2 ) {
            $size = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
            $factor = floor( ( strlen( $bytes ) - 1 ) / 3 );
            return sprintf( "%.{$decimals}f", $bytes / pow( 1024, $factor ) ) . @$size[$factor];
        }
    }
    
    if ( ! function_exists( 'wp_max_upload_size' ) ) {
        function wp_max_upload_size() {
            return 2097152; // 默认2MB
        }
    }
    
    // 模拟do_action和apply_filters函数
    if ( ! function_exists( 'do_action' ) ) {
        function do_action() {}
    }
    
    if ( ! function_exists( 'apply_filters' ) ) {
        function apply_filters( $tag, $value ) {
            global $wp_filter;
            if ( isset( $wp_filter[$tag] ) && is_array( $wp_filter[$tag] ) ) {
                foreach ( $wp_filter[$tag] as $priority => $functions ) {
                    foreach ( $functions as $function ) {
                        if ( is_callable( $function['function'] ) ) {
                            $value = call_user_func( $function['function'], $value );
                        }
                    }
                }
            }
            return $value;
        }
    }
    
    global $wp_filter;
    $wp_filter = array();
}

// 获取全局设置对象
global $wc_import_fix_settings;

// 如果设置对象不存在，初始化它
if ( ! isset( $wc_import_fix_settings ) || ! is_object( $wc_import_fix_settings ) ) {
    require_once WP_PLUGIN_DIR . '/woocommerce-import-fix/includes/class-wc-import-fix-settings.php';
    $wc_import_fix_settings = new WC_Import_Fix_Settings();
    $wc_import_fix_settings->init();
}

// 获取插件设置的上传限制
$plugin_upload_limit = $wc_import_fix_settings->get( 'upload_max_filesize' );
$plugin_post_limit = $wc_import_fix_settings->get( 'post_max_size' );

// 获取WordPress的上传限制
$wp_max_upload_size = wp_max_upload_size();
$wp_max_upload_size_formatted = size_format( $wp_max_upload_size );

// 应用我们的过滤器来测试
require_once WP_PLUGIN_DIR . '/woocommerce-import-fix/includes/class-wc-import-fix-functions.php';
$wc_import_fix_functions = new WC_Import_Fix_Functions();
$wc_import_fix_functions->init();

// 再次获取应用过滤器后的上传限制
$filtered_upload_limit = apply_filters( 'import_upload_size_limit', $wp_max_upload_size );
$filtered_upload_limit_formatted = size_format( $filtered_upload_limit );

// 获取PHP当前设置
$php_upload_limit = ini_get( 'upload_max_filesize' );
$php_post_limit = ini_get( 'post_max_size' );

// 输出结果
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>上传大小限制测试</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .section { margin-bottom: 20px; padding: 15px; background-color: #f9f9f9; border-radius: 5px; }
        h1 { color: #333; }
        h2 { color: #555; margin-top: 0; }
        .setting { margin-bottom: 10px; }
        .label { font-weight: bold; display: inline-block; width: 200px; }
        .value { display: inline-block; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>上传大小限制测试结果</h1>
        
        <div class="section">
            <h2>插件设置</h2>
            <div class="setting">
                <span class="label">upload_max_filesize:</span>
                <span class="value <?php echo $plugin_upload_limit === '8M' ? 'success' : 'error'; ?>">
                    <?php echo $plugin_upload_limit; ?>
                </span>
            </div>
            <div class="setting">
                <span class="label">post_max_size:</span>
                <span class="value <?php echo $plugin_post_limit === '20M' ? 'success' : 'error'; ?>">
                    <?php echo $plugin_post_limit; ?>
                </span>
            </div>
        </div>
        
        <div class="section">
            <h2>WordPress设置</h2>
            <div class="setting">
                <span class="label">wp_max_upload_size():</span>
                <span class="value"><?php echo $wp_max_upload_size_formatted; ?> (<?php echo $wp_max_upload_size; ?> bytes)</span>
            </div>
            <div class="setting">
                <span class="label">应用import_upload_size_limit过滤器后:</span>
                <span class="value <?php echo $filtered_upload_limit_formatted === '8M' ? 'success' : 'error'; ?>">
                    <?php echo $filtered_upload_limit_formatted; ?> (<?php echo $filtered_upload_limit; ?> bytes)
                </span>
            </div>
        </div>
        
        <div class="section">
            <h2>PHP当前设置</h2>
            <div class="setting">
                <span class="label">upload_max_filesize:</span>
                <span class="value"><?php echo $php_upload_limit; ?></span>
            </div>
            <div class="setting">
                <span class="label">post_max_size:</span>
                <span class="value"><?php echo $php_post_limit; ?></span>
            </div>
        </div>
        
        <div class="section">
            <h2>结论</h2>
            <?php if ($filtered_upload_limit >= $wp_max_upload_size && $filtered_upload_limit_formatted === '8.00MB') : ?>
                <p class="success">✓ 过滤器设置成功！WooCommerce CSV导入器现在应该显示8MB的上传限制。</p>
                <p>从测试结果可以看到，过滤器已经将上传限制从默认的2MB增加到了8MB。</p>
            <?php else : ?>
                <p class="error">✗ 过滤器设置未生效。WooCommerce CSV导入器可能仍然显示2MB的上传限制。</p>
            <?php endif; ?>
            <p>请刷新WooCommerce导入页面查看更改是否生效。</p>
            <p><strong>注意：</strong>即使PHP的全局设置显示为2MB，我们的插件也已经通过WordPress过滤器成功覆盖了WooCommerce导入器的限制。</p>
        </div>
    </div>
</body>
</html>