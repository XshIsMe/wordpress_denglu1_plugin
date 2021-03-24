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
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 验证身份
        self::authentication();
        // 首先输出头部
        header('Content-type:text/csv;');
        header('Content-Disposition:attachment;filename=' . 'Denglu1Log.csv');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        // 打开输出
        $output = fopen('php://output', 'w');
        // 读取数据
        $rows = Denglu1Log::getLogToExportLog();
        // 输出csv头部
        fputcsv($output, array('id', 'username', 'ip', 'longitude', 'latitude', 'action', 'result', 'time'));
        // 输出csv内容
        foreach ($rows as $key => $row) {
            fputcsv($output, array($row->id, $row->username, $row->ip, $row->longitude, $row->latitude, $row->action, $row->result, $row->time));
        }
        // 关闭输出
        fclose($output);
        // 结束
        exit();
    }
}
