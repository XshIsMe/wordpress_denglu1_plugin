<?php

/**
 * @version 1.0
 * 日志类
 * @copyright denglu1 tech
 */
class Denglu1Log
{
    /**
     * 记录登录日志
     * @param string $username 用户名
     * @param string $password 密码
     */
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

    /**
     * 插入一条日志
     * @param string $username 用户名
     * @param string $ip       IP地址
     * @param bool   $result   执行结果
     * @param string $action   动作
     */
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

    /**
     * 导入日志
     * @param array 一条日志数组
     */
    public static function importLog($data)
    {
        // 导入
        require_once dirname(__FILE__) . '/Denglu1LogDB.class.php';
        // 写入数据库
        Denglu1LogDB::addData($data);
    }

    /**
     * 分页查询
     * @param  int $page 页码
     * @return mixed     查询结果
     */
    public static function getLog($page)
    {
        $logRows = Denglu1Config::LOG_ROWS;
        $offset = $logRows * ($page - 1);
        $data = Denglu1LogDB::getData($offset, $logRows);
        // 返回
        return $data;
    }

    /**
     * 用于导出数据库的查询
     * @return mixed 查询结果
     */
    public static function exportLog()
    {
        $data = Denglu1LogDB::exportData();
        // 返回
        return $data;
    }

    /**
     * 用于1号风险分析模块的查询
     * @param  string $username 用户名
     * @param  string $action   动作
     * @return mixed            查询结果
     */
    public static function getLog_RiskAnalysisModel_1($username, $action)
    {
        $data = Denglu1LogDB::getData_RiskAnalysisModel_1($username, $action);
        // 返回
        return $data;
    }
}
