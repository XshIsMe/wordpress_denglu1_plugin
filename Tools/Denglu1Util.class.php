<?php

class Denglu1Util
{
    public static function getLocationByIP($ip)
    {
        $lon = '-1';
        $lat = '-1';
        // 根据IP获取经纬度
        $url = 'http://ip-api.com/php/' . $ip;
        // 设置超时3秒
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'timeout' => 3,
            )
        );
        // 请求三次
        $cnt = 0;
        while ($cnt < 3 && ($content = file_get_contents($url, false, stream_context_create($opts))) === false) $cnt++;
        // $content = file_get_contents($url);
        $content = unserialize($content);
        // 经度 longitude
        if (isset($content['lon'])) {
            $lon = $content['lon'];
        }
        // 纬度 latitude
        if (isset($content['lat'])) {
            $lat = $content['lat'];
        }
        // 返回
        return array(
            'lon' => $lon,
            'lat' => $lat,
        );
    }

    public static function getIp()
    {
        $ip = null;
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        else $ip = "Unknow";
        return $ip;
    }

    public static function getCurrentUrl()
    {
        // 判断是否是HTTPS
        $pageURL = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $pageURL .= 's';
        }
        // 拼接URL
        $pageURL .= '://';
        $thisPage = '';
        if (isset($_SERVER['REQUEST_URI'])) {
            $thisPage = $_SERVER['REQUEST_URI'];
        }
        // 只取?前面的内容
        if (strpos($thisPage, '?') !== false) {
            $thisPage = explode('?', $thisPage);
            $thisPage = reset($thisPage);
        }
        // 判断端口
        if (
            isset($_SERVER['SERVER_PORT'])
            && $_SERVER['SERVER_PORT'] != '80'
            && isset($_SERVER['SERVER_PORT'])
            && $_SERVER['SERVER_PORT'] != '443'
        ) {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $thisPage;
        } else {
            $pageURL .= $_SERVER['SERVER_NAME'] . $thisPage;
        }
        return $pageURL;
    }
}
