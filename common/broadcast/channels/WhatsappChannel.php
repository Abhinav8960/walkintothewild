<?php

namespace common\broadcast\channels;

class WhatsappChannel
{
    const CHANNEL_NAME = 'whatsapp';

    public function send($event)
    {
        if (isset($event->phone)) {
            // Logic to send SMS
            echo "Sending Whatsapp to {$event->phone}\n";
        } else {
            echo "No phone number provided for whatsapp.\n";
        }
    }
}
