<?php

namespace common\events\user;

class NewUserRegistration
{
    public $userId;
    public $email;
    public $name;
    public $phone;

    public function __construct($userId, $email, $name)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
    }
}
