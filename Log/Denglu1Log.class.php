<?php

class Denglu1Log
{
    public static function logKeyboardLogin($username, $password)
    {
        // 导入
        require_once dirname(__FILE__) . '/../Tools/Denglu1Util.class.php';
        // 验证参数是否存在
        if (!(isset($username) && isset($password))) {
            return;
        }
        // 验证账号密码
        $user = wp_authenticate($username, $password);
        // 处理验证结果
        $result = true;
        if (is_wp_error($user)) {
            $result = false;
        }
        // 获取IP
        $ip = Denglu1Util::getIp();
        // 写日志
        self::addLog($username, $ip, $result, 'LOGIN');
    }

    public static function addLog($username, $ip, $result, $action)
    {
        // 导入
        require_once dirname(__FILE__) . '/Denglu1LogDB.class.php';
        require_once dirname(__FILE__) . '/../Tools/Denglu1Util.class.php';
        // 根据IP获取经纬度
        $content = Denglu1Util::getLocationByIP($ip);
        // 经度 longitude
        $lon = $content['lon'];
        // 纬度 latitude
        $lat = $content['lat'];
        // 生成日志
        $data['username'] = $username;
        $data['ip'] = $ip;
        $data['longitude'] = $lon;
        $data['latitude'] = $lat;
        $data['action'] = $action;
        $data['result'] = $result;
        $data['time'] = time();
        // 写入数据库
        Denglu1LogDB::addData($data);
    }

    public static function getLog($page)
    {
        // 导入
        require_once dirname(__FILE__) . '/Denglu1LogDB.class.php';
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        // 获取数据
        $logRows = Denglu1Config::LOG_ROWS;
        $offset = $logRows * ($page - 1);
        $data = Denglu1LogDB::getData(null, null, $offset, $logRows);
        return $data;
    }

    public static function getLogToLoginByTokenRiskAnalysis($username)
    {
        // 导入
        require_once dirname(__FILE__) . '/Denglu1LogDB.class.php';
        // 获取数据
        $action = 'LoginByToken';
        $data = Denglu1LogDB::getData($username, $action, null, null);
        return $data;
    }
}
