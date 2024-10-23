<?php

namespace frontend\controllers;

use common\components\NotificationHandler\FirebaseClient;
use common\components\FirebaseMessaging;
use common\Helper\FirebaseNotificationHelper;
use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;

/**
 * Contact controller
 */
class NotificationController extends FrontendBaseController
{
    // public function actionSend()
    // {
    //     $token = 'cZM3VdFASAScms7KuxpAcf:APA91bFsL5_4XNKGWAaA47ZuLaTiHnbXTTm2SUsb7Y2Pb26-FhKzf18xqTa48plEZIX8f27jj5StyWqqL0EkUWU6Scn5vUthTS3QIdeA_7b8Dd7QFXOmxCMJfoY3xRHpbMtxXQXAw7uA'; // Replace with the recipient device token
    //     $title = 'Test Notification';
    //     $body = 'This Test Notification !';
    //     $notification = [
    //         'title' => $title,
    //         'body' => $body,
    //     ];

    //     $service = new FirebaseNotificationHelper([
    //         'authKey' => Yii::$app->params['firebase']['private_key'],
    //         'projectId' => Yii::$app->params['firebase']['project_id'],
    //     ]);

    //     try {
    //         $response = $service->sendNotification($token, $notification);
    //         return $this->asJson($response);
    //     } catch (\Exception $e) {
    //         return $this->asJson(['error' => $e->getMessage()]);
    //     }
    // }

    public function actionSendNotification()
    {

        $token = 'cZdcYFJ0TTSnVLEhZizrRv:APA91bHZL174NVvaIzt5ftUul7nqlKpJCeJmD5orSxt8yOyjGl1EeZGpSjSBvX9zBrdVqJB2S3GJzFNBQeUJqpmhlYfYW5eqjUCCv0kO5HZJbX-SroOB-tfzkUn4rIeClSpObLKgbEyl';
        // $firebaseMessaging = new FirebaseMessaging();
        // $message = [
        //     'token' => $token,
        //     'notification' => [
        //         'title' => 'Check New Way',
        //         'body' => 'Dynamic Way',
        //     ],
        // ];



        $firebaseClient = new FirebaseClient();
        $firebaseClient->sendNotification('Check New Way', 'Dynamic Way', $token);
        die();


        try {
            $accessToken = $firebaseMessaging->getAccessToken();
            $response = $firebaseMessaging->sendMessage($accessToken, $message);
            return $this->asJson(['status' => 'success', 'response' => $response]);
        } catch (\Exception $e) {
            return $this->asJson(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function actionCheckToken()
    {

        $token = 'cZM3VdFASAScms7KuxpAcf:APA91bFsL5_4XNKGWAaA47ZuLaTiHnbXTTm2SUsb7Y2Pb26-FhKzf18xqTa48plEZIX8f27jj5StyWqqL0EkUWU6Scn5vUthTS3QIdeA_7b8Dd7QFXOmxCMJfoY3xRHpbMtxXQXAw7uA';
        $firebaseMessaging = new FirebaseMessaging();


        try {
            $accessToken = $firebaseMessaging->getAccessToken();
            $response = $firebaseMessaging->isFirebaseTokenActive($accessToken, $token);
            return $this->asJson(['status' => 'success', 'response' => $response]);
        } catch (\Exception $e) {
            return $this->asJson(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
