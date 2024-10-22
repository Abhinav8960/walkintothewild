<?php

namespace  common\components;

use Google\Client;
use Yii;

class FirebaseMessaging
{
    private $serviceAccountPath;
    private $projectId;

    public function __construct($projectId)
    {
        $this->serviceAccountPath = Yii::getAlias('@common/config/service.json');
        $this->projectId = $projectId;
    }

    public function getAccessToken()
    {
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        // $client->useApplicationDefaultCredentials();
        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }

    public function sendMessage($accessToken, $message)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/' . $this->projectId . '/messages:send';
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['message' => $message]));
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        return json_decode($response, true);
    }
}
