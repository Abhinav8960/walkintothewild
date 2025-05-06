<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;

class NewSafariCreatedByUser
{
    public $userId;
    public $email;
    public $name;
    public $template;
    public $channelName;

    protected $channels = [
        // 'email',
        'firebase',
    ];
    protected $mail_template_code = 'URNW'; // New User Registration

    public function __construct($userId, $email, $name)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->broadcast();
    }

    public function broadcast()
    {
        foreach ($this->channels as $channel) {
            $this->channelName = $channel;
            $this->template = $this->getTemplates()[$channel];
            // $this->template['channel'] = $channel;
            $broadcastService = new BroadcastService();
            $broadcastService->send($this, true);
        }
    }

    public function getTemplates()
    {
        $arr = [
            'email' => [
                'subject' => 'Welcome to our platform',
                'mail_template_id'  => $this->emailTemplateId(),
                'params' => [
                    'username' => $this->name,
                    'email' => $this->email,
                ],
                'to_mail' => $this->email,
                'cc' => [],
                'bcc' => [],
            ],
            'firebase' => [
                'master_notification_template_id' => $this->firebaseTemplateId(),
                'title' => 'Welcome!',
                'message' => 'Hello ' . $this->name . ', welcome to our platform!',
                'sent_data' => NULL,
                'user_id' => $this->userId,
                'image_url' => NULL,
                'action' => NULL,
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
