<?php

class Denglu1RiskAnalysisModel1
{
    // 距离区间
    const DISTANCE_THRESHOLD = 100;

    // 求两个已知经纬度之间的距离,单位为km
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

    // 求两次登录之间间隔的时间,单位为周
    public static function calcTimeInterval($data1, $data2)
    {
        $time1 = $data1['time'];
        $time2 = $data2['time'];
        $seconds_interval = abs($time1 - $time2);
        $week_interval = $seconds_interval / 604800;
        return round($week_interval);
    }

    // 计算风险
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
}
