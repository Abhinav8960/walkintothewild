<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;

class NewUserRegistration
{
    public $userId;
    public $email;
    public $name;
    public $template;

    protected $channels = [
        'email',
        'firebase',
    ];
    protected $mail_template_code = 'URNW'; // New User Registration

    public function __construct($userId, $email, $name)
    {
        // $this->channels = [
        //     'email',
        //     'firebase',
        // ];

        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->broadcast();
    }

    public function broadcast()
    {
        foreach ($this->channels as $channel) {
            $this->template = $this->getTemplates()[$channel];
            // $this->template['channel'] = $channel;
            $broadcastService = new BroadcastService();
            $broadcastService->send($this);
        }
    }

    public function getTemplates()
    {
        $arr = [
            'email' => [
                'subject' => 'Welcome to our platform',
                'mail_template_id'  => $this->emailTemplateId(),
                'params' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
                // 'viewPath' => '@common/mail/user/new_user_registration',


            ],
            'firebase' => [
                'title' => 'Welcome!',
                'message' => 'Hello ' . $this->name . ', welcome to our platform!',
                'send_data' => json_encode([]),
                'image_url' => '',
                'user_id' => $this->userId,
            ],
            // Add more templates for other channels as needed
        ];
        return $arr;
    }

    protected function emailTemplateId()
    {
        $template = MasterMailTemplate::find()->where(['code' => $this->mail_template_code, 'status' => 1])->limit(1)->one();
        if ($template) {
            return $template->id;
        }
        return null;
    }

    protected function firebaseTemplateId()
    {
        $template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::NEW_USER_REGISTRATION_TEMPLATE, 'status' => 1])->limit(1)->one();
        if ($template) {
            return $template->id;
        }
        return null;
    }
}
