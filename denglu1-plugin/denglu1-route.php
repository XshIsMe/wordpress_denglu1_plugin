<?php

function denglu1_route()
{
    require_once dirname(__FILE__) . '/controller/denglu1-login.php';
    require_once dirname(__FILE__) . '/controller/denglu1-register.php';
    require_once dirname(__FILE__) . '/controller/denglu1-modifyPass.php';
    require_once dirname(__FILE__) . '/controller/denglu1-loginByToken.php';
    require_once dirname(__FILE__) . '/util/denglu1-functions.php';

    // 路由列表
    $denglu1_url_list = array(
        home_url('/denglu1_login') => "denglu1_login",
        home_url('/denglu1_register') => "denglu1_register",
        home_url('/denglu1_modifyPass') => "denglu1_modifyPass",
        home_url('/denglu1_loginByToken') => "denglu1_loginByToken",
    );

    // 获取当前URL
    $current_url = get_current_url();

    // 根据URL匹配对应的功能
    foreach ($denglu1_url_list as $route => $func) {
        if ($current_url === $route) {
            $func();
            break;
        }
    }
}
