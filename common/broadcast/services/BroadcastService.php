<?php

namespace common\broadcast\services;

use common\broadcast\channels\EmailChannel;
use common\broadcast\channels\FirebaseChannel;
use common\broadcast\channels\SmsChannel;
use common\broadcast\channels\WhatsappChannel;
use common\broadcast\queue\QueueService;

class BroadcastService
{
    // protected $channels;
    // public $template;


    // public function __construct($channels = [new EmailChannel(), new FirebaseChannel(), new SmsChannel(), new WhatsappChannel()])
    // public function __construct($channels = [new EmailChannel(), new FirebaseChannel()])
    // {
    //     $this->channels = $channels;
    // }


    /**
     * Send the event immediately.
     */
    private function sendImmediately($channelName, $template, $log)
    {
        $channel = self::getChannel($channelName);
        return $channel->send($template, $log);
    }

    /**
     * Queue the event for later processing.
     */
    private function queue($channelName, $template)
    {
        $queueService = new QueueService();
        return $queueService->addToQueue($channelName, $template);
    }

    /**
     * Handle sending based on the mode (immediate or queued).
     */
    public function send($event, $immediate = false)
    {
        foreach ($event->templates as $template) {
            $log = $this->queue($event->channelName, $template);
            if ($immediate) {
                $this->sendImmediately($event->channelName, $template, $log);
            }
        }
        return true;
    }



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




    public static function className($namespace)
    {
        // Replace backslashes with forward slashes for pathinfo
        return  pathinfo(str_replace('\\', '/', $namespace), PATHINFO_FILENAME);
    }
}
