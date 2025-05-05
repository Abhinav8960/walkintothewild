<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class SocialLoginEmailVerification extends Event
{
    public $email;
    public $name;
    public $otp;
    public $template;
    public $channelName;

    protected $channels = [
        'email',
        // 'firebase',
    ];
    protected $mail_template_code = 'SEVN'; // New User Registration

    public function __construct($email, $name, $otp)
    {
        $this->email = $email;
        $this->name = $name;
        $this->otp = $otp;
        $this->broadcastHandle();
    }

    public function broadcastHandle()
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
                'subject' => 'Email Verification',
                'mail_template_id'  => $this->emailTemplateId(),
                'params' => [
                    // 'username' => $this->name,
                    // 'email' => $this->email,
                    'otp' => $this->otp,
                ],
                'to_mail' => $this->email,
                'cc' => [],
                'bcc' => [],
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
