<?php

/**
 * @version 1.0
 * API路由类
 * @copyright denglu1 tech
 */
class Denglu1ApiRouter
{
    /**
     * 根据URL调用对应的服务
     */
    public static function route()
    {
        // 导入
        require_once dirname(__FILE__) . '/Denglu1LoginApi.class.php';
        require_once dirname(__FILE__) . '/Denglu1RegisterApi.class.php';
        require_once dirname(__FILE__) . '/Denglu1ModifyPasswordApi.class.php';
        require_once dirname(__FILE__) . '/Denglu1LoginByTokenApi.class.php';
        require_once dirname(__FILE__) . '/Denglu1LogApi.class.php';
        require_once dirname(__FILE__) . '/Denglu1ImportLogApi.class.php';
        require_once dirname(__FILE__) . '/Denglu1ExportLogApi.class.php';
        require_once dirname(__FILE__) . '/Denglu1TestApi.class.php';
        require_once dirname(__FILE__) . '/../Tools/Denglu1Util.class.php';
        // 路由列表
        $denglu1UrlList = array(
            home_url('/Denglu1Login') => "Denglu1LoginApi::service",
            home_url('/Denglu1Register') => "Denglu1RegisterApi::service",
            home_url('/Denglu1ModifyPassword') => "Denglu1ModifyPasswordApi::service",
            home_url('/Denglu1LoginByToken') => "Denglu1LoginByTokenApi::service",
            home_url('/Denglu1Log') => "Denglu1LogApi::service",
            home_url('/Denglu1ImportLog') => "Denglu1ImportLogApi::service",
            home_url('/Denglu1ExportLog') => "Denglu1ExportLogApi::service",
            home_url('/Denglu1Test') => "Denglu1TestApi::service",
        );
        // 获取当前URL
        $currentUrl = Denglu1Util::getCurrentUrl();
        // 根据URL匹配对应的功能
        foreach ($denglu1UrlList as $route => $func) {
            if ($currentUrl === $route) {
                $func();
                break;
            }
        }
    }
}
