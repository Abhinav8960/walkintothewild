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
        parent::init(); // Call the parent init method
        if (empty($this->authKey)) {
            throw new \Exception("Empty authKey");
        }
        if (empty($this->projectId)) {
            throw new \Exception("Empty projectId");
        }
        // Set the API URL after projectId is set
        $this->apiUrl = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
    }

    /**
     * Sends raw body to FCM.
     *
     * @param array $body
     * @return mixed
     * @throws \Exception if the request fails
     */
    public function send($body)
    {
        // Adjust the Authorization header based on your auth method
        $headers = [
            "Authorization: key={$this->authKey}", // Use Bearer for OAuth tokens
            'Content-Type: application/json',
        ];

        $ch = curl_init($this->apiUrl);

        curl_setopt_array($ch, [
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($body),
            // CURLOPT_SSL_VERIFYPEER => false, 
            // CURLOPT_TIMEOUT => 30, 
        ]);

        $response = curl_exec($ch);
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
