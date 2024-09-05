<?php

namespace console\controllers;

use common\models\MailLog;
use common\models\MailLogRecipients;
use common\models\master\email\MasterMailTemplate;
use yii\console\Controller;



/**
 * Main Controller for YII Console
 */
class SendMailController extends Controller
{

    /**
     * Console Working Check
     *
     * @return void
     */
    public function actionIndex()
    {
        if (\Yii::$app->params['environment'] == "production") {
            if ($this->sendmail()) {

                echo 'Email Send Done';
            } else {
                echo "No email to send";
            }
        }
    }

    /**
     * Credit Leave into Employee Account for this Month
     *
     * @return void
     */
    protected function sendmail()
    {
        $logs = MailLog::find()->where(['status' => 2])->limit(100)->orderBy(['id' => SORT_DESC])->all();

        if ($logs) {
            foreach ($logs as $log) {
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
                            ->setFrom('no-reply@walkintothewild.in')
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
            }
        }

        return true;
    }
}
