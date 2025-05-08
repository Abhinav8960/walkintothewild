<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class NewChatMessageReceived extends Event
{
    public $receiverUserId;
    public $sender;
    public $message;
    public $chat_hash;
    public $templates;
    public $sent_data;
    public $channelName;
    protected $master_notification_template;

    protected $channels = [
        'firebase',
    ];

    public function __construct($receiverUserId, $sender, $message, $chat_hash, $sent_data)
    {
        $this->userId       = $receiverUserId;
        $this->sender       = $sender;
        $this->message      = $message;
        $this->chat_hash    = $chat_hash;
        $this->sent_data    = $sent_data;
        $this->engine       = \Yii::$app->engine;
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
                    'title' => $this->title(),
                    'message' => $this->message(),
                    'sent_data' => $this->sent_data,
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



    // $engine = \Yii::$app->engine;
    // $template = MasterNotificationTemplate::find()->where(['id' => 1])->limit(1)->one();
    // $master_notification_template_id = $template->id;
    // /**Firebase Notification start */
    // $user_ids = [$share_safari->organizedId];
    // $title = $template->title;
    // $message = $template->message;
    // $message_values = [
    //     'var1' => $user->name,
    //     'var2' => $share_safari->share_safari_title
    // ];
    // $message_values = [
    //     'var1' => $user->name,
    //     'var2' => $share_safari->share_safari_title
    // ];

    // $message = $engine->render($message, $message_values);
    // $title = $engine->render($title, $title_values);
}
