<?php

/**
    Plugin Name: denglu1
    Description: login by denglu1
    Author: Oah
    Version: 1.0
    Author URI: https://xshisme.github.io/
    License: GPLv3
 **/


// 导入
require_once dirname(__FILE__) . '/Api/Denglu1ApiRouter.class.php';
require_once dirname(__FILE__) . '/View/Denglu1LoginPage.class.php';
require_once dirname(__FILE__) . '/View/Denglu1SettingsPage.class.php';
require_once dirname(__FILE__) . '/Log/Denglu1LogDB.class.php';
require_once dirname(__FILE__) . '/Log/Denglu1Log.class.php';
// 处理登录易的路由
add_action('init', 'Denglu1ApiRouter::route');
// 在登陆页面添加登录易入口
add_action('login_footer', 'Denglu1LoginPage::show');
// 初始化设置页面
add_action('admin_menu', 'Denglu1SettingsPage::denglu1SettingsPageInit');
// 初始化设置页面内容
add_action('admin_init', 'Denglu1SettingsPage::denglu1SettingsInit');
// 激活时创建数据库表
register_activation_hook(__FILE__, 'Denglu1LogDB::pluginActivationCretable');
// 停用时删除数据库表
register_deactivation_hook(__FILE__, 'Denglu1LogDB::pluginDeactivationDeltable');
// 记录键盘登录的日志
add_action('wp_authenticate', 'Denglu1Log::logKeyboardLogin', 10, 2);
