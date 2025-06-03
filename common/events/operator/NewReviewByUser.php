<?php

namespace common\events\operator;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class NewReviewByUser extends Event
{
    public $userId;
    public $email;
    public $templates;
    public $channelName;

    public $operator_url;
  
    protected $channels = [
        'email',
        // 'firebase',
    ];
    protected $mail_template_code = 'NRTO'; // New Review by User
    
    public function __construct($email,$operator_url)
    {
        // $this->userId = $userId;
        $this->email = $email;
       $this->operator_url = $operator_url;
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
                    'subject' => 'New Review !',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'operator_url'=>$this->operator_url,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],
                [
                    'subject' => 'New Review !',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'operator_url'=>$this->operator_url,
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
