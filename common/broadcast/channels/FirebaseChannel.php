<?php

namespace common\broadcast\channels;

use common\models\firebasenotification\FirebaseNotificationLog;
use common\models\UserSession;

class FirebaseChannel
{
    const CHANNEL_NAME = 'firebase';


    public function send($event, $log)
    {
        // print_r($log);
        // die();
        $logs = FirebaseNotificationLog::find()->where(['id' => $log->id, 'status' => 1, 'is_cron_run' => 0])->limit(100)->orderBy(['id' => SORT_DESC])->one();
        if ($logs) {
            $data = !empty($log->sent_data) ? json_decode($log->sent_data, true) : [];
            
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
            $log->is_send = 1;
            $log->is_cron_run = 1;
            $log->send_datetime = date('Y-m-d H:i:s');
            $log->save(false);
        }
    }

    private function firebaseTokens($userId)
    {
        $uds =  UserSession::find()
            // ->where(['user_id1' => $userId, 'app_name' => 'Api'])
            ->where(['user_id' => $userId])
            ->andWhere(['not', ['firebase_token' => null]])
            ->andWhere(['!=', 'firebase_token', ''])
            ->andWhere(['is_firebase_token_active' => 1])
            ->all();
        $tokens = [];
        foreach ($uds as $ud) {
            $tokens[] = $ud->firebase_token;
        }
        $array = array_unique($tokens);

        return $array;
    }

    
}
