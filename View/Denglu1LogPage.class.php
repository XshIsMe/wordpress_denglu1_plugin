<?php
class Denglu1LogPage
{
    // 展示日志
    public static function show()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 获取数据
        $page = 1;
        $rows = Denglu1Log::getLog($page);
        // 输出日志
        require_once dirname(__FILE__) . '/Template/Denglu1LogPageTemplate.php';
    }
}
