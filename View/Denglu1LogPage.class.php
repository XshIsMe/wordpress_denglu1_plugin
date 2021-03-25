<?php
class Denglu1LogPage
{
    // 展示日志
    public static function show()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 输出日志
        require_once dirname(__FILE__) . '/Template/Denglu1LogPageTemplate.php';
    }
}
