<?php

namespace common\broadcast\channels;

class EmailChannel
{
    const CHANNEL_NAME = 'email';
    
    public function send($event)
    {
        // Logic to send email
        echo "Sending email to {$event->email}\n";
    }
}