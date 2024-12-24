<?php

namespace console\controllers;

use common\components\FirebaseMessaging;
use common\models\firebasenotification\FirebaseNotificationLog;
use common\models\UserSession;
use yii\console\Controller;



/**
 * Main Controller for YII Console
 */
class SendNotificationController extends Controller
{

    /**
     * Console Working Check
     *
     * @return void
     */

    public function actionIndex()
    {
        if ($this->sendNotification()) {
            echo date('Y-m-d H:i:s') . ' - Notification Sent Successfully' . PHP_EOL;
        } else {
            echo "No notification to send" . PHP_EOL;
        }
    }

    /**
     * Notification Send
     *
     * @return void
     */
    protected function sendnotification()
    {
        $logs = FirebaseNotificationLog::find()->where(['status' => 1, 'is_cron_run' => 0])->limit(100)->orderBy(['id' => SORT_DESC])->all();
        if ($logs) {
            foreach ($logs as $log) {
                $data = !empty($log->sent_data) ? json_decode($log->sent_data,true) : [];
                $title = ucfirst($log->title);
                $body =  $log->message;
                $imageUrl = $log->image_url;
                $token = $this->firebaseTokens($log->user_id);
                $topic = NULL;
                $condition = NULL;
                if ($token) {
                    $title = $log->title;
                    \Yii::$app->firebase->sendMulticastNotification($title, $body, $imageUrl, $token, $data, $topic = NULL, $condition = NULL);
                }

                $log->is_cron_run = 1;
                $log->save(false);
            }
        }
    }




    private function firebaseTokens($userId)
    {
        $uds =  UserSession::find()
            ->where(['user_id' => $userId, 'app_name' => 'Api'])
            ->andWhere(['not', ['firebase_token' => null]])
            ->andWhere(['!=', 'firebase_token', ''])
            ->andWhere(['is_firebase_token_active' => 1])
            ->limit(1)
            ->all();
        $tokens = [];
        foreach ($uds as $ud) {
            $tokens[] = $ud->firebase_token;
        }
        $array = array_unique($tokens);

        return $array;
    }

    // protected function sendnotification()
    // {
    //     $firebaseMessaging = new FirebaseMessaging();
    //     $message = [
    //         'token' => 'dO3bQRF-S2S4NWiznD1QQc:APA91bHtYDjv_trf_xE0P9p5hJYvvXTMHjF6WZQhEPbKDXNm49AfVbg5e_nPDNkajQvTXqHYxKf2JhhMDnGT4cGtLxfw8dB7sPSNDBOoUjkvYRep9_VYmt0',
    //         'notification' => [
    //             'title' => 'check',
    //             'body' => 'Error',

    //         ],
    //         'data' =>
    //         [
    //             "objective" => "Share Safari",
    //         ]
    //         // 'data' => 'Share Safari',

    //     ];
    //     try {
    //         $accessToken = $firebaseMessaging->getAccessToken();

    //         $response = $firebaseMessaging->sendMessage($accessToken, $message);
    //         dd($response);
    //         if (isset($response['error'])) {
    //             echo 'Firebase error: ' . json_encode($response['error']);
    //         }
    //     } catch (\Exception $e) {
    //         echo 'Notification send error: ' . $e->getMessage(), 'firebase';
    //         echo $e->getMessage();
    //     }
    // }
}
