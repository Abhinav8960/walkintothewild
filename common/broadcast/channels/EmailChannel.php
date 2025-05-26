<?php

namespace common\broadcast\channels;

use common\models\MailLog;
use common\models\MailLogRecipients;
use common\models\master\email\MasterMailTemplate;

class EmailChannel
{
    const CHANNEL_NAME = 'email';

    public function send($event, $log)
    {
        // // Logic to send email
        // echo "Sending email to {$event->email}\n";
        $log = MailLog::find()->where(['id' => $log->id, 'status' => 2])->limit(100)->orderBy(['id' => SORT_DESC])->one();

        if ($log) {
            $cc = [];
            $bcc = [];
            $attachments = [];
            foreach ($log->ccrecipients as $c) {
                $cc[] = $c->recipient;
            }

            foreach ($log->bccrecipients as $b) {
                $bcc[] = $b->recipient;
            }

            foreach ($log->attachments as $attachment) {
                if ($attachment->file_path && !file_exists($attachment->file_path)) {
                    continue; // Skip if file does not exist

                }
                $attachments[] = $attachment->filepath;
            }

            if ($log->mail_template_id) {
                $template = MasterMailTemplate::find()->where(['id' => $log->mail_template_id, 'status' => 1])->limit(1)->one();
                if ($template) {
                    $mailer =  \Yii::$app->mailer;
                    if (\Yii::$app->params['environment'] != 'production') {
                        $log->torecipient->recipient = \Yii::$app->params['adminEmail'];
                        $bcc = [];
                        $cc = [];
                    }
                    $message = $mailer->compose($template->path, json_decode($log->params, true))
                        // ->setFrom($log->mail_from)
                        ->setFrom(['no-reply@walkintothewild.in' => 'Walk Into The Wild'])
                        ->setTo($log->torecipient->recipient)
                        ->setBcc($bcc)
                        ->setCc($cc)
                        ->setSubject($log->subject)
                        ->setHeaders([
                            'X-SES-CONFIGURATION-SET' => 'DisableClickTracking', // Disables click tracking
                        ])
                        ->send();

                    if ($message) {
                        $m = MailLog::find()->where(['id' => $log->id])->one();

                        $id = $mailer->getSentMessage()->getMessageId();
                        $m->aws_message_id = $log->torecipient->recipient.'-'.$id;
                        $m->try_send_count = $m->try_send_count + 1;
                        $m->status = true;
                        $m->mail_send_time = date('Y-m-d H:i:s');
                        $m->save(false);
                        MailLogRecipients::updateAll([
                            'aws_message_id' => $id,
                        ], ['mail_log_id' => $log->id]);
                    }
                }
            }

            return true;
        }

        return false;
    }
}
