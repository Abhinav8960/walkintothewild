<?php

namespace common\broadcast\channels;

class FirebaseChannel
{
    const CHANNEL_NAME = 'firebase';


    public function send($event)
    {
        // Logic to send Firebase notification
        echo "Sending Firebase notification for user {$event->userId}\n";
    }
}