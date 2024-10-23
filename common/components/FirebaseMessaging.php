<?php

namespace  common\components;

use Google\Client;
use Yii;

class FirebaseMessaging
{
    private $serviceAccountPath;
    private $projectId = 'walkintothewild-24344';
    private $client;

    public function __construct()
    {
        $this->serviceAccountPath = Yii::getAlias('@common/config/service.json');
        $this->client = new Client();
        $this->client->setAuthConfig($this->serviceAccountPath);
    }

    public function getAccessToken()
    {
<<<<<<< HEAD
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $this->client->useApplicationDefaultCredentials();
        $token = $this->client->fetchAccessTokenWithAssertion();
=======
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        // $client->useApplicationDefaultCredentials();
        $token = $client->fetchAccessTokenWithAssertion();
>>>>>>> 8d21dcba7bc8e800d2b93c57c3efc56b1986e361
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
            \Yii::info(time() . ' Firebase Messaging  ::' . curl_error($ch), 'firebase');

            throw new \Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);
        return json_decode($response, true);
    }



   
}
