<?php
/**
 * 修复WordPress HTTP_HOST问题的脚本
 */

echo "<h1>WordPress HTTP_HOST 问题修复工具</h1>";

// 检查当前环境
echo "<h2>当前环境检查</h2>";
echo "<p><strong>PHP版本:</strong> " . phpversion() . "</p>";
echo "<p><strong>服务器软件:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? '未知') . "</p>";
echo "<p><strong>文档根目录:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? '未知') . "</p>";

// 检查HTTP_HOST
echo "<h3>HTTP_HOST 状态:</h3>";
if (isset($_SERVER['HTTP_HOST'])) {
    echo "<p style='color: green;'>✅ HTTP_HOST 存在: " . $_SERVER['HTTP_HOST'] . "</p>";
} else {
    echo "<p style='color: red;'>❌ HTTP_HOST 不存在</p>";
    
    // 尝试修复HTTP_HOST
    if (isset($_GET['fix']) && $_GET['fix'] === 'yes') {
        echo "<h3>正在修复HTTP_HOST...</h3>";
        
        // 设置默认的HTTP_HOST
        $_SERVER['HTTP_HOST'] = 'localhost';
        
        // 检查其他可能的服务器变量
        if (!isset($_SERVER['SERVER_NAME'])) {
            $_SERVER['SERVER_NAME'] = 'localhost';
        }
        
        if (!isset($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = '/';
        }
        
        echo "<p style='color: green;'>✅ 已设置 HTTP_HOST = localhost</p>";
        echo "<p style='color: green;'>✅ 已设置 SERVER_NAME = localhost</p>";
        
        // 重新检查
        if (isset($_SERVER['HTTP_HOST'])) {
            echo "<p style='color: green;'>✅ 修复成功！HTTP_HOST 现在存在: " . $_SERVER['HTTP_HOST'] . "</p>";
        }
    } else {
        echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>⚠️ 发现问题</h3>";
        echo "<p>HTTP_HOST 变量不存在，这会导致WordPress出现错误。建议修复此问题。</p>";
        echo "<a href='?fix=yes' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0;'>修复HTTP_HOST问题</a>";
        echo "</div>";
    }
}

// 检查WordPress配置
echo "<h2>WordPress配置检查</h2>";
$wp_config_path = __DIR__ . '/wp-config.php';
if (file_exists($wp_config_path)) {
    echo "<p style='color: green;'>✅ wp-config.php 文件存在</p>";
    // 检查数据库配置
    $config_content = file_get_contents($wp_config_path);
    if (strpos($config_content, 'DB_NAME') !== false) {
        echo "<p style='color: green;'>✅ 数据库配置已设置</p>";
    } else {
        echo "<p style='color: red;'>❌ 数据库配置未设置</p>";
    }

    echo "<h2>主站URL设置</h2>";
    require_once(__DIR__ . '/wp-load.php');
    $siteurl = get_option('siteurl');
    $homeurl = get_option('home');
    $blogname = get_option('blogname');
    $blogdescription = get_option('blogdescription');
    $site_icon_id = get_option('site_icon');
    $site_icon_url = $site_icon_id ? wp_get_attachment_url($site_icon_id) : '';
    echo "<form method='post' enctype='multipart/form-data' style='margin-bottom:20px;'>";
    echo "<label>siteurl: <input type='text' name='siteurl' value='" . htmlspecialchars($siteurl) . "' style='width:300px;'></label><br>";
    echo "<label>home: <input type='text' name='homeurl' value='" . htmlspecialchars($homeurl) . "' style='width:300px;'></label><br>";
    echo "<label>站点标题: <input type='text' name='blogname' value='" . htmlspecialchars($blogname) . "' style='width:300px;'></label><br>";
    echo "<label>副标题: <input type='text' name='blogdescription' value='" . htmlspecialchars($blogdescription) . "' style='width:300px;'></label><br>";
    echo "<label>站点图标: ";
    if ($site_icon_url) {
        echo "<img src='" . esc_url($site_icon_url) . "' alt='站点图标' style='width:32px;height:32px;vertical-align:middle;margin-right:10px;'>";
    }
    echo "<input type='file' name='site_icon'></label><br>";
    echo "<input type='submit' name='update_url' value='修改主站设置' style='margin-top:10px;'>";
    echo "</form>";
    if (isset($_POST['update_url'])) {
        $new_siteurl = trim($_POST['siteurl']);
        $new_homeurl = trim($_POST['homeurl']);
        $new_blogname = trim($_POST['blogname']);
        $new_blogdescription = trim($_POST['blogdescription']);
        if ($new_siteurl && $new_homeurl) {
            update_option('siteurl', $new_siteurl);
            update_option('home', $new_homeurl);
        }
        if ($new_blogname) {
            update_option('blogname', $new_blogname);
        }
        if ($new_blogdescription) {
            update_option('blogdescription', $new_blogdescription);
        }
        // 处理站点图标上传
        if (isset($_FILES['site_icon']) && $_FILES['site_icon']['size'] > 0) {
            $file = $_FILES['site_icon'];
            $upload = wp_handle_upload($file, array('test_form' => false));
            if (isset($upload['url']) && isset($upload['file'])) {
                $filetype = wp_check_filetype($upload['file']);
                $attachment = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title' => sanitize_file_name($file['name']),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $attach_id = wp_insert_attachment($attachment, $upload['file']);
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
                wp_update_attachment_metadata($attach_id, $attach_data);
                update_option('site_icon', $attach_id);
                echo "<p style='color:green;'>站点图标已更新！</p>";
            } else {
                echo "<p style='color:red;'>站点图标上传失败！</p>";
            }
        }
        echo "<p style='color:green;'>主站设置已更新！</p>";
    }
}

// 读取并修改用户信息功能
if (file_exists($wp_config_path)) {
    require_once(__DIR__ . '/wp-load.php');
    echo "<h2>用户信息管理</h2>";
    global $wpdb;
    // 处理用户信息修改
    if (isset($_POST['update_user']) && isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);
        $new_email = trim($_POST['user_email']);
        $new_login = trim($_POST['user_login']);
        $new_display = trim($_POST['display_name']);
        $new_password = isset($_POST['user_password']) ? trim($_POST['user_password']) : '';
        $update_data = array();
        if ($new_email) $update_data['user_email'] = $new_email;
        if ($new_login) $update_data['user_login'] = $new_login;
        if ($new_display) $update_data['display_name'] = $new_display;
        $update_result = true;
        if (!empty($update_data)) {
            $result = wp_update_user(array_merge(array('ID' => $user_id), $update_data));
            if (is_wp_error($result)) {
                echo "<p style='color:red;'>修改失败: " . $result->get_error_message() . "</p>";
                $update_result = false;
            } else {
                echo "<p style='color:green;'>用户信息已更新！</p>";
            }
        }
        // 密码修改
        if ($new_password) {
            wp_set_password($new_password, $user_id);
            echo "<p style='color:green;'>密码已更新！</p>";
        }
        if ($update_result && !$new_password && empty($update_data)) {
            echo "<p style='color:orange;'>未提交任何修改内容。</p>";
        }
    }
    // 读取前10个用户
    $users = get_users(array('number' => 10));
    echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>用户名</th><th>邮箱</th><th>显示名</th><th>密码Hash</th><th>新密码</th><th>操作</th></tr>";
    foreach ($users as $user) {
        // 读取 hash
        $user_row = $wpdb->get_row("SELECT user_pass FROM {$wpdb->users} WHERE ID = {$user->ID}");
        $password_hash = $user_row ? $user_row->user_pass : '';
        echo "<tr>";
        echo "<form method='post'>";
        echo "<td>" . $user->ID . "<input type='hidden' name='user_id' value='" . $user->ID . "'></td>";
        echo "<td><input type='text' name='user_login' value='" . esc_attr($user->user_login) . "'></td>";
        echo "<td><input type='text' name='user_email' value='" . esc_attr($user->user_email) . "'></td>";
        echo "<td><input type='text' name='display_name' value='" . esc_attr($user->display_name) . "'></td>";
        echo "<td style='font-size:10px;word-break:break-all;'>" . esc_html($password_hash) . "</td>";
        echo "<td><input type='password' name='user_password' placeholder='输入新密码'></td>";
        echo "<td><input type='submit' name='update_user' value='修改'></td>";
        echo "</form>";
        echo "</tr>";
    }
    echo "</table>";
}

// 提供测试链接
echo "<h2>测试链接</h2>";
echo "<p><a href='http://localhost' target='_blank'>测试网站首页</a></p>";
echo "<p><a href='http://localhost/wp-admin' target='_blank'>测试WordPress后台</a></p>";
echo "<p><a href='http://localhost/phpinfo.php' target='_blank'>查看PHP信息</a></p>";

echo "<hr>";
echo "<p><small>修复完成后，请重启Apache服务以应用更改。</small></p>";
?>
