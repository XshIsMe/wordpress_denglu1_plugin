<?php

/**
    Plugin Name: denglu1-plugin
    Description: login by denglu1
    Author: Oah
    Version: 0.6
    Author URI: https://xshisme.github.io/
    License: GPLv3
 **/

require_once dirname(__FILE__) . '/denglu1-route.php';
require_once dirname(__FILE__) . '/util/denglu1-button.php';
require_once dirname(__FILE__) . '/util/denglu1-functions.php';
require_once dirname(__FILE__) . '/util/denglu1-settings-page.php';

// 处理登录易的路由
add_action('init', 'denglu1_route');
// 在登陆页面添加登录易入口
add_action('login_footer', 'add_denglu1_button');
// 添加登录易设置页面
add_action('admin_menu', 'add_denglu1_settings_page');
add_action('admin_init', 'denglu1_register_settings');
