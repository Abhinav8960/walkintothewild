<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\Helper\SmsHelper;
use common\models\master\smstemplate\MasterSmsTemplate;
use yii\base\Event;

class MobileNoVerification extends Event
{
    public $userId;
    public $phone_no;
    public $otp;
    public $name;
    public $templates;
    public $channelName;
    public $template_id = "1707174799017772045";
    public $sms_template;

    protected $channels = [
        'sms',
    ];

    public function __construct($userId, $phone_no, $otp, $name)
    {
        $this->userId = $userId;
        $this->phone_no = $phone_no;
        $this->otp = $otp;       
        $this->name = $name;
        $this->smsTemplateId();
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
            'sms' => [
                [
                    'user_id'  => $this->userId,
                    'phone_no'  => $this->phone_no,
                    'template_id'  => $this->template_id,
                    'route' => $this->sms_template->route,
                    'params' => [
                        'name' => SmsHelper::handleMaxlength($this->name, true),
                        'otp' => SmsHelper::handleMaxlength($this->otp),
                    ],

                ],
            ],


            // Add more templates for other channels as needed
        ];
        return $arr;
    }

    protected function smsTemplateId()
    {
        $this->sms_template = MasterSmsTemplate::find()->where(['template_id' => $this->template_id, 'status' => 1])->limit(1)->one();
        if ($this->sms_template) {
            return $this->sms_template->id;
        }
        return null;
    }

    public function manage()
    {
        return $this->sms_template;
    }
}
