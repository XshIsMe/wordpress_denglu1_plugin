<?php

class Denglu1RegisterApi
{
    public static function getParams()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Tools/Denglu1EncryptUtil.class.php';
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        // 判断参数是否存在
        if (
            !(isset($_POST['sUserName'])
                && isset($_POST['sPassword'])
                && isset($_POST['sEncryptedAESKey'])
                && isset($_POST['sClientIp']))
        ) {
            // 输出结果
            echo json_encode(array('iCode' => -700, 'sMsg' => '缺少参数'));
            exit();
        }
        // 获取参数
        $username = $_POST['sUserName'];
        $password = $_POST['sPassword'];
        $encryptedAESKey = $_POST['sEncryptedAESKey'];
        $ip = $_POST['sClientIp'];
        // 获取私钥
        $options = get_option(Denglu1Config::SETTINGS_OPTION_ID);
        $privateKey = $options['privateKey'];
        // 解密参数
        $password = Denglu1EncryptUtil::rsaAesDecrypt($password, $encryptedAESKey, $privateKey);
        // 返回
        return array(
            'username' => $username,
            'password' => $password,
            'ip' => $ip,
        );
    }

    public static function log($username, $ip, $result)
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 记录日志
        Denglu1Log::addLog($username, $ip, $result, 'DENGLU1_REGISTER_SCAN');
    }

    public static function logic($username, $password)
    {
        $userData = array(
            'user_login' => $username,
            'user_pass' => $password,
        );
        $registerResult = wp_insert_user($userData);
        return !is_wp_error($registerResult);
    }

    public static function service()
    {
        // 获取参数
        $params = self::getParams();
        $username = $params['username'];
        $password = $params['password'];
        $ip = $params['ip'];
        // 验证参数
        $result = self::logic($username, $password);
        // 处理结果
        if ($result) {
            // 将用户名保存在session
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $sessionId = session_id();
            // 输出结果
            echo json_encode(array('iCode' => 0, 'sMsg' => 'SUCCESS', 'sToken' => $sessionId));
        } else {
            // 输出结果
            echo json_encode(array('iCode' => -801, 'sMsg' => '用户名已经存在'));
        }
        // 写日志
        self::log($username, $ip, $result);
        // 结束
        exit();
    }
}
