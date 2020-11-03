<?php

/**
 * 参数过滤
 */
function denglu1_plugin_options_validate($input)
{
    return $input;
}

/**
 * 设置页面描述
 */
function denglu1_plugin_section_text()
{
?>
    <p>登录易设置</p>
<?php
}

/**
 * appId
 */
function denglu1_plugin_setting_appId()
{
    $options = get_option('denglu1_plugin_options');
?>
    <input id='denglu1_plugin_setting_appId' name='denglu1_plugin_options[appId]' type='text' value='<?php echo esc_attr($options['appId']) ?>' />
<?php
}

/**
 * sUrl
 */
function denglu1_plugin_setting_sUrl()
{
    $options = get_option('denglu1_plugin_options');
?>
    <input id='denglu1_plugin_setting_sUrl' name='denglu1_plugin_options[sUrl]' type='text' value='<?php echo esc_attr($options['sUrl']) ?>' />
<?php
}

/**
 * publicKey
 */
function denglu1_plugin_setting_publicKey()
{
    $options = get_option('denglu1_plugin_options');
?>
    <textarea id='denglu1_plugin_setting_publicKey' name='denglu1_plugin_options[publicKey]'><?php echo esc_attr($options['publicKey']) ?></textarea>
<?php
}

/**
 * privateKey
 */
function denglu1_plugin_setting_privateKey()
{
    $options = get_option('denglu1_plugin_options');
?>
    <textarea id='denglu1_plugin_setting_privateKey' name='denglu1_plugin_options[privateKey]'><?php echo esc_attr($options['privateKey']) ?></textarea>
<?php
}

/**
 * 登录易设置页面注册
 */
function denglu1_register_settings()
{
    register_setting('denglu1_plugin_options', 'denglu1_plugin_options', 'denglu1_plugin_options_validate');
    add_settings_section('denglu1_plugin_settings', '登录易设置', 'denglu1_plugin_section_text', 'denglu1_plugin');

    add_settings_field('denglu1_plugin_setting_appId', 'appId', 'denglu1_plugin_setting_appId', 'denglu1_plugin', 'denglu1_plugin_settings');
    add_settings_field('denglu1_plugin_setting_sUrl', 'sUrl', 'denglu1_plugin_setting_sUrl', 'denglu1_plugin', 'denglu1_plugin_settings');
    add_settings_field('denglu1_plugin_setting_publicKey', 'publicKey', 'denglu1_plugin_setting_publicKey', 'denglu1_plugin', 'denglu1_plugin_settings');
    add_settings_field('denglu1_plugin_setting_privateKey', 'privateKey', 'denglu1_plugin_setting_privateKey', 'denglu1_plugin', 'denglu1_plugin_settings');
}

/**
 * 登录易设置页面
 */
function denglu1_render_settings_page()
{
?>
    <h1>登录易设置</h1>
    <form action="options.php" method="post">
        <?php
        settings_fields('denglu1_plugin_options');
        do_settings_sections('denglu1_plugin');
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
    add_options_page('登录易设置', '登录易设置', 'manage_options', 'denglu1_plugin', 'denglu1_render_settings_page');
}
