<?php

/**
 * @version 1.0
 * 登录易日志页面类
 * @copyright denglu1 tech
 */
class Denglu1LogPage
{
    /**
     * 显示页面
     */
    public static function show()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 输出日志
        require_once dirname(__FILE__) . '/Template/Denglu1LogPageTemplate.php';
    }
}
