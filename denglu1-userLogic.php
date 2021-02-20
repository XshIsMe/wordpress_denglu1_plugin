<?php

/**
 * 处理登录逻辑
 */


// 用户登录逻辑
function denglu1_login_logic($sUserName, $sPassword)
{
    return user_pass_ok($sUserName, $sPassword);
}

// 用户注册逻辑
function denglu1_register_logic($sUserName, $sPassword)
{
    $userData = array(
        'user_login' => $sUserName,
        'user_pass' => $sPassword,
    );
    $registerResult = wp_insert_user($userData);
    return !is_wp_error($registerResult);
}

// 用户修改密码逻辑
function denglu1_modifyPass_logic($sUserName, $sOldPassword, $sNewPassword)
{
    if (user_pass_ok($sUserName, $sOldPassword)) {
        // 获取用户ID
        $user = get_userdatabylogin($sUserName);
        $userId = $user->ID;
        // 更新用户
        wp_set_password($sNewPassword,  $userId);
        return true;
    }
    return false;
}
