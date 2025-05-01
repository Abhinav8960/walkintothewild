<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;

class NewUserRegistration
{
    public $userId;
    public $email;
    public $name;

    public function __construct($userId, $email, $name)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
    }

    public function broadcast()
    {
        $broadcastService = new BroadcastService();
        $broadcastService->send($this);
    }
}
