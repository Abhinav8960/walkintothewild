<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class NewChatMessageReceived extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;

    protected $channels = [
        'firebase',
    ];

    public function __construct($userId, $email, $name)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->broadcastHandle();
    }

    public function broadcastHandle()
    {
        foreach ($this->channels as $channel) {
            $this->channelName = $channel;
            $this->templates = $this->getTemplates()[$channel];
            // $this->template['channel'] = $channel;
            $broadcastService = new BroadcastService();
            $broadcastService->send($this, true);
        }
    }

    public function getTemplates()
    {
        $arr = [           

            'firebase' => [
                [
                    'master_notification_template_id' => $this->firebaseTemplateId(),
                    'title' => 'Welcome!',
                    'message' => 'Hello ' . $this->name . ', welcome to our platform!',
                    'sent_data' => NULL,
                    'user_id' => $this->userId,
                    'image_url' => NULL,
                    'action' => NULL,
                ]
            ],
            // Add more templates for other channels as needed
        ];
        return $arr;
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
