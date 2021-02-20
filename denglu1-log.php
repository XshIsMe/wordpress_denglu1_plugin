<?php

/**
 * 日志功能
 */


// 初始化日志
function denglu1_init_logfile()
{
    $logfile = fopen(dirname(__FILE__) . '/denglu1-logfile.csv', 'w') or die('Unable to open file!');
    fclose($logfile);
}

// 写日志
function denglu1_log($sUserName, $sClientIp, $action)
{
    $log = $sUserName . ', ' . $sClientIp . ', ' . time() . ', ' . $action . "\n";
    $logfile = fopen(dirname(__FILE__) . '/denglu1-logfile.csv', 'a') or die('Unable to open file!');
    fwrite($logfile, $log);
    fclose($logfile);
}

// 分析登录行为
function denglu1_analyze_action($sUserName)
{
    return true;
}

// 展示日志
function denglu1_show_log()
{
    $handle = fopen(dirname(__FILE__) . '/denglu1-logfile.csv', 'r') or die('Unable to open file!');
?>
    <h2>日志</h2>
    <table class="wp-list-table widefat plugins">
        <tr>
            <th>用户名</th>
            <th>IP地址</th>
            <th>时间</th>
            <th>动作</th>
        </tr>
        <?php
        while (!feof($handle)) {
            $row = fgetcsv($handle);
            if (empty($row[0])) {
                continue;
            }
            echo "<tr>";
            echo "<td>" . esc_html($row[0]) . "</td>";
            echo "<td>" . esc_html($row[1]) . "</td>";
            echo "<td>" . esc_html(date("Y/m/d H:i:s", $row[2])) . "</td>";
            echo "<td>" . esc_html($row[3]) . "</td>";
            echo "</tr>";
        }
        fclose($handle);
        ?>
    </table>
<?php
}
