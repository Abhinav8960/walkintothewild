<?php

namespace common\Helper;

use Exception;
use yii\base\BaseObject;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Firebase Notification Helper for sending notifications via FCM.
 */
class FirebaseNotificationHelper extends BaseObject
{
    /**
     * @var string the Firebase Cloud Messaging server key or OAuth token.
     */
    public $authKey;

    /**
     * @var string the project ID from Firebase settings.
     */
    public $projectId;

    /**
     * @var string the API URL for Firebase Cloud Messaging.
     */
    public $apiUrl;

    public function init()
    {
        parent::init();
        if (empty($this->authKey) || empty($this->projectId)) {
            throw new Exception("Firebase credentials are required.");
        }
        $this->apiUrl = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
    }

   
    public function send($body)
    {

        $headers = [
            "Authorization: Bearer {$this->authKey}", 
            'Content-Type: application/json',
        ];
        
        // $ch = curl_init($this->apiUrl);
        // curl_setopt_array($ch, [
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_POST => true,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_HTTPHEADER => $headers,
        //     CURLOPT_POSTFIELDS => json_encode($body),
        // ]);

        // $response = curl_exec($ch);
        // if ($response === false) {
        //     throw new Exception('Curl error: ' . curl_error($ch));
        // }
        // curl_close($ch);

        // return json_decode($response, true);


        $ch = curl_init();
       
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['message' => $body]));
        
       
        $response = curl_exec($ch);
        dd($response);

        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * High-level method to send notification for a specific Firebase token (registration_ids) with FCM.
     *
     * @param array $firebaseToken the registration IDs
     * @param array $notification notification data (title, body, etc.)
     * @param array $options other FCM options
     * @return mixed
     * @throws \Exception if the notification fails to send
     */
    public function sendNotification($firebaseToken = [], $notification, $options = [])
    {
        if (empty($firebaseToken)) {
            throw new \Exception("Firebase token array cannot be empty.");
        }

        $body = [
            'tokens' => $firebaseToken, // Use 'tokens' for multiple recipients
            'notification' => $notification,
        ];

        $body = ArrayHelper::merge($body, $options);
        return $this->send($body);
    }
}
