<?php

namespace common\jobs;

use common\models\QueueErrorLog;
use common\models\UserSession;
use PhpParser\ErrorHandler\Throwing;
use Throwable;

/**
 * Class NotificationJob.
 */
class NotificationJob extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $model;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            $log = $this->model;
            $data = !empty($log->sent_data) ? json_decode($log->sent_data, true) : [];
            $title = ucfirst($log->title);
            $body =  $log->message;
            $imageUrl = $log->image_url;
            $token = $this->firebaseTokens($log->user_id);
            $topic = NULL;
            $condition = NULL;
            if ($token) {
                $title = $log->title;
                \Yii::$app->firebase->sendMulticastNotification($title, $body, $imageUrl, $token, $data, $topic, $condition);
            }
            $log->is_cron_run = 1;
            $log->is_send = 1;
           return $log->save(false);
        } catch (Throwable $e) {
            $this->logError($queue, $e);
            return false;
        }
    }


    protected function logError($queue, \Exception $error)
    {
        $queue_error_log = new QueueErrorLog();
        $queue_error_log->job_id = $queue->id;
        $queue_error_log->error_message = $error->getMessage();
        $queue_error_log->stack_trace = $error->getTraceAsString();
        $queue_error_log->save(false);
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {

        if ($attempt > 1) {
            $this->logError($this->queue, $error);
        }

        return ($attempt <= 1) && ($error instanceof \Exception);
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
}
