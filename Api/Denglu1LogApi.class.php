<?php

/**
 * @version 1.0
 * 查看日志API类
 * @copyright denglu1 tech
 */
class Denglu1LogApi
{
    /**
     * 验证当前用户是否有权限访问此API
     */
    public static function authentication()
    {
        if (!current_user_can('manage_options')) {
            echo '<script>alert("您没有权限访问该页面");</script>';
            echo '<script>window.location.replace("' . home_url() . '");</script>';
            exit();
        }
    }

    /**
     * 获取请求的参数
     * @return int 页码
     */
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

    /**
     * API服务
     */
    public static function service()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 验证身份
        self::authentication();
        // 获取参数
        $page = self::getParams();
        $data = Denglu1Log::getLog(null, null, $page);
        // 输出结果
        echo json_encode($data);
        // 结束
        exit();
    }
}
