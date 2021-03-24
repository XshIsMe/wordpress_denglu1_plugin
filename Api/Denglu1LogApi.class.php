<?php

class Denglu1LogApi
{
    public static function authentication()
    {
        if (!current_user_can('manage_options')) {
            echo '<script>alert("您没有权限访问该页面");</script>';
            echo '<script>window.location.replace("' . home_url() . '");</script>';
            exit();
        }
    }

    public static function getParams()
    {
        $page = 1;
        // 判断参数是否符合条件
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            // 获取参数
            $page = (int)$_GET['page'];
        }
        // 返回
        return $page;
    }

    public static function service()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 验证身份
        self::authentication();
        // 获取参数
        $page = self::getParams();
        $data = Denglu1Log::getLog($page);
        // 输出结果
        echo json_encode($data);
        // 结束
        exit();
    }
}
