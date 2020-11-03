<?php

function denglu1_modifyPass()
{
    require_once dirname(__FILE__) . '/../logic/denglu1-userLogic.php';
    require_once dirname(__FILE__) . '/../util/denglu1-rsa.php';

    // 获取参数
    $sUserName = $_POST['sUserName'];
    $sOldPassword = $_POST['sOldPassword'];
    $sNewPassword = $_POST['sNewPassword'];
    $sEncryptedAESKey = $_POST['sEncryptedAESKey'];

    // 进行解密
    $sOldPassword = EncryptUtil::rsa_aes_decrypt($sOldPassword, $sEncryptedAESKey);
    $sNewPassword = EncryptUtil::rsa_aes_decrypt($sNewPassword, $sEncryptedAESKey);

    // 业务逻辑处理
    if (userLogic::modifyPass($sUserName, $sOldPassword, $sNewPassword)) {
        // 将用户名保存在session
        session_start();
        $_SESSION['sUserName'] = $sUserName;
        $_SESSION['sPassword'] = $sNewPassword;
        $sToken = session_id();
        echo json_encode(array('iCode' => 0, 'sMsg' => 'SUCCESS', 'sToken' => $sToken));
    } else {
        echo json_encode(array('iCode' => -800, 'sMsg' => '用户名或者密码错误'));
    }
    exit();
}
