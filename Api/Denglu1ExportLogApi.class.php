<?php

class Denglu1ExportLogApi
{
    public static function authentication()
    {
        if (!current_user_can('manage_options')) {
            echo '<script>alert("您没有权限访问该页面");</script>';
            echo '<script>window.location.replace("' . home_url() . '");</script>';
            exit();
        }
    }

    public static function service()
    {
        // 验证身份
        self::authentication();
    }
}
