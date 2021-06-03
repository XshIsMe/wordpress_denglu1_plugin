<h2>帮助</h2>
<div>
    <p>
        <a href="https://open.denglu.net.cn/web/pages/index.html">登录易开放平台</a>
    <p>
        <span>应用的登录地址：</span>
        <?php echo esc_html(home_url('/Denglu1Login')) ?>
    </p>
    <p>
        <span>登录重定向地址：</span>
        <?php echo esc_html(home_url('/Denglu1LoginByToken')) ?>
    </p>
    <p>
        <span>应用的注册地址：</span>
        <?php echo esc_html(home_url('/Denglu1Register')) ?>
    </p>
    <p>
        <span>注册重定向地址：</span>
        <?php echo esc_html(home_url('/Denglu1LoginByToken')) ?>
    </p>
    <p>
        <span>应用的改密地址：</span>
        <?php echo esc_html(home_url('/Denglu1ModifyPassword')) ?>
    </p>
    <p>
        <span>改密重定向地址：</span>
        <?php echo esc_html(home_url('/Denglu1LoginByToken')) ?>
    </p>
</div>
<h2>参数</h2>
<div>
    <p>
        <label for="denglu1_option_appId">appId</label><br>
        <input id='denglu1_option_appId' name='<?php echo esc_attr($opId) ?>[appId]' type='text' value='<?php echo esc_attr($options['appId']) ?>' />
    </p>
    <p>
        <label for="denglu1_option_sUrl">sUrl</label><br>
        <input id='denglu1_option_sUrl' name='<?php echo esc_attr($opId) ?>[sUrl]' type='text' value='<?php echo esc_attr($options['sUrl']) ?>' />
    </p>
    <p>
        <label for="denglu1_option_publicKey">publicKey</label><br>
        <textarea id='denglu1_option_publicKey' name='<?php echo esc_attr($opId) ?>[publicKey]'><?php echo esc_html($options['publicKey']) ?></textarea>
    </p>
    <p>
        <label for="denglu1_option_privateKey">privateKey</label><br>
        <textarea id='denglu1_option_privateKey' name='<?php echo esc_attr($opId) ?>[privateKey]'><?php echo esc_html($options['privateKey']) ?></textarea>
    </p>
</div>