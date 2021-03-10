<?php

/**
 * 日志功能
 */


// 数据库操作类
class Denglu1_DB
{
    const table_name = 'wp_denglu1_login_log';

    // 激活插件时创建表
    public static function plugin_activation_cretable()
    {
        global $wpdb;

        // 表名
        $table_name = self::table_name;

        // 删除已经存在的表
        $the_removal_query = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($the_removal_query);

        // 设置编码
        $charset_collate = '';
        if (!empty($wpdb->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        }
        if (!empty($wpdb->collate)) {
            $charset_collate .= " COLLATE {$wpdb->collate}";
        }

        // 创建表
        $sql = "
        CREATE TABLE `{$table_name}` (
            `id`        int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `username`  text NOT NULL,
            `ip`        text NOT NULL,
            `longitude` text NOT NULL,
            `latitude`  text NOT NULL,
            `time`      text NOT NULL,
            `action`    text NOT NULL,
            UNIQUE KEY id (id)
        ) {$charset_collate};
    ";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // 停用插件时删除表
    public static function plugin_deactivation_deltable()
    {
        global $wpdb;

        // 表名
        $table_name = self::table_name;

        // 删除已经存在的表
        $the_removal_query = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($the_removal_query);
    }

    // 插入数据
    public static function add_data($data)
    {
        global $wpdb;

        // 表名
        $table_name = self::table_name;

        // 如果表不存在，返回
        if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != self::table_name) {
            return;
        }

        $wpdb->insert(self::table_name, $data);
    }

    // 查询数据
    public static function get_data($username = null)
    {
        global $wpdb;

        // 表名
        $table_name = self::table_name;

        // 如果表不存在，返回
        if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != self::table_name) {
            return;
        }

        $sql = "";
        if (null == $username) {
            $sql = "SELECT * FROM {$table_name} ORDER BY time DESC";
        } else {
            $sql = "SELECT * FROM {$table_name} WHERE username='{$username}' ORDER BY time DESC";
        }

        $myrows = $wpdb->get_results($sql);
        return $myrows;
    }
}

// 风险分析类
class Denglu1_Risk_Analysis
{
    const distance_threshold = 100;

    // 求两个已知经纬度之间的距离,单位为km
    public static function calc_distance($data1, $data2)
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
    public static function calc_time_interval($data1, $data2)
    {
        $time1 = $data1['time'];
        $time2 = $data2['time'];
        $seconds_interval = abs($time1 - $time2);
        $week_interval = $seconds_interval / 604800;
        return round($week_interval);
    }

    // 计算风险
    public static function calc_risk($current_data, $history_datas)
    {
        $d2 = 0;
        foreach ($history_datas as $key => $history_data) {
            $time_interval = self::calc_time_interval((array)$current_data, (array)$history_data);
            $distance = self::calc_distance((array)$current_data, (array)$history_data);
            $d = 0;
            if ($distance < self::distance_threshold) {
                $d = 1;
            }
            $d2 += pow(0.8, $time_interval) * $d;
        }
        return $d2;
    }
}

// 写日志
function denglu1_log($sUserName, $sClientIp, $action)
{
    // 根据IP获取经纬度
    $url = 'http://ip-api.com/php/' . $sClientIp;
    $content = file_get_contents($url);
    $content = unserialize($content);
    // 经度 longitude
    $lon = $content['lon'];
    // 纬度 latitude
    $lat = $content['lat'];
    // 生成日志
    $data['username'] = $sUserName;
    $data['ip'] = $sClientIp;
    $data['longitude'] = $lon;
    $data['latitude'] = $lat;
    $data['time'] = time();
    $data['action'] = $action;
    // 写入数据库
    Denglu1_DB::add_data($data);
}

// 分析登录行为
function denglu1_analyze_action($sUserName)
{
    $data = Denglu1_DB::get_data($sUserName);
    $current_data = $data[0];
    $history_datas = array_slice($data, 1);
    $d2 = Denglu1_Risk_Analysis::calc_risk($current_data, $history_datas);
    if (0.5 > $d2) {
        return false;
    }
    return true;
}

// 展示日志
function denglu1_show_log()
{
    $rows = Denglu1_DB::get_data();
?>
    <h2>日志</h2>
    <table class="wp-list-table widefat plugins">
        <tr>
            <th>用户名</th>
            <th>IP地址</th>
            <th>经度</th>
            <th>纬度</th>
            <th>时间</th>
            <th>动作</th>
        </tr>
        <?php
        if (null !== $rows) {
            foreach ($rows as $key => $row) {
                echo "<tr>";
                echo "<td>" . esc_html($row->username) . "</td>";
                echo "<td>" . esc_html($row->ip) . "</td>";
                echo "<td>" . esc_html($row->longitude) . "</td>";
                echo "<td>" . esc_html($row->latitude) . "</td>";
                echo "<td>" . esc_html(date("Y/m/d H:i:s", $row->time)) . "</td>";
                echo "<td>" . esc_html($row->action) . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
<?php
}
