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
use common\broadcast\queue\QueueService;

class BroadcastService
{
    // protected $channels;
    public $template;


    // public function __construct($channels = [new EmailChannel(), new FirebaseChannel(), new SmsChannel(), new WhatsappChannel()])
    // public function __construct($channels = [new EmailChannel(), new FirebaseChannel()])
    // {
    //     $this->channels = $channels;
    // }


    /**
     * Send the event immediately.
     */
    public function sendImmediately($event)
    {
        $this->template = get_class($event);
        $template = MasterChannelTemplate::find()->where(['channel' => $event->channel, 'template' => SELF::className($this->template), 'status' => 1])->limit(1)->one();
        $channel = self::getChannel($event->channel);
        if ($template) {
            $event->template = $template;
            $channel->send($event);
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

    // public function storeInLog($event, $channel)
    // {
    //     // Store the event in the log
    //     $logData = [
    //         'event_type' => get_class($event),
    //         'channel' => get_class($channel),
    //         'event_data' => json_encode($event),
    //         'created_at' => date('Y-m-d H:i:s'),
    //     ];
    //     echo "Logging event: " . json_encode($logData) . "\n";
    // }

    // public function sendToAll($event)
    // {
    //     foreach ($this->channels as $channel) {
    //         $channel->send($event);
    //     }
    // }

    // public function sendToChannel($event, $channel)
    // {
    //     foreach ($this->channels as $ch) {
    //         if (get_class($ch) === $channel) {
    //             $ch->send($event);
    //         }
    //     }
    // }

    public static function getChannel($channelName)
    {

        $channels = [
            EmailChannel::CHANNEL_NAME => new EmailChannel(),
            FirebaseChannel::CHANNEL_NAME => new FirebaseChannel(),
            SmsChannel::CHANNEL_NAME => new SmsChannel(),
            WhatsappChannel::CHANNEL_NAME => new WhatsappChannel(),
        ];
        return $channels[$channelName] ?? null;
    }

    // public static function BroadcastEvent($event, $immediate = false)
    // {
    //     $service = new self();
    //     $service->send($event, $immediate);
    // }


    public static function className($namespace)
    {
        // Replace backslashes with forward slashes for pathinfo
        return  pathinfo(str_replace('\\', '/', $namespace), PATHINFO_FILENAME);
    }
}
