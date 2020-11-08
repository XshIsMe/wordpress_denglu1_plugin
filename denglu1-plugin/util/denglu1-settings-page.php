<?php

/**
 * 设置页面描述
 */
function denglu1_plugin_section_text()
{
    echo '<hr>';
    echo '<p>' . '应用的登录地址：' . home_url('/denglu1_login') . '</p>';
    echo '<p>' . '登录重定向地址：' . home_url('/denglu1_loginByToken') . '</p>';
    echo '<p>' . '应用的注册地址：' . home_url('/denglu1_register') . '</p>';
    echo '<p>' . '注册重定向地址：' . home_url('/denglu1_loginByToken') . '</p>';
    echo '<p>' . '应用的改密地址：' . home_url('/denglu1_modifyPass') . '</p>';
    echo '<p>' . '改密重定向地址：' . home_url('/denglu1_loginByToken') . '</p>';
    echo '<hr>';
}

/**
 * appId
 */
function denglu1_plugin_setting_appId()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';
    $options = get_option(PageConfig::option_name);
?>
    <input id='denglu1_plugin_setting_appId' name='denglu1_plugin_options[appId]' type='text' value='<?php echo esc_attr($options['appId']) ?>' />
<?php
}

/**
 * sUrl
 */
function denglu1_plugin_setting_sUrl()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';
    $options = get_option(PageConfig::option_name);
?>
    <input id='denglu1_plugin_setting_sUrl' name='denglu1_plugin_options[sUrl]' type='text' value='<?php echo esc_attr($options['sUrl']) ?>' />
<?php
}

/**
 * publicKey
 */
function denglu1_plugin_setting_publicKey()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';
    $options = get_option(PageConfig::option_name);
?>
    <textarea id='denglu1_plugin_setting_publicKey' name='denglu1_plugin_options[publicKey]'><?php echo esc_attr($options['publicKey']) ?></textarea>
<?php
}

/**
 * privateKey
 */
function denglu1_plugin_setting_privateKey()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';
    $options = get_option(PageConfig::option_name);
?>
    <textarea id='denglu1_plugin_setting_privateKey' name='denglu1_plugin_options[privateKey]'><?php echo esc_attr($options['privateKey']) ?></textarea>
<?php
}

/**
 * 登录易设置页面参数注册
 */
function denglu1_register_settings()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';

    // 注册设置及其数据
    register_setting(
        PageConfig::option_group, // 设置组名。应与白名单选项键名称相对应
        PageConfig::option_name,  // 要清理和保存的选项的名称
        ''                        // 过滤参数的回调函数
    );

    // 将新分区添加到设置页
    add_settings_section(
        PageConfig::id,                // 用于标识节的段塞名称。用于标记的“id”属性中
        PageConfig::title,             // 节的格式化标题。显示为该节的标题
        'denglu1_plugin_section_text', // 在节的顶部（在标题和字段之间）回显任何内容的函数
        PageConfig::menu_slug          // 显示节的设置页的slug名称
    );

    // 将新字段添加到“设置”页的某个部分
    add_settings_field(
        'denglu1_plugin_setting_appId', // 字段ID
        'appId',                        // 字段的展示标题
        'denglu1_plugin_setting_appId', // 字段的回调函数
        PageConfig::menu_slug,          // 设置页的slug名称
        PageConfig::id                  // 设置id
    );
    add_settings_field('denglu1_plugin_setting_sUrl', 'sUrl', 'denglu1_plugin_setting_sUrl', PageConfig::menu_slug, PageConfig::id);
    add_settings_field('denglu1_plugin_setting_publicKey', 'publicKey', 'denglu1_plugin_setting_publicKey', PageConfig::menu_slug, PageConfig::id);
    add_settings_field('denglu1_plugin_setting_privateKey', 'privateKey', 'denglu1_plugin_setting_privateKey', PageConfig::menu_slug, PageConfig::id);
}

/**
 * 登录易设置页面回调函数
 */
function denglu1_render_settings_page()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';
?>
    <form action="options.php" method="post">
        <?php
        // 输出设置页的nonce、action和optionu页字段
        settings_fields(
            PageConfig::option_group //设置组名称。这应该与register_setting（）中使用的组名匹配
        );
        // 打印出添加到特定设置页的所有设置节
        do_settings_sections(
            PageConfig::menu_slug    // 要输出其设置节的页面的slug名称
        );
        ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>" />
    </form>
<?php
}

/**
 * 添加登录易设置页面
 */
function add_denglu1_settings_page()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';

    // 将子菜单页添加到设置主菜单
    add_menu_page(
        PageConfig::page_title,        // 选择菜单时要在页面标题标记中显示的文本
        PageConfig::menu_title,        // 用于菜单的文本
        'manage_options',              // 向用户显示此菜单所需的功能
        PageConfig::menu_slug,         // 用于引用此菜单的slug名称（对于此菜单应是唯一的）
        'denglu1_render_settings_page' // 要调用以输出此页内容的函数
    );
}
