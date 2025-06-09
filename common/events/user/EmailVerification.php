<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use yii\base\Event;

class EmailVerification extends Event
{
    public $userId;
    public $email;
    public $name;
    public $email_otp;
    public $exp_datetime;
    public $templates;
    public $channelName;

    protected $channels = [
        'email',
    ];
    protected $mail_template_code = 'OTPV'; // OTP Verification

    public function __construct($userId,$email,$name,$email_otp,$exp_datetime)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->email_otp = $email_otp;
        $this->exp_datetime = $exp_datetime;
        $this->broadcastHandle();
    }

    public function broadcastHandle()
    {
        foreach ($this->channels as $channel) {
            $this->channelName = $channel;
            $this->templates = $this->getTemplates()[$channel];
            $broadcastService = new BroadcastService();
            $broadcastService->send($this, true);
        }
    }

    public function getTemplates()
    {
        $arr = [
            'email' => [
                [
                    'subject' => 'Email Verification',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->name,
                        'email_otp'=>$this->email_otp,
                        'exp_datetime'=>$this->exp_datetime,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],
            ],
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
