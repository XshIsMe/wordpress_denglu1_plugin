<?php

/**
 * 登录易插件设置页面
 */


// 页面回调函数
function denglu1_settings_page_cb()
{
    require dirname(__FILE__) . '/denglu1-config.php';
    require_once dirname(__FILE__) . '/denglu1-log.php';

?>
    <form action=options.php method=post>
        <?php
        settings_fields($DENGLU1_CONFIG['settings_group_id']);     // 设置组ID
        do_settings_sections($DENGLU1_CONFIG['settings_page_id']); // 设置页面ID
        submit_button('保存');                                     // 输出保存按钮
        denglu1_show_log();                                        // 输出日志
        ?>
    </form>
<?php
}

// 分节回调函数
function denglu1_settings_section_cb()
{
    require dirname(__FILE__) . '/denglu1-config.php';

    $op_id = $DENGLU1_CONFIG['settings_option_id'];
    $options = get_option($op_id);

?>
    <h2>帮助</h2>
    <div>
        <p>
            <a href="https://open.denglu.net.cn/web/pages/index.html">登录易开放平台</a>
        <p>
            <span>应用的登录地址：</span>
            <?php echo esc_html(home_url('/denglu1_login')) ?>
        </p>
        <p>
            <span>登录重定向地址：</span>
            <?php echo esc_html(home_url('/denglu1_loginByToken')) ?>
        </p>
        <p>
            <span>应用的注册地址：</span>
            <?php echo esc_html(home_url('/denglu1_register')) ?>
        </p>
        <p>
            <span>注册重定向地址：</span>
            <?php echo esc_html(home_url('/denglu1_loginByToken')) ?>
        </p>
        <p>
            <span>应用的改密地址：</span>
            <?php echo esc_html(home_url('/denglu1_modifyPass')) ?>
        </p>
        <p>
            <span>改密重定向地址：</span>
            <?php echo esc_html(home_url('/denglu1_loginByToken')) ?>
        </p>
    </div>
    <h2>参数</h2>
    <div>
        <p>
            <label for="denglu1_option_appId">appId</label><br>
            <input id='denglu1_option_appId' name='<?php echo esc_attr($op_id) ?>[appId]' type='text' value='<?php echo esc_attr($options['appId']) ?>' />
        </p>
        <p>
            <label for="denglu1_option_sUrl">sUrl</label><br>
            <input id='denglu1_option_sUrl' name='<?php echo esc_attr($op_id) ?>[sUrl]' type='text' value='<?php echo esc_attr($options['sUrl']) ?>' />
        </p>
        <p>
            <label for="denglu1_option_publicKey">publicKey</label><br>
            <textarea id='denglu1_option_publicKey' name='<?php echo esc_attr($op_id) ?>[publicKey]'><?php echo esc_html($options['publicKey']) ?></textarea>
        </p>
        <p>
            <label for="denglu1_option_privateKey">privateKey</label><br>
            <textarea id='denglu1_option_privateKey' name='<?php echo esc_attr($op_id) ?>[privateKey]'><?php echo esc_html($options['privateKey']) ?></textarea>
        </p>
    </div>
<?php
}

// 设置页面初始化函数
function denglu1_settings_page_init()
{
    require dirname(__FILE__) . '/denglu1-config.php';

    // 为管理员菜单添加新页面
    add_menu_page(
        $DENGLU1_CONFIG['page_title'],       // 浏览器标题中显示的名称
        $DENGLU1_CONFIG['menu_title'],       // 管理员菜单中显示的名称
        'manage_options',
        $DENGLU1_CONFIG['settings_page_id'], // 设置页面ID
        'denglu1_settings_page_cb'           // 用来展示设置页面的回调函数
    );
}

// 设置页面内容初始化函数
function denglu1_settings_init()
{
    require dirname(__FILE__) . '/denglu1-config.php';

    // 为页面注册新设置
    register_setting(
        $DENGLU1_CONFIG['settings_group_id'], // 设置组ID
        $DENGLU1_CONFIG['settings_option_id'] // 设置选项ID
    );
    // 在页面上注册新分节
    add_settings_section(
        $DENGLU1_CONFIG['settings_section_id'], // 分节ID
        $DENGLU1_CONFIG['section_title'],       // 分节标题
        'denglu1_settings_section_cb',          // 回调函数
        $DENGLU1_CONFIG['settings_page_id']     // 设置页面ID
    );
}
