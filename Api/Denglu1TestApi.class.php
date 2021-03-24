<?php

class Denglu1TestApi
{
    public static function authentication()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        // 检查Debug模式是否开启
        if (!Denglu1Config::DEBUG || !current_user_can('manage_options')) {
            echo '<script>alert("您没有权限访问该页面");</script>';
            echo '<script>window.location.replace("' . home_url() . '");</script>';
            exit();
        }
    }

    public static function getParams()
    {
        $action = 'show_log';
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
        return $action;
    }

    public static function service()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Test/Denglu1Test.class.php';
        // 验证身份
        self::authentication();
        // 获取参数
        $action = self::getParams();
        // 执行
        if ('add_log' == $action) {
            Denglu1Test::addLog();
        } else {
            Denglu1Test::showLog();
        }
    }
}
