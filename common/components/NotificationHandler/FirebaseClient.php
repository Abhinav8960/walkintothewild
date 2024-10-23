<?php

namespace common\components\NotificationHandler;



class FirebaseClient
{
    private $factory;
    private $messaging;

    // public function __construct()
    // {
    //     $config = require \Yii::getAlias('@common/config/google_services.json');
    //     $this->factory = (new Factory)->withServiceAccount($config);
    //     $this->messaging = $this->factory->createMessaging();
    // }

    public function sendNotification($title, $body, $token, $data = [], $imageUrl = NULL)
    {
       
    }

    public function MultipleDevicesendNotification($title, $body, $token)
    {
        
    }
}
