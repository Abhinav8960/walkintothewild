<?php

namespace common\events\chat;

use common\broadcast\services\BroadcastService;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class NewChatMessageSend extends Event
{
    public $receiverUserIds = [];
    public $sender;
    public $message;
    public $chat_hash;
    public $templates;
    public $sent_data;
    public $channelName;
    protected $engine;
    protected $master_notification_template;

    protected $channels = [
        'firebase',
    ];

    public function __construct(array $receiverUserIds, $sender, $message, $chat_hash, $sent_data)
    {
        $this->receiverUserIds       = $receiverUserIds;
        $this->sender               = $sender;
        $this->message              = $message;
        $this->chat_hash            = $chat_hash;
        $this->sent_data            = $sent_data;
        $this->engine               = \Yii::$app->engine;
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
            'firebase' => $this->prepareFirebaseTemplate()
            // Add more templates for other channels as needed
        ];
        return $arr;
    }


    protected function firebaseTemplateId()
    {
        $this->master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::CHAT_MESSAGE_RECEIVED_REGISTRATION_TEMPLATE, 'status' => 1])->limit(1)->one();
        if ($this->master_notification_template) {
            return $this->master_notification_template->id;
        }
        return null;
    }

    private function title()
    {
        return $this->engine->render($this->master_notification_template->title, ['sender' => $this->sender]);
    }
    private function message()
    {
        return $this->engine->render($this->master_notification_template->message, ['message' => $this->message]);
    }

    private function prepareFirebaseTemplate()
    {
        foreach ($this->receiverUserIds as $userId) {
            $arr[] =  [
                'master_notification_template_id'   => $this->firebaseTemplateId(),
                'title'                             => $this->title(),
                'message'                           => $this->message(),
                'sent_data'                         => [
                                                            'chat_hash' =>   $this->chat_hash,
                                                            'addtional_data' =>   json_decode($this->sent_data)
                                                        ],
                'user_id'                           => $userId,
                'image_url'                         => NULL,
                'action'                            => NULL,
            ];
        }

        return $arr;
    }
}
