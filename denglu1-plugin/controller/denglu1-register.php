<?php

function denglu1_register()
{
    require_once dirname(__FILE__) . '/../logic/denglu1-userLogic.php';
    require_once dirname(__FILE__) . '/../util/denglu1-rsa.php';

    // 获取参数
    $sUserName = $_POST['sUserName'];
    $sPassword = $_POST['sPassword'];
    $sEncryptedAESKey = $_POST['sEncryptedAESKey'];

    // 进行解密
    $sPassword = EncryptUtil::rsa_aes_decrypt($sPassword, $sEncryptedAESKey);

    // 业务逻辑处理
    if (userLogic::register($sUserName, $sPassword)) {
        // 将用户名保存在session
        session_start();
        $_SESSION['sUserName'] = $sUserName;
        $_SESSION['sPassword'] = $sPassword;
        $sToken = session_id();
        echo json_encode(array('iCode' => 0, 'sMsg' => 'SUCCESS', 'sToken' => $sToken));
    } else {
        echo json_encode(array('iCode' => -801, 'sMsg' => '用户名已经存在'));
    }
    exit();
}
