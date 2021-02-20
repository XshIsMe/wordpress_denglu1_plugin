<?php

/**
 * 处理登录
 */


// 添加登录易按钮到登陆页面
function denglu1_add_button()
{
    require dirname(__FILE__) . '/denglu1-config.php';

    $options = get_option($DENGLU1_CONFIG['settings_option_id']);
?>
    <script>
        function denglu1_add_button() {
            // 扫码URL
            let denglu1_appId = "<?php echo esc_attr($options['appId']) ?>";
            let denglu1_sUrl = "<?php echo esc_attr($options['sUrl']) ?>";
            let denglu1_url = "https://qrconnect.denglu.net.cn/connect.php?sAppId=" + denglu1_appId + "&sUrl=" + denglu1_sUrl + "&sType=login&sResType=web";
            // 创建元素
            let denglu1_nav = document.getElementById("nav");
            let denglu1_center = document.createElement("center");
            let denglu1_a = document.createElement("a");
            // 设置属性
            denglu1_a.setAttribute("href", denglu1_url);
            denglu1_a.setAttribute("class", "button");
            denglu1_a.setAttribute("style", "margin-top: 5%; text-decoration: none;");
            // 添加元素
            denglu1_a.innerHTML = "使用登录易登录";
            denglu1_center.appendChild(denglu1_a);
            denglu1_nav.parentNode.insertBefore(denglu1_center, denglu1_nav);
        }
        denglu1_add_button();
    </script>
<?php
}
