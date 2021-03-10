<?php

/**
 * 工具函数
 */


// 加解密
class Denglu1_EncryptUtil
{
    public static function aesEncrypt($sPassword, $sData, $sMethod = "AES-256-CFB8")
    {
        $sIV = chr(0x16) . chr(0x61) . chr(0x0F) . chr(0x3A) . chr(0x37) . chr(0x3D) . chr(0x1B) . chr(0x51) . chr(0x4A) . chr(0x39) . chr(0x5A) . chr(0x79) . chr(0x29) . chr(0x08) . chr(0x01) . chr(0x22);
        $sPassword = base64_decode($sPassword);
        $sPassword = substr(hash('sha256', $sPassword, true), 0, 32);
        $sEncrypted = base64_encode(openssl_encrypt($sData, $sMethod, $sPassword, OPENSSL_RAW_DATA, $sIV));
        return $sEncrypted;
    }

    public static function aesDecrypt($sPassword, $sData, $sMethod = "AES-256-CFB8")
    {
        $sIV = chr(0x16) . chr(0x61) . chr(0x0F) . chr(0x3A) . chr(0x37) . chr(0x3D) . chr(0x1B) . chr(0x51) . chr(0x4A) . chr(0x39) . chr(0x5A) . chr(0x79) . chr(0x29) . chr(0x08) . chr(0x01) . chr(0x22);
        $sPassword = base64_decode($sPassword);
        $sDecrypted = openssl_decrypt(base64_decode($sData), $sMethod, $sPassword, OPENSSL_RAW_DATA, $sIV);
        return $sDecrypted;
    }

    public static function rsaPublicKeyEncrypt($sPublicKey, $sData)
    {
        $res = openssl_get_publickey($sPublicKey);
        //$sData = base64_encode($sData);
        openssl_public_encrypt($sData, $sEncrypt, $res);
        openssl_free_key($res);
        $sEncrypt = base64_encode($sEncrypt);
        return $sEncrypt;
    }

    public static function rsaPrivateKeyDecrypt($sPrivateKey, $sData)
    {
        $res = openssl_get_privatekey($sPrivateKey);
        $sEncrypt = base64_decode($sData);
        openssl_private_decrypt($sEncrypt, $sDecrypt, $res);
        openssl_free_key($res);
        return $sDecrypt;
    }

    public static function rsa_aes_decrypt($sText, $sRasEncryptedKey)
    {
        require dirname(__FILE__) . '/denglu1-config.php';
        $options = get_option($DENGLU1_CONFIG['settings_option_id']);
        return self::aesDecrypt(self::rsaPrivateKeyDecrypt($options['privateKey'], $sRasEncryptedKey), $sText);
    }
}

// 获取当前URL
function denglu1_get_current_url()
{
    // 判断是否是HTTPS
    $pageURL = 'http';
    if ($_SERVER['HTTPS'] == 'on') {
        $pageURL .= 's';
    }
    // 拼接URL
    $pageURL .= '://';
    $this_page = $_SERVER['REQUEST_URI'];
    // 只取?前面的内容
    if (strpos($this_page, '?') !== false) {
        $this_page = reset(explode('?', $this_page));
    }
    // 判断端口
    if ($_SERVER['SERVER_PORT'] != '80' and $_SERVER['SERVER_PORT'] != '443') {
        $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $this_page;
    } else {
        $pageURL .= $_SERVER['SERVER_NAME'] . $this_page;
    }
    return $pageURL;
}

// 获取IP
function denglu1_get_ip()
{
    $ip = null;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}
