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
        if (\Yii::$app->params['environment'] == "local") {
            if ($this->sendnotification()) {
                echo 'Notification Send Done';
            } else {
                echo "No Notification to send";
            }
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
                        ],
                    ];

                    if (!empty($log->sent_data)) {
                        $message['data'] = json_decode($log->sent_data, true);
                    }
                    try {
                        $accessToken = $firebaseMessaging->getAccessToken();
                        $response = $firebaseMessaging->sendMessage($accessToken, $message);
                        if (isset($response['error'])) {;
                            $this->tokendisabled($firebase->firebase_token);
                            echo 'Firebase error: ' . json_encode($response['error']);
                        }
                        $log->is_send = 1;
                        echo 'Notification Sent';
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
            $user->is_firebase_token = 0;
            $user->save(false);
        }
        return true;
    }

    // protected function sendnotification()
    // {
    //     $firebaseMessaging = new FirebaseMessaging();
    //     $message = [
    //         'token' => 'dhFiI9wTQhqpqNBZeL4MD3:APA91bFvc5JxK3v6yu07s3zG2h0LV6-0crPTN_tvEYV9kqQr5ttWAVB7iaDp-6_eLdnXhGAZ2UK0vOWrB5tijaxbiy9tGb3UcvQfmwSnGxlq9DyIxkRJnGXVOXA6ozrMWilOPUnIMpke',
    //         'notification' => [
    //             'title' => 'check',
    //             'body' => 'Error',
    //         ],
    //         'data' => [
    //             'objective' => 'Error My test',
    //         ]
    //     ];
    //     try {
    //         $accessToken = $firebaseMessaging->getAccessToken();
    //         $response = $firebaseMessaging->sendMessage($accessToken, $message);
    //         if (isset($response['error'])) {
    //             echo 'Firebase error: ' . json_encode($response['error']);
    //         }
    //         echo 'Notification Sent';
    //         // return ['status' => 'success', 'response' => $response];
    //     } catch (\Exception $e) {
    //         echo 'Notification send error: ' . $e->getMessage(), 'firebase';
    //         echo $e->getMessage();
    //         // return ['status' => 'error', 'message' => $e->getMessage()];
    //     }
    // }
}
