<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\User;
use yii\base\Event;

class UserAccountDeleteRequest extends Event
{
    public $userId;
    public $userEmail;
    public $email;
    public $templates;
    public $channelName;

    protected $channels = [
        'email',
    ];
    protected $mail_template_code = 'UADR'; // New User Registration

    public function __construct($userId = null, $userEmail)
    {
        $this->userEmail = $userEmail;

        if ($userId == null) {
            $this->userId = NULL;
            $this->email = \Yii::$app->params['adminEmail'];
            $this->name = "Ananymous";
        } else {
            $user = User::find()->where(['id' => $userId])->one();
            $this->userId = $userId;
            $this->email = \Yii::$app->params['adminEmail'];
            $this->name = $user->name;
        }
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
                    'subject' => 'Account Deletion Request - Walk Into The Wild',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->name,
                        'email' => $this->userEmail,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],

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
}
