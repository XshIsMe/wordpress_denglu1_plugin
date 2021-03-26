<?php

/**
 * @version 1.0
 * 登录易登录按钮页面类
 * @copyright denglu1 tech
 */
class Denglu1LoginPage
{
    /**
     * 显示页面
     */
    public static function show()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        // 获取配置
        $options = get_option(Denglu1Config::SETTINGS_OPTION_ID);
        // 添加按钮
        require_once dirname(__FILE__) . '/Template/Denglu1LoginPageTemplate.php';
    }
}
