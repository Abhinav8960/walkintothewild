<?php

namespace common\broadcast\queue;

use common\models\firebasenotification\FirebaseNotificationLog;
use common\models\MailLogRecipients;
use common\models\master\email\MasterMailTemplate;

class QueueService
{


    /**
     * Add an event to the queue.
     */
    public function addToQueue($channelName, $template)
    {
        
        if ($channelName == 'email') {
            $log =  $this->emailLog($template);
        } elseif ($channelName == 'firebase') {
            $log = $this->firebaseLog($template);
        } elseif ($channelName == 'sms') {
            $log = $this->smsLog($template);
        }
        return $log;
    }

    private function emailLog($template)
    {
    
        // $mail_from = 'no-reply@walkintothewild.in';
        $log = new \common\models\MailLog();
        $log->subject = $template['subject'];
        $log->mail_template_id = $template['mail_template_id'];
        $log->params = NULL;
        if (is_array($template['params'])) {
            $log->params = json_encode($template['params'], true);
        } else {
            $log->params = $template['params'];
        }
        $log->status = 2; // Mail Not Send

        if (isset($template['cc'])) {
            $cc = $template['cc'];
        }
        if (isset($template['bcc'])) {
            $bcc = $template['bcc'];
        }
        $mail_to = $template['to_mail'];
        if ($log->save(false)) {
            if (!empty($mail_to)) {
                $m = new MailLogRecipients();
                $m->mail_log_id = $log->id;
                $m->recipient = $mail_to;
                $m->send_as = MailLogRecipients::SEND_AS_TO_RECIPIENTS;
                $m->save(false);
            }
            if (!empty($cc) && is_array($cc)) {
                foreach ($cc as $c) {
                    $m = new MailLogRecipients();
                    $m->mail_log_id = $log->id;
                    $m->recipient = $c;
                    $m->send_as = MailLogRecipients::SEND_AS_CC_RECIPIENTS;
                    $m->save(false);
                }
            }
            if (!empty($bcc) && is_array($bcc)) {
                foreach ($bcc as $b) {
                    $m = new MailLogRecipients();
                    $m->mail_log_id = $log->id;
                    $m->recipient = $b;
                    $m->send_as = MailLogRecipients::SEND_AS_BCC_RECIPIENTS;
                    $m->save(false);
                }
            }


            // self::sendmail($log);
        } else {
            return "Failed to log email event: " . json_encode($log->getErrors()) . "\n";
        }
        return $log;
    }

    private function firebaseLog($template)
    {   
        $user_id = $template['user_id'];
        $master_notification_template_id = $template['master_notification_template_id'];
        $title = $template['title'] ?? NULL;
        $message = $template['message'] ?? NULL;
        $sent_data = NULL;
        // if (is_array($template['sent_data'])) {
        // } else {
        //     $sent_data =  !empty($template['sent_data'])  ?  json_decode($template['sent_data']) : NULL;
        // }
        $sent_data =  !empty($template['sent_data'])  ?  $template['sent_data'] : NULL;


        $image_url = $template['image_url'] ?? NULL;
        $action = $template['action'] ?? NULL;
        $model = new FirebaseNotificationLog();
        $model->master_notification_template_id = $master_notification_template_id;
        $model->title = ($title !== null) ? $title :  NULL;
        $model->message = ($message !== null) ? trim($message) : NULL;
        $model->sent_data = ($sent_data !== null) ? $sent_data :  NULL;
        $model->image_url = ($image_url !== null) ? $image_url :  NULL;
        $model->action = ($action !== null) ? $action : NULL;
        $model->user_id = $user_id;
        $model->is_send = 0;
        $model->is_cron_run = 0;
        $model->status = 1;
        $model->created_by = isset(\Yii::$app->user->identity) ? \Yii::$app->user->identity->id : \Yii::$app->params['active_user_id'];

        $model->save(false);
        return $model;
    }

    private function smsLog($template)
    {
        $log = new \common\models\SmsLog();
        $log->user_id = $template['user_id'];
        $log->phone_no = $template['phone_no'];
        $log->template_id = $template['template_id'];
        $log->route = $template['route'];
        $log->params = NULL;
        if (is_array($template['params'])) {
            $log->params = json_encode($template['params'], true);
        } else {
            $log->params = $template['params'];
        }
        $log->status = 0; // Mail Not Send
        $log->created_by = isset(\Yii::$app->user->identity) ? \Yii::$app->user->identity->id : \Yii::$app->params['active_user_id'];
        $log->updated_by = isset(\Yii::$app->user->identity) ? \Yii::$app->user->identity->id : \Yii::$app->params['active_user_id'];
        
        $log->save(false);
        return $log;
    }

    /**
     * Process all queued events.
     */
    // public function processQueue()
    // {

    //     $events = \common\models\EventQueue::find()
    //         ->where(['processed_at' => null])
    //         ->all();

    //     foreach ($events as $event) {
    //         $event = json_decode($event->event_data); // Recreate the event object
    //         echo "Processing queued event for user {$event->userId}\n";

    //         // Logic to send the event (e.g., call BroadcastService::sendImmediately)
    //         $broadcastService = new \common\broadcast\services\BroadcastService();
    //         $broadcastService->sendImmediately($event);

    //         $event->processed_at = date('Y-m-d H:i:s');
    //         $event->save();
    //     }
    // }
}
