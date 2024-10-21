<?php

namespace frontend\controllers;

use common\Helper\FirebaseNotificationHelper;
use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;

/**
 * Contact controller
 */
class NotificationController extends FrontendBaseController
{
    public function actionSend()
    {
        $token = 'cZM3VdFASAScms7KuxpAcf:APA91bFsL5_4XNKGWAaA47ZuLaTiHnbXTTm2SUsb7Y2Pb26-FhKzf18xqTa48plEZIX8f27jj5StyWqqL0EkUWU6Scn5vUthTS3QIdeA_7b8Dd7QFXOmxCMJfoY3xRHpbMtxXQXAw7uA'; // Replace with the recipient device token
        $title = 'Test Notification';
        $body = 'This Test Notification !';
        $message = [
            'title' => $title,
            'body' => $body,
        ];

        $service = new FirebaseNotificationHelper(['authKey' => Yii::$app->params['private_key'],'projectId' => Yii::$app->params['project_id']]);

        $response = $service->sendNotification($token, $message);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }
}
