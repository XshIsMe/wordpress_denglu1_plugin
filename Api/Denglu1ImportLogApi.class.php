<?php

/**
 * @version 1.0
 * 导入日志API类
 * @copyright denglu1 tech
 */
class Denglu1ImportLogApi
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
     * @return mixed 上传的文件
     */
    public static function getParams()
    {
        // 判断参数是否符合条件
        if (!isset($_FILES['denglu1-log-file']) || $_FILES['denglu1-log-file']['error'] > 0) {
            // 输出结果
            echo '<script>alert("导入失败");history.go(-1);</script>';
            exit();
        }
        // 获取参数
        $csvFile = $_FILES['denglu1-log-file'];
        // 返回
        return $csvFile;
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
        $csvFile = self::getParams();
        // 打开文件
        $handle = fopen($csvFile['tmp_name'], 'r');
        // 跳过第一行
        fgetcsv($handle);
        // 读取数据
        while ($row = fgetcsv($handle)) {
            // 判断长度
            if (8 != count($row)) {
                // 输出结果
                echo '<script>alert("导入失败");history.go(-1);</script>';
                // 结束
                exit();
            }
            // 生成日志
            $data['username'] = $row[1];
            $data['ip'] = $row[2];
            $data['longitude'] = $row[3];
            $data['latitude'] = $row[4];
            $data['action'] = $row[5];
            $data['result'] = $row[6];
            $data['time'] = $row[7];
            // 导入数据库
            Denglu1Log::importLog($data);
        }
        // 输出结果
        echo '<script>alert("导入成功");history.go(-1);</script>';
        // 结束
        exit();
    }
}
