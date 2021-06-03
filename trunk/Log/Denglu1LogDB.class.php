<?php

/**
 * @version 1.0
 * 日志数据库类
 * @copyright denglu1 tech
 */
class Denglu1LogDB
{
    /**
     * 数据库表名
     */
    const TABLE_NAME = 'wp_denglu1_login_log';

    /**
     * 激活插件时创建表
     */
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
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * 停用插件时删除表
     */
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

    /**
     * 插入数据
     * @param string 一行数据数组
     */
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

    /**
     * 执行SQL语句
     * @param  string $sql SQL语句
     * @return mixed       查询结果
     */
    public static function execSQL($sql)
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
        $results = $wpdb->get_results($sql);
        // 返回
        return $results;
    }

    /**
     * 分页查询
     * @param  string $offset 起始位置
     * @param  string $rows   数据条数
     * @return mixed          查询结果
     */
    public static function getData($offset, $rows)
    {
        // 获取数据库对象
        global $wpdb;
        // 表名
        $tableName = self::TABLE_NAME;
        // 查询数据
        $sql = $wpdb->prepare("SELECT * FROM {$tableName} ORDER BY time DESC LIMIT %d, %d", $offset, $rows);
        // 查询数据
        $results = self::execSQL($sql);
        // 返回
        return $results;
    }

    /**
     * 用于导出数据库的查询
     * @return mixed 查询结果
     */
    public static function exportData()
    {
        // 表名
        $tableName = self::TABLE_NAME;
        // SQL语句
        $sql = "SELECT * FROM {$tableName} ORDER BY time DESC";
        // 查询数据
        $results = self::execSQL($sql);
        // 返回
        return $results;
    }

    /**
     * 用于1号风险分析模块的查询
     * @param  string $username 用户名
     * @param  string $action   动作
     * @return mixed            查询结果
     */
    public static function getData_RiskAnalysisModel_1($username, $action)
    {
        // 获取数据库对象
        global $wpdb;
        // 表名
        $tableName = self::TABLE_NAME;
        // 查询数据
        $sql = $wpdb->prepare("SELECT * FROM {$tableName} WHERE username='%s' AND action='%s' ORDER BY time DESC", $username, $action);
        // 查询数据
        $results = self::execSQL($sql);
        // 返回
        return $results;
    }
}
