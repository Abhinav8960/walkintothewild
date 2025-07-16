<?php

namespace common\components;

class AesCrypto
{
    public static function encrypt($data, $key)
    {
        $iv = substr($key, 0, 16); // IV should be 16 bytes
        $json = json_encode($data);
        $encrypted = openssl_encrypt($json, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encrypted);
    }

    public static function decrypt($encrypted, $key)
    {
        $iv = substr($key, 0, 16);
        $decoded = base64_decode($encrypted);
        $decrypted = openssl_decrypt($decoded, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return json_decode($decrypted, true);
    }
}
