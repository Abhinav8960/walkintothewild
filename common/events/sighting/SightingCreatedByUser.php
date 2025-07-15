<?php

namespace common\events\sighting;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\sighting\Sighting;
use common\models\User;
use common\models\UserPosts;
use yii\base\Event;

class SightingCreatedByUser extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;


    public $username;
    public $receiverUserIds;


    public $admin_mail;
    protected $sent_data = [];
    protected $objective;
    protected $user_handle;
    protected $engine;
    protected $master_notification_template;

    protected $channels = [
        // 'email',
        // 'firebase',
    ];

    protected $mail_template_code = 'THOS';  // To Host on Comment 

    public function __construct(array $receiverUserIds, $username)
    {
        $this->receiverUserIds = $receiverUserIds;
        $this->username = $username ;
        $this->objective = Sighting::OBJECTIVE;
        // $this->email =$email;
        $this->engine = \Yii::$app->engine;
        $this->broadcastHandle();
    }

    public function broadcastHandle()
    {

        foreach ($this->channels as $channel) {
            $this->channelName = $channel;
            $this->templates = $this->getTemplates()[$channel];
            // $this->template['channel'] = $channel;
            $broadcastService = new BroadcastService();
            // $broadcastService->send($this);
            $broadcastService->send($this, true);
        }
    }

    public function getTemplates()
    {
        $arr = [
            'email' => [
                [
                    'subject' => $this->username . ' Created a sighting',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->username,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],
            ],
            'firebase' => $this->prepareFirebaseTemplate()
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
        $this->master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::NEW_SIGHTING, 'status' => 1])->limit(1)->one();
        if ($this->master_notification_template) {
            return $this->master_notification_template->id;
        }
        return null;
    }

    private function message()
    {
        return $this->engine->render($this->master_notification_template->message, []);
    }

    private function title()
    {
        return $this->engine->render($this->master_notification_template->title, []);
    }

    private function prepareFirebaseTemplate()
    {
        $arr = [];
        // $count = 0;
        foreach ($this->receiverUserIds as $userId) {
            // $count++;
            $arr[] =  [
                'master_notification_template_id'   => $this->firebaseTemplateId(),
                'title'                             => $this->title(),
                'message'                           => $this->message(),
                'sent_data'                         => MasterNotificationTemplate::prepareSendData($this->title(), $this->message(), ['objective' => $this->objective]),
                'user_id'                           => $userId,
                'image_url'                         => NULL,
                'action'                            => NULL,
            ];
        }
        // print_r($count);
        // die;
        return $arr;
    }
}
