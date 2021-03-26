<?php

/**
 * @version 1.0
 * 1号风险分析模型类
 * @copyright denglu1 tech
 */
class Denglu1RiskAnalysisModel_1
{
    /**
     * 两地危险距离阈值（单位KM）
     */
    const DISTANCE_THRESHOLD = 100;

    /**
     * 求两个已知经纬度之间的距离
     * @param  array $data1 数据1
     * @param  array $data1 数据2
     * @return float        两地之间距离（单位KM）
     */
    public static function calcDistance($data1, $data2)
    {
        $lon1 = $data1['longitude'];
        $lat1 = $data1['latitude'];
        $lon2 = $data2['longitude'];
        $lat2 = $data2['latitude'];
        //将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radlon1 = deg2rad($lon1);
        $radlon2 = deg2rad($lon2);
        $a = $radLat1 - $radLat2;
        $b = $radlon1 - $radlon2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6371;
        return round($s);
    }

    /**
     * 求两次登录之间间隔的时间
     * @param  array $data1 数据1
     * @param  array $data1 数据2
     * @return float        两次登录间隔时间（单位周）
     */
    public static function calcTimeInterval($data1, $data2)
    {
        $time1 = $data1['time'];
        $time2 = $data2['time'];
        $seconds_interval = abs($time1 - $time2);
        $week_interval = $seconds_interval / 604800;
        return round($week_interval);
    }

    /**
     * 计算风险系数
     * @param  mixed $currentData 本次登录的日志
     * @param  array $historyData 历史登录日志数组
     * @return float              风险系数（小于0.5为存在风险）
     */
    public static function calcRisk($currentData, $historyDatas)
    {
        $d2 = 0;
        foreach ($historyDatas as $key => $historyData) {
            $timeInterval = self::calcTimeInterval((array)$currentData, (array)$historyData);
            $distance = self::calcDistance((array)$currentData, (array)$historyData);
            $d = 0;
            if ($distance < self::DISTANCE_THRESHOLD) {
                $d = 1;
            }
            $d2 += pow(0.8, $timeInterval) * $d;
        }
        return $d2;
    }

    /**
     * 获取风险分析结果
     * @param  string $username 用户名
     * @return bool             风险分析结果
     */
    public static function getRiskAnalysisResult($username)
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        // 获取数据
        $data = Denglu1Log::getLog($username, 'LOGIN', null);
        $currentData = $data[0];
        $historyDatas = array_slice($data, 1);
        // 计算风险
        $d2 = 1;
        if (1 <= count($historyDatas)) {
            $d2 = self::calcRisk($currentData, $historyDatas);
        }
        // 根据计算结果给出答案
        if (0.5 > $d2) {
            return false;
        }
        return true;
    }
}
