<?php

namespace console\controllers;

use common\models\MailLog;
use common\models\MailLogRecipients;
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
        // $this->sendmail();
        if ($this->sendmail()) {

            echo 'Email Send Done';
        } else{
            echo "No email to send";
        }
    }

    /**
     * Credit Leave into Employee Account for this Month
     *
     * @return void
     */
    protected function sendmail()
    {
        $logs = MailLog::find()->where(['status' => 0])->limit(100)->orderBy(['id' => SORT_DESC])->all();

        if ($logs) {

            foreach ($logs as $mail) {
                $cc = [];
                $bcc = [];
                foreach ($mail->ccrecipients as $c) {

                    $cc[] = $c->recipient;
                }

                foreach ($mail->bccrecipients as $b) {

                    $bcc[] = $b->recipient;
                }

                $mailer =  \Yii::$app->mailer;
                $message = $mailer->compose($mail->mail_template_id, json_decode($mail->params, true))
                    // ->setFrom($mail->mail_from)
                    ->setFrom('no-reply@walkintothewild.in')
                    ->setTo($mail->torecipient->recipient)
                    ->setBcc($bcc)
                    ->setCc($cc)
                    ->setSubject($mail->subject)
                    ->send();

                if ($message) {
                    $m = MailLog::find()->where(['id' => $mail->id])->one();

                    $id = $mailer->getSentMessage()->getMessageId();
                    $m->aws_message_id = $id;
                    $m->try_send_count = $m->try_send_count + 1;
                    $m->status = true;
                    $m->mail_send_time = date('Y-m-d H:i:s');
                    $m->save(false);
                    MailLogRecipients::updateAll([
                        'aws_message_id' => $id,
                    ], ['mail_log_id' => $mail->id]);
                }
            }
        }

        return true;
    }
}
