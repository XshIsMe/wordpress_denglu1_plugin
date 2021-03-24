<?php

class Denglu1LoginByTokenApi
{
    public static function getParams()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Tools/Denglu1Util.class.php';
        // 判断参数是否存在
        if (!isset($_GET['sToken'])) {
            // 输出结果
            echo '<script>window.location.replace("' . home_url() . '");</script>';
            exit();
        }
        // 判断session中的参数是否存在
        $sessionId = $_GET['sToken'];
        session_id($sessionId);
        session_start();
        if (!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
            // 输出结果
            echo '<script>window.location.replace("' . home_url() . '");</script>';
            exit();
        }
        // 获取参数
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $ip = Denglu1Util::getIp();
        session_destroy();
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
        Denglu1Log::addLog($username, $ip, $result, 'LoginByToken');
    }

    public static function logic()
    {
        return !is_user_logged_in();
    }

    public static function service()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Security/Denglu1Security.class.php';
        // 获取参数
        $params = self::getParams();
        $username = $params['username'];
        $password = $params['password'];
        $ip = $params['ip'];
        // 验证参数
        $result = self::logic();
        // 处理结果
        if ($result) {
            $creds = array();
            $creds['user_login'] = $username;
            $creds['user_password'] = $password;
            $creds['remember'] = false;
            $user = wp_signon($creds);
            if (is_wp_error($user))
                echo $user->get_error_message();
        } else {
            // 输出结果
            echo '<script>alert("当前已登录其他账号");</script>';
        }
        // 写日志
        // self::log($username, $ip, $result);
        // 分析登录行为
        $riskAnalysisResult = Denglu1Security::loginByTokenRiskAnalysis($username);
        if (!$riskAnalysisResult) {
            // 输出结果
            echo '<script>alert("根据登录易风险分析的结果，您的账号存在安全风险，请尽快修改密码！");</script>';
        }
        // 结束
        echo '<script>window.location.replace("' . home_url() . '");</script>';
        exit();
    }
}
