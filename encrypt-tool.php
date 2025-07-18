<?php

// Standalone encryption tool for Postman testing

// Bootstrap the necessary Yii2 files
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/config/bootstrap.php';
require __DIR__ . '/frontend/config/bootstrap.php';

// Manually include your component if it's not autoloaded properly
require __DIR__ . '/common/components/AesCrypto.php';

// --- CONFIGURE YOUR TEST DATA HERE ---

// 1. This key MUST match the key used in your controller

$encryptionKey = 'Q1r2S3t4U5v6W7x8';
// 2. This is the data you want to send
// $data_to_encrypt = [
//     'comment' => 'testing',
//     // 'password' => 'a-very-secret-password-123',
//     // 'some_other_field' => 'value123'
// ];
$data_to_encrypt = "Hello, this is a test string for encryption!";

// 3. Encrypt the data (assuming your encrypt function takes a string)
// $encrypted_string = \common\components\AesCrypto::encrypt(json_encode($data_to_encrypt), $encryptionKey);
$encrypted_string = \common\components\AesCrypto::encrypt($data_to_encrypt, $encryptionKey);

// --- DO NOT EDIT BELOW ---
echo "Paste the following string into your Postman request body:\n\n";
echo $encrypted_string;
echo "\n";