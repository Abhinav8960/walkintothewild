<?php

namespace common\events\sharesafari;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\User;
use yii\base\Event;

class SafariJoinedByuser extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;


    public $interested_user;
    public $admin_mail;
    public $shared_safari;
    public $shared_safari_url;


    protected $channels = [
        'email',
        'firebase',
    ];

    protected $mail_template_code = 'THJS';  // To Host Join Safari

    public function __construct($userId, $email, $name, $interested_user,$shared_safari , $shared_safari_url)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->interested_user = $interested_user;
        $this->shared_safari = $shared_safari;
        $this->shared_safari_url = $shared_safari_url;
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
            'email' => [
                [
                    'subject' => $this->interested_user . ' joined your Shared Safari! Connect to plan the adventure.',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->interested_user,
                        'shared_safari' => $this->shared_safari,
                        'shared_safari_url' => $this->shared_safari_url,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],
                [
                    'subject' => 'New Update !! ' . $this->interested_user . ' has joined ' . $this->name ."'s" . ' Shared Safari',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->interested_user,
                        'shared_safari' => $this->shared_safari,
                        'shared_safari_url' => $this->shared_safari_url,
                    ],
                    'to_mail' => $this->adminMail(),
                    'cc' => [],
                    'bcc' => [],
                ]
            ],
            'firebase' => [
                [
                    'master_notification_template_id' => $this->firebaseTemplateId(),
                    'title' => 'Welcome!',
                    'message' => 'Hello ' . $this->interested_user . ', welcome to our Safari!',
                    'sent_data' => NULL,
                    'user_id' => $this->userId,
                    'image_url' => NULL,
                    'action' => NULL,
                ],
                [
                    'master_notification_template_id' => $this->firebaseTemplateId(),
                    'title' => 'New Update',
                    'message' => $this->interested_user . ' has joined ' . $this->name . ' Shared Safari',
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

    protected function adminMail()
    {
        $admin = User::find()->where(['id' => $this->userId])->andWhere(['is_admin' => 1])->one();
        if ($admin) {
            $to_mail = 'abhinav@triline.co.in'; 
            return $to_mail;
        }
    }
}
