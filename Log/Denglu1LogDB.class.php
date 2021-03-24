<?php

class Denglu1LogDB
{
    // 表名
    const TABLE_NAME = 'wp_denglu1_login_log';

    // 激活插件时创建表
    public static function pluginActivationCretable()
    {
        // 获取数据库对象
        global $wpdb;
        // 表名
        $tableName = self::TABLE_NAME;
        // 删除已经存在的表
        $theRemovalQuery = "DROP TABLE IF EXISTS {$tableName}";
        $wpdb->query($theRemovalQuery);
        // 设置编码
        $charsetCollate = '';
        if (!empty($wpdb->charset)) {
            $charsetCollate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        }
        if (!empty($wpdb->collate)) {
            $charsetCollate .= " COLLATE {$wpdb->collate}";
        }
        // 创建表
        $sql = "
            CREATE TABLE `{$tableName}` (
                `id`        int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `username`  text NOT NULL,
                `ip`        text NOT NULL,
                `longitude` text NOT NULL,
                `latitude`  text NOT NULL,
                `time`      text NOT NULL,
                `action`    text NOT NULL,
                `result`    text NOT NULL,
                UNIQUE KEY id (id)
            ) {$charsetCollate};
        ";
        if (!defined('ABSPATH')) {
            define('ABSPATH', dirname(__FILE__) . '/../../../../');
        }
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // 停用插件时删除表
    public static function pluginDeactivationDeltable()
    {
        // 获取数据库对象
        global $wpdb;
        // 表名
        $tableName = self::TABLE_NAME;
        // 删除已经存在的表
        $theRemovalQuery = "DROP TABLE IF EXISTS {$tableName}";
        $wpdb->query($theRemovalQuery);
    }

    // 插入数据
    public static function addData($data)
    {
        // 获取数据库对象
        global $wpdb;
        // 表名
        $tableName = self::TABLE_NAME;
        // 如果表不存在，返回
        if ($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") != self::TABLE_NAME) {
            return;
        }
        // 插入数据
        $wpdb->insert(self::TABLE_NAME, $data);
    }

    // 查询数据
    public static function getData($username = null, $action = null, $offset = null, $rows = null)
    {
        // 获取数据库对象
        global $wpdb;
        // 表名
        $tableName = self::TABLE_NAME;
        // 如果表不存在，返回
        if ($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") != self::TABLE_NAME) {
            return;
        }
        // 查询数据
        $sql = null;
        if (isset($offset) && isset($rows)) {
            // 分页查询
            $sql = $wpdb->prepare("SELECT * FROM {$tableName} ORDER BY time DESC LIMIT %d, %d", $offset, $rows);
        } elseif (isset($username) && isset($action)) {
            // 用于风险分析的查询
            $sql = $wpdb->prepare("SELECT * FROM {$tableName} WHERE username='%s' AND action='%s' ORDER BY time DESC", $username, $action);
        } else {
            // 用于导出数据库的查询
            $sql = "SELECT * FROM {$tableName} ORDER BY time DESC";
        }
        $myrows = $wpdb->get_results($sql);
        return $myrows;
    }
}
