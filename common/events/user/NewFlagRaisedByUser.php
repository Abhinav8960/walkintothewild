<?php

namespace common\events\user;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class NewFlagRaisedByUser extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;

    public $comment;
    public $report_details;

    protected $channels = [
        'email',
        // 'firebase',
    ];
    protected $mail_template_code = 'NFRU'; // New flag Raised by User
    
    public function __construct($userId, $email, $name,$comment,$report_details)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->comment = $comment;
        $this->report_details = $report_details;
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
                    'subject' => 'New Flag Raised !',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->name,
                        'comment' => $this->comment,
                        'report_details' => $this->report_details,

                    ],
                    'to_mail' => \Yii::$app->params['adminEmail'],
                    'cc' => [],
                    'bcc' => [],
                ]
            ],

            // 'firebase' => [
            //     [
            //         'master_notification_template_id' => $this->firebaseTemplateId(),
            //         'title' => NULL,
            //         'message' => $this->name . ' has raised flag. ',
            //         'sent_data' => NULL,
            //         'user_id' => $this->userId,
            //         'image_url' => NULL,
            //         'action' => NULL,
            //     ],
            // ],
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
