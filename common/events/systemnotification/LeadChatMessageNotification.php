<?php

namespace common\events\systemnotification;

use api\models\chat\Chat;
use common\broadcast\services\BroadcastService;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class LeadChatMessageNotification extends Event
{
    public $receiverUserIds = [];
    public $sender;
    public $sender_user_handle;
    public $message;
    public $objective;
    public $chat_hash;
    public $chat;
    public $templates;
    public $channelName;
    protected $engine;
    protected $master_notification_template;

    protected $channels = [
        'firebase',
    ];

    public function __construct(array $receiverUserIds, $sender, $sender_user_handle, $message, $chat_hash, $chat)
    {
        $this->receiverUserIds      = $receiverUserIds;
        $this->sender               = $sender;
        $this->sender_user_handle   = $sender_user_handle;
        $this->message              = $message;
        $this->objective            =   Chat::OBJECTIVE_QUOTE;
        if ($chat->chat_type == Chat::CHAT_TYPE_DIRECT) {
            $this->objective            =  Chat::OBJECTIVE_DIRECT;
        }
        $this->chat_hash            = $chat_hash;
        $this->chat                 = $chat;
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
        return $this->engine->render($this->master_notification_template->title, ['sender' => "Walk Into The Wild"]);
    }
    private function message()
    {
        return $this->engine->render($this->master_notification_template->message, ['message' => strip_tags($this->message)]);
    }

    private function prepareFirebaseTemplate()
    {
        $arr = [];
        foreach ($this->receiverUserIds as $userId) {
            $arr[] =  [
                'master_notification_template_id'   => $this->firebaseTemplateId(),
                'title'                             => $this->title(),
                'message'                           => $this->message(),
                'is_system_notification'            => 1,
                // 'sent_data'                         => $this->sent_data,
                'sent_data'                         => $this->preparesenddata(),
                'user_id'                           => $userId,
                'image_url'                         => NULL,
                'action'                            => NULL,
            ];
        }

        return $arr;
    }

    private function preparesenddata()
    {
        if ($this->chat->chat_type == Chat::CHAT_TYPE_DIRECT) {

            return MasterNotificationTemplate::prepareSendData($this->title(), $this->message(), ['objective' => $this->objective, 'chat_hash' => $this->chat_hash, 'sender_name' => $this->sender, 'user_handle' => $this->sender_user_handle]);
        }
        return MasterNotificationTemplate::prepareSendData($this->title(), $this->message(), ['objective' => $this->objective, 'chat_hash' => $this->chat_hash, 'sender_name' => $this->sender, 'user_handle' => $this->sender_user_handle, 'lead_id' => $this->chat->lead_id, 'can_call' => $this->chat->callpossible()]);
    }
}
