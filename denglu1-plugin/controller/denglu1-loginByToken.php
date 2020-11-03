<?php

function denglu1_loginByToken()
{
    require_once dirname(__FILE__) . '/../util/denglu1-rsa.php';

    // 获取参数
    $sToken = $_GET['sToken'];

    // 从session中获取用户名
    session_id($sToken);
    session_start();
    $sUserName = $_SESSION['sUserName'];
    $sPassword = $_SESSION['sPassword'];
    session_destroy();

    // 登录操作
    if (!is_user_logged_in()) {
        $creds = array();
        $creds['user_login'] = $sUserName;
        $creds['user_password'] = $sPassword;
        $creds['remember'] = false;
        $user = wp_signon($creds);
        if (is_wp_error($user))
            echo $user->get_error_message();
    }

    // 重定向
    echo '<script>window.location.replace("' . home_url() . '");</script>';
    exit();
}
