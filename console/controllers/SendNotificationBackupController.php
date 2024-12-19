<?php

namespace console\controllers;

use common\components\FirebaseMessaging;
use common\models\firebasenotification\FirebaseNotificationLog;
use common\models\UserSession;
use yii\console\Controller;



/**
 * Main Controller for YII Console
 */
class SendNotificationBackupController extends Controller
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
                $firebase = UserSession::find()
                    ->where(['user_id' => $log->user_id, 'app_name' => 'Api'])
                    ->andWhere(['not', ['firebase_token' => null]])
                    ->andWhere(['!=', 'firebase_token', ''])
                    ->andWhere(['is_firebase_token_active' => 1])
                    ->limit(1)
                    ->one();
                if ($firebase) {
                    $firebaseMessaging = new FirebaseMessaging();
                    $message = [
                        'token' => $firebase->firebase_token,
                        'notification' => [
                            'title' => $log->title,
                            'body' => $log->message,
                            'image' => $log->image_url,
                        ],
                    ];

                    if (!empty($log->sent_data)) {
                        $message['data'] = $log->sent_data;
                    }
                    try {
                        $accessToken = $firebaseMessaging->getAccessToken();
                        $response = $firebaseMessaging->sendMessage($accessToken, $message);
                        if (isset($response['error'])) {;
                            $this->tokendisabled($firebase->firebase_token);
                            echo 'Firebase error: ' . json_encode($response['error']);
                        }
                        $log->is_send = 1;
                    } catch (\Exception $e) {
                        $this->tokendisabled($firebase->firebase_token);
                        echo 'Notification send error: ' . $e->getMessage(), 'firebase';
                    }
                }

                $log->is_cron_run = 1;
                $log->save(false);
            }
        }
    }


    private function tokendisabled($token)
    {
        $user = UserSession::find()->where(['firebase_token' => $token])->limit(1)->one();
        if ($user) {
            $user->is_firebase_token_active = 0;
            $user->save(false);
        }
        return true;
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
