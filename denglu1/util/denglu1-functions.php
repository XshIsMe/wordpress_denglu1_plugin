<?php

/**
 * 获取当前URL
 * @return string 当前URL
 */
function get_current_url()
{
    // 判断是否是HTTPS
    $pageURL = 'http';
    if ($_SERVER['HTTPS'] == 'on') {
        $pageURL .= 's';
    }
    // 拼接URL
    $pageURL .= '://';
    $this_page = $_SERVER['REQUEST_URI'];
    // 只取?前面的内容
    if (strpos($this_page, '?') !== false) {
        $this_page = reset(explode('?', $this_page));
    }
    // 判断端口
    if ($_SERVER['SERVER_PORT'] != '80' and $_SERVER['SERVER_PORT'] != '443') {
        $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $this_page;
    } else {
        $pageURL .= $_SERVER['SERVER_NAME'] . $this_page;
    }
    return $pageURL;
}
