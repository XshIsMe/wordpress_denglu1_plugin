<?php

/**
 * 添加登录易按钮到登陆页面
 */
function add_denglu1_button()
{
    require_once dirname(__FILE__) . '/../config/denglu1-config.php';
?>
    <script>
        function add_denglu1_button() {
            // 扫码URL
            let denglu1_appId = "<?php echo $appId; ?>";
            let denglu1_sUrl = "<?php echo $sUrl; ?>";
            let denglu1_url = "https://qrconnect.denglu.net.cn/connect.php?sAppId=" + denglu1_appId + "&sUrl=" + denglu1_sUrl + "&sType=login&sResType=web";

            // 创建元素
            let denglu1_nav = document.getElementById("nav");
            let denglu1_p = document.createElement("p");
            let denglu1_a = document.createElement("a");

            // 添加元素
            denglu1_a.setAttribute("href", denglu1_url);
            denglu1_a.innerHTML = "使用登录易登录";
            denglu1_p.appendChild(denglu1_a);
            denglu1_nav.parentNode.insertBefore(denglu1_p, denglu1_nav);
        }
        add_denglu1_button();
    </script>
<?php
}
