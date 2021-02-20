<?php

/**
 * 处理路由
 */


function denglu1_route()
{
    require_once dirname(__FILE__) . '/denglu1-controller.php';
    require_once dirname(__FILE__) . '/denglu1-functions.php';

    // 路由列表
    $denglu1_url_list = array(
        home_url('/denglu1_login') => "denglu1_login_controller",
        home_url('/denglu1_register') => "denglu1_register_controller",
        home_url('/denglu1_modifyPass') => "denglu1_modifyPass_controller",
        home_url('/denglu1_loginByToken') => "denglu1_loginByToken_controller"
    );
    // 获取当前URL
    $current_url = denglu1_get_current_url();
    // 根据URL匹配对应的功能
    foreach ($denglu1_url_list as $route => $func) {
        if ($current_url === $route) {
            $func();
            break;
        }
    }
}
