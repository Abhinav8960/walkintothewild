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
            foreach ($log->ccrecipients as $c) {
                $cc[] = $c->recipient;
            }

            foreach ($log->bccrecipients as $b) {
                $bcc[] = $b->recipient;
            }

            if ($log->mail_template_id) {
                $template = MasterMailTemplate::find()->where(['id' => $log->mail_template_id, 'status' => 1])->limit(1)->one();
                if ($template) {
                    $mailer =  \Yii::$app->mailer;
                    $message = $mailer->compose($template->path, json_decode($log->params, true))
                        // ->setFrom($log->mail_from)
                        ->setFrom(['no-reply@walkintothewild.in' => 'Walk Into The Wild'])
                        ->setTo($log->torecipient->recipient)
                        ->setBcc($bcc)
                        ->setCc($cc)
                        ->setSubject($log->subject)
                        ->send();

                    if ($message) {
                        $m = MailLog::find()->where(['id' => $log->id])->one();

                        $id = $mailer->getSentMessage()->getMessageId();
                        $m->aws_message_id = $id;
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
