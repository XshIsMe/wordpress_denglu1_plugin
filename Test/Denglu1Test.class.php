<?php

class Denglu1Test
{
    public static function addLog()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1LogDB.class.php';
        // 生成日志
        for ($i = 0; $i < 5; $i++) {
            $data['username'] = 'test_' . (string)random_int(0, 100);
            $data['ip'] = '127.0.0.1';
            $data['longitude'] = '0';
            $data['latitude'] = '0';
            $data['action'] = 'Test';
            $data['result'] = true;
            $data['time'] = time();
            // 写入数据库
            Denglu1LogDB::addData($data);
        }
        // 显示结果
        echo '插入数据成功';
        // 结束
        exit();
    }

    public static function showLog()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 显示结果
        $page = 1;
        $data = Denglu1Log::getLog($page);
        // 输出结果
        echo json_encode($data);
        // 结束
        exit();
    }
}
