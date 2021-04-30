<?php

/**
 * @version 1.0
 * 扫码登录API类
 * @copyright denglu1 tech
 */
class Denglu1LoginApi
{
    /**
     * 获取请求的参数
     * @return array 参数数组
     */
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
        $username = sanitize_text_field($_POST['sUserName']);
        $password = sanitize_text_field($_POST['sPassword']);
        $encryptedAESKey = sanitize_text_field($_POST['sEncryptedAESKey']);
        $ip = sanitize_text_field($_POST['sClientIp']);
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

    /**
     * 记录日志
     * @param string $username 用户名
     * @param string $ip       IP地址
     * @param bool   $result   执行结果
     */
    public static function log($username, $ip, $result)
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 记录日志
        Denglu1Log::addLog($username, $ip, $result, 'DENGLU1_LOGIN_SCAN');
    }

    /**
     * 判断用户名密码是否正确
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool             判断结果
     */
    public static function logic($username, $password)
    {
        if (is_wp_error(wp_authenticate($username, $password))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * API服务
     */
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
            echo json_encode(array('iCode' => -800, 'sMsg' => '用户名或密码错误'));
        }
        // 写日志
        self::log($username, $ip, $result);
        // 结束
        exit();
    }
}
