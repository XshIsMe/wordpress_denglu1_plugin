<?php

/**
 * 处理请求
 */


// 处理登录请求
function denglu1_login_controller()
{
    require_once dirname(__FILE__) . '/denglu1-userLogic.php';
    require_once dirname(__FILE__) . '/denglu1-functions.php';
    require_once dirname(__FILE__) . '/denglu1-log.php';

    // 判断参数是否存在
    if (isset($_POST['sUserName']) && isset($_POST['sPassword']) && isset($_POST['sEncryptedAESKey']) && isset($_POST['sClientIp'])) {
        // 获取参数
        $sUserName = $_POST['sUserName'];
        $sPassword = $_POST['sPassword'];
        $sEncryptedAESKey = $_POST['sEncryptedAESKey'];
        $sClientIp = $_POST['sClientIp'];
        // 写日志
        denglu1_log($sUserName, $sClientIp, '登录');
        // 分析登录行为
        if (false == denglu1_analyze_action($sUserName)) {
            // 输出结果
            echo json_encode(array('iCode' => -800, 'sMsg' => '登录行为存在风险'));
            exit();
        }
        // 解密参数
        $sPassword = Denglu1_EncryptUtil::rsa_aes_decrypt($sPassword, $sEncryptedAESKey);
        // 业务逻辑处理
        if (denglu1_login_logic($sUserName, $sPassword)) {
            // 将用户名保存在session
            session_start();
            $_SESSION['sUserName'] = $sUserName;
            $_SESSION['sPassword'] = $sPassword;
            $sToken = session_id();
            // 输出结果
            echo json_encode(array('iCode' => 0, 'sMsg' => 'SUCCESS', 'sToken' => $sToken));
        } else {
            // 输出结果
            echo json_encode(array('iCode' => -800, 'sMsg' => '账号名或密码错误'));
        }
        exit();
    }
    // 输出结果
    echo json_encode(array('iCode' => -700, 'sMsg' => '缺少参数'));
    exit();
}

// 处理登陆成功后请求
function denglu1_loginByToken_controller()
{
    require_once dirname(__FILE__) . '/denglu1-functions.php';

    // 判断参数是否存在
    if (isset($_GET['sToken'])) {
        // 获取参数
        $sToken = $_GET['sToken'];
        // 从session中获取用户名
        session_id($sToken);
        session_start();
        // 判断参数是否存在
        if (isset($_SESSION['sUserName']) && isset($_SESSION['sPassword'])) {
            // 获取参数
            $sUserName = $_SESSION['sUserName'];
            $sPassword = $_SESSION['sPassword'];
            // 关闭session
            session_destroy();
            // 登录操作
            if (!is_user_logged_in()) {
                $creds = array();
                $creds['user_login'] = $sUserName;
                $creds['user_password'] = $sPassword;
                $creds['remember'] = false;
                $user = wp_signon($creds);
                if (is_wp_error($user))
                    echo $user->get_error_message();
            }
        }
    }
    // 重定向
    echo '<script>window.location.replace("' . home_url() . '");</script>';
    exit();
}

// 处理修改密码请求
function denglu1_modifyPass_controller()
{
    require_once dirname(__FILE__) . '/denglu1-userLogic.php';
    require_once dirname(__FILE__) . '/denglu1-functions.php';

    // 判断参数是否存在
    if (isset($_POST['sUserName']) && isset($_POST['sOldPassword']) && isset($_POST['sNewPassword']) && isset($_POST['sEncryptedAESKey']) && isset($_POST['sClientIp'])) {
        // 获取参数
        $sUserName = $_POST['sUserName'];
        $sOldPassword = $_POST['sOldPassword'];
        $sNewPassword = $_POST['sNewPassword'];
        $sEncryptedAESKey = $_POST['sEncryptedAESKey'];
        $sClientIp = $_POST['sClientIp'];
        // 写日志
        denglu1_log($sUserName, $sClientIp, '修改密码');
        // 解密参数
        $sOldPassword = Denglu1_EncryptUtil::rsa_aes_decrypt($sOldPassword, $sEncryptedAESKey);
        $sNewPassword = Denglu1_EncryptUtil::rsa_aes_decrypt($sNewPassword, $sEncryptedAESKey);
        // 业务逻辑处理
        if (denglu1_modifyPass_logic($sUserName, $sOldPassword, $sNewPassword)) {
            // 将用户名保存在session
            session_start();
            $_SESSION['sUserName'] = $sUserName;
            $_SESSION['sPassword'] = $sNewPassword;
            $sToken = session_id();
            // 输出结果
            echo json_encode(array('iCode' => 0, 'sMsg' => 'SUCCESS', 'sToken' => $sToken));
        } else {
            // 输出结果
            echo json_encode(array('iCode' => -800, 'sMsg' => '用户名或者密码错误'));
        }
        exit();
    }
    // 输出结果
    echo json_encode(array('iCode' => -700, 'sMsg' => '缺少参数'));
    exit();
}

// 处理注册请求
function denglu1_register_controller()
{
    require_once dirname(__FILE__) . '/denglu1-userLogic.php';
    require_once dirname(__FILE__) . '/denglu1-functions.php';

    // 判断参数是否存在
    if (isset($_POST['sUserName']) && isset($_POST['sPassword']) && isset($_POST['sEncryptedAESKey']) && isset($_POST['sClientIp'])) {
        // 获取参数
        $sUserName = $_POST['sUserName'];
        $sPassword = $_POST['sPassword'];
        $sEncryptedAESKey = $_POST['sEncryptedAESKey'];
        $sClientIp = $_POST['sClientIp'];
        // 写日志
        denglu1_log($sUserName, $sClientIp, '注册');
        // 解密参数
        $sPassword = Denglu1_EncryptUtil::rsa_aes_decrypt($sPassword, $sEncryptedAESKey);
        // 业务逻辑处理
        if (denglu1_register_logic($sUserName, $sPassword)) {
            // 将用户名保存在session
            session_start();
            $_SESSION['sUserName'] = $sUserName;
            $_SESSION['sPassword'] = $sPassword;
            $sToken = session_id();
            // 输出结果
            echo json_encode(array('iCode' => 0, 'sMsg' => 'SUCCESS', 'sToken' => $sToken));
        } else {
            // 输出结果
            echo json_encode(array('iCode' => -801, 'sMsg' => '用户名已经存在'));
        }
        exit();
    }
    // 输出结果
    echo json_encode(array('iCode' => -700, 'sMsg' => '缺少参数'));
    exit();
}
