<?php

/**
 * @version 1.0
 * RSA AES 解密类
 * @copyright denglu1 tech
 */
class Denglu1EncryptUtil
{
    /**
     * AES编码
     * @param  string $sPassword 密码
     * @param  string $sData     明文
     * @param  string $sIV       加密向量
     * @param  string $sMethod   加密方式(默认：AES-256-CFB)
     * @return string            密文
     */
    public static function aesEncrypt($sPassword, $sData, $sMethod = "AES-256-CFB8")
    {
        $sIV = chr(0x16) . chr(0x61) . chr(0x0F) . chr(0x3A) . chr(0x37) . chr(0x3D) . chr(0x1B) . chr(0x51) . chr(0x4A) . chr(0x39) . chr(0x5A) . chr(0x79) . chr(0x29) . chr(0x08) . chr(0x01) . chr(0x22);
        $sPassword = base64_decode($sPassword);
        $sPassword = substr(hash('sha256', $sPassword, true), 0, 32);
        $sEncrypted = base64_encode(openssl_encrypt($sData, $sMethod, $sPassword, OPENSSL_RAW_DATA, $sIV));
        return $sEncrypted;
    }

    /**
     * AES解码
     * @param  string $sPassword 密码
     * @param  string $sData     密文
     * @param  string $sIV       加密向量
     * @param  string $sMethod   加密方式(默认：AES-256-CFB8)
     * @return string            明文
     */
    public static function aesDecrypt($sPassword, $sData, $sMethod = "AES-256-CFB8")
    {
        $sIV = chr(0x16) . chr(0x61) . chr(0x0F) . chr(0x3A) . chr(0x37) . chr(0x3D) . chr(0x1B) . chr(0x51) . chr(0x4A) . chr(0x39) . chr(0x5A) . chr(0x79) . chr(0x29) . chr(0x08) . chr(0x01) . chr(0x22);
        $sPassword = base64_decode($sPassword);
        $sDecrypted = openssl_decrypt(base64_decode($sData), $sMethod, $sPassword, OPENSSL_RAW_DATA, $sIV);
        return $sDecrypted;
    }

    /**
     * RSA公钥加密
     * @param  string $sPublicKey 公钥
     * @param  string $sData      明文
     * @return string             密文
     */
    public static function rsaPublicKeyEncrypt($sPublicKey, $sData)
    {
        $res = openssl_get_publickey($sPublicKey);
        //$sData = base64_encode($sData);
        openssl_public_encrypt($sData, $sEncrypt, $res);
        openssl_free_key($res);
        $sEncrypt = base64_encode($sEncrypt);
        return $sEncrypt;
    }

    /**
     * RSA密钥解密
     * @param  string $sPrivateKey 私钥
     * @param  string $sData       密文
     * @return string              明文
     */
    public static function rsaPrivateKeyDecrypt($sPrivateKey, $sData)
    {
        $res = openssl_get_privatekey($sPrivateKey, '');
        $sEncrypt = base64_decode($sData);
        openssl_private_decrypt($sEncrypt, $sDecrypt, $res);
        openssl_free_key($res);
        return $sDecrypt;
    }

    /**
     * 用RSA私钥解密出AES密钥，然后用AES密钥解密密文
     * @param  string $sText            密文
     * @param  string $sRsaEncryptedKey 经过RSA加密后的AES密钥
     * @param  string $sPrivateKey      RSA私钥
     * @return string                   明文
     */
    public static function rsaAesDecrypt($sText, $sRsaEncryptedKey, $sPrivateKey)
    {
        return self::aesDecrypt(self::rsaPrivateKeyDecrypt($sPrivateKey, $sRsaEncryptedKey), $sText);
    }
}
