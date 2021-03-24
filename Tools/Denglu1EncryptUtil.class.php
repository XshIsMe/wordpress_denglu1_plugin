<?php

class Denglu1EncryptUtil
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
        $res = openssl_get_privatekey($sPrivateKey, '');
        $sEncrypt = base64_decode($sData);
        openssl_private_decrypt($sEncrypt, $sDecrypt, $res);
        openssl_free_key($res);
        return $sDecrypt;
    }

    public static function rsaAesDecrypt($sText, $sRasEncryptedKey, $sPrivateKey)
    {
        return self::aesDecrypt(self::rsaPrivateKeyDecrypt($sPrivateKey, $sRasEncryptedKey), $sText);
    }
}
