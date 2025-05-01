<?php

namespace common\broadcast\services;

use common\broadcast\channels\EmailChannel;
use common\broadcast\channels\FirebaseChannel;
use common\broadcast\channels\SmsChannel;
use common\broadcast\channels\WhatsappChannel;
use common\models\MailLog;
use common\models\MailLogRecipients;
use common\models\master\email\MasterMailTemplate;
use common\models\master\broadcast\MasterChannelTemplate;
use common\queue\QueueService;

class BroadcastService
{
    protected $channels;
    public $template;


    public function __construct($channels = [new EmailChannel(), new FirebaseChannel(), new SmsChannel(), new WhatsappChannel()])
    {
        $this->channels = $channels;
    }


    /**
     * Send the event immediately.
     */
    public function sendImmediately($event)
    {
        $this->template = get_class($event);

        foreach ($this->channels as $channel) {
            $template = MasterChannelTemplate::find()->where(['channel' => $channel::CHANNEL_NAME, 'template' => SELF::className($this->template), 'status' => 1])->limit(1)->one();

            if ($template) {
                $event->template = $template;
                $this->storeInLog($event, $channel);
                $channel->send($event);
            }
        }
    }

    /**
     * Queue the event for later processing.
     */
    public function queue($event)
    {
        $queueService = new QueueService();
        $queueService->addToQueue($event);
    }

    /**
     * Handle sending based on the mode (immediate or queued).
     */
    public function send($event, $immediate = false)
    {

        if ($immediate) {
            $this->sendImmediately($event);
        } else {
            $this->queue($event);
        }
    }

    public function storeInLog($event, $channel)
    {
        // Store the event in the log
        $logData = [
            'event_type' => get_class($event),
            'channel' => get_class($channel),
            'event_data' => json_encode($event),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Here you would typically save to a database or a file
        // For demonstration, we'll just print it
        echo "Logging event: " . json_encode($logData) . "\n";
        // Example: $this->db->createCommand()->insert('event_log', $logData)->execute();
        // Or use a logging library
        // Example: Yii::info($logData, 'event_log');
        // For demonstration, we'll just print it
    }

    public function sendToAll($event)
    {
        foreach ($this->channels as $channel) {
            $channel->send($event);
        }
    }

    public function sendToChannel($event, $channel)
    {
        foreach ($this->channels as $ch) {
            if (get_class($ch) === $channel) {
                $ch->send($event);
            }
        }
    }

    // public static function getChannel($channelName)
    // {

    //     $channels = [
    //         EmailChannel::CHANNEL_NAME => new EmailChannel(),
    //         FirebaseChannel::CHANNEL_NAME => new FirebaseChannel(),
    //         SmsChannel::CHANNEL_NAME => new SmsChannel(),
    //         WhatsappChannel::CHANNEL_NAME => new WhatsappChannel(),
    //     ];

    //     return $channels[$channelName] ?? null;
    // }

    public static function BroadcastEvent($event, $immediate = false)
    {
        $service = new self();
        $service->send($event, $immediate);
    }

    public static function createMailLog($mail_to, $subject, $mail_template_id, $params, $cc = [], $bcc = [])
    {
        $template = MasterChannelTemplate::find()->where(['channel' => EmailChannel::CHANNEL_NAME, 'template' => '', 'status' => 1])->limit(1)->one();
        if ($template) {
            $mail_from = 'no-reply@walkintothewild.in';
            $log = new MailLog();
            // $log->mail_to = $mail_to;
            // $log->mail_from = $mail_from;
            $log->subject = $subject;
            $log->mail_template_id = $template->id;
            $log->params = json_encode($params, true);
            $log->status = 2; // Mail Not Send

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
            }

            //add log id return parameter 
            $temp = json_decode($log->params);
            $temp->log_id = $log->id;
            $temp = json_encode($temp, true);
            return true;
        }
    }

    public static function className($namespace)
    {
        // Replace backslashes with forward slashes for pathinfo
        return  pathinfo(str_replace('\\', '/', $namespace), PATHINFO_FILENAME);
    }
}
