<?php
/*
Plugin Name: 全局共享函数库
Description: 存放网站全局可用的共享函数
Version: 1.0
Author: kosing
*/

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

function my_log_error($message, $level = 'notice') {
    $debug_backtrace = debug_backtrace();
    $caller = $debug_backtrace[0];
    $file = $caller['file'];
    $line = $caller['line'];
    
    $log_message = "[$level] " . date('Y-m-d H:i:s') . " - $message " 
                 . "(File: " . basename($file) . ", Line: $line)\n";
    
    error_log($log_message);
}