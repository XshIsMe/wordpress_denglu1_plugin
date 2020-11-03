<?php

class userLogic
{
    /**
     * 登录
     * @param  string $sUserName 用户名
     * @param  string $sPassword 密码
     * @return bool              结果
     */
    public static function login($sUserName, $sPassword)
    {
        return user_pass_ok($sUserName, $sPassword);
    }

    /**
     * 注册
     * @param  string $sUserName 用户名
     * @param  string $sPassword 密码
     * @return bool              结果
     */
    public static function register($sUserName, $sPassword)
    {
        $userData = array(
            'user_login' => $sUserName,
            'user_pass' => $sPassword,
        );
        $registerResult = wp_insert_user($userData);
        return !is_wp_error($registerResult);
    }

    /**
     * 修改密码
     * @param  string $sUserName    用户名
     * @param  string $sOldPassword 旧密码
     * @param  string $sNewPassword 新密码
     * @return bool                 结果
     */
    public static function modifyPass($sUserName, $sOldPassword, $sNewPassword)
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
}
