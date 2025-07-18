<?php

namespace common\components;

class AesCrypto
{
    public static function encrypt($data, $key)
    {
        $iv = substr($key, 0, 16); // IV should be 16 bytes
        $json = $data;

        if (is_array($data)) {
            // If data is an array, convert it to JSON
            $json = json_encode($data);
        }
        // $encrypted = openssl_encrypt($json, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $encrypted = openssl_encrypt($json, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        return base64_encode($encrypted);
    }

    public static function decrypt($encrypted, $key)
    {
        $iv = substr($key, 0, 16);
        $decoded = base64_decode($encrypted);
        // $decrypted = openssl_decrypt($decoded, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $decrypted = openssl_decrypt($decoded, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        return json_decode($decrypted, true);
    }
}
