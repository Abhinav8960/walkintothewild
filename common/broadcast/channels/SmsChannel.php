<?php

namespace common\broadcast\channels;

class SmsChannel
{
    const CHANNEL_NAME = 'sms';

    public function send($event)
    {
        if (isset($event->phone)) {
            // Logic to send SMS
            echo "Sending SMS to {$event->phone}\n";
        } else {
            echo "No phone number provided for SMS.\n";
        }
    }
}
