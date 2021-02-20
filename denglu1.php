<?php

/**
    Plugin Name: denglu1
    Description: login by denglu1
    Author: Oah
    Version: 1.0
    Author URI: https://xshisme.github.io/
    License: GPLv3
 **/


require_once dirname(__FILE__) . '/denglu1-route.php';
require_once dirname(__FILE__) . '/denglu1-loginPage.php';
require_once dirname(__FILE__) . '/denglu1-settingsPage.php';
require_once dirname(__FILE__) . '/denglu1-log.php';


// 处理登录易的路由
add_action('init', 'denglu1_route');
// 在登陆页面添加登录易入口
add_action('login_footer', 'denglu1_add_button');
// 初始化设置页面
add_action('admin_menu', 'denglu1_settings_page_init');
// 初始化设置页面内容
add_action('admin_init', 'denglu1_settings_init');
// 激活时初始化日志文件
register_activation_hook(__FILE__, 'denglu1_init_logfile');
