<?php

/**
 * @version 1.0
 * 登录易设置页面类
 * @copyright denglu1 tech
 */
class Denglu1SettingsPage
{
    /**
     * 页面回调函数
     */
    public static function denglu1SettingsPageCB()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        require_once dirname(__FILE__) . '/Denglu1LogPage.class.php';
        // 显示表单
        require_once dirname(__FILE__) . '/Template/Denglu1SettingsPageTemplate.php';
    }

    /**
     * 分节回调函数
     */
    public static function denglu1SettingsSectionCB()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        // 获取配置
        $opId = Denglu1Config::SETTINGS_OPTION_ID;
        $options = get_option($opId);
        // 填充表单
        require_once dirname(__FILE__) . '/Template/Denglu1SettingsSectionTemplate.php';
    }

    /**
     * 设置页面初始化函数
     */
    public static function denglu1SettingsPageInit()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        // 为管理员菜单添加新页面
        add_menu_page(
            Denglu1Config::PAGE_TITLE,                   // 浏览器标题中显示的名称
            Denglu1Config::MENU_TITLE,                   // 管理员菜单中显示的名称
            'manage_options',
            Denglu1Config::SETTINGS_PAGE_ID,             // 设置页面ID
            'Denglu1SettingsPage::denglu1SettingsPageCB' // 用来展示设置页面的回调函数
        );
    }

    /**
     * 设置页面内容初始化函数
     */
    public static function denglu1SettingsInit()
    {
        // 导入
        require_once dirname(__FILE__) . '/../Denglu1Config.class.php';
        // 为页面注册新设置
        register_setting(
            Denglu1Config::SETTINGS_GROUP_ID,  // 设置组ID
            Denglu1Config::SETTINGS_OPTION_ID  // 设置选项ID
        );
        // 在页面上注册新分节
        add_settings_section(
            Denglu1Config::SETTINGS_SECTION_ID,              // 分节ID
            Denglu1Config::SECTION_TITLE,                    // 分节标题
            'Denglu1SettingsPage::denglu1SettingsSectionCB', // 回调函数
            Denglu1Config::SETTINGS_PAGE_ID                  // 设置页面ID
        );
    }
}
