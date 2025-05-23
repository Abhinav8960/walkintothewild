<?php

namespace common\events\operator;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\operator\SafariOperator;
use common\models\User;
use yii\base\Event;

class OperatorFollowedByUser extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;
    public $user_name;
    public $admin_mail;
    public $safari_operator_id;
    public $shared_safari_name;
    public $safari_operator_email;
    public $shared_safari_url;
    protected $sent_data = [];
    protected $safari_operator;
    protected $engine;
    protected $master_notification_template;

    protected $channels = [
        // 'email',
        'firebase',
    ];

    protected $mail_template_code = 'SOFR';  // To Follow OPERATOR

    public function __construct($user_name, $safari_operator,$safari_operator_email)
    {
        
        $this->user_name = $user_name;
        $this->safari_operator = $safari_operator;
        $this->safari_operator_email = $safari_operator_email;
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
            $broadcastService->send($this,true);

        }
    }

    public function getTemplates()
    {
        $arr = [
            'email' => [
                [
                    'subject' => $this->user_name.' '.' followed you',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->safari_operator,
                        'name' => $this->user_name
                    ],
                    'to_mail' => $this->safari_operator_email,
                    'cc' => [],
                    'bcc' => [],
                ],
                [
                    'subject' => 'New Update !! ' . $this->user_name . ' has followed ' . $this->safari_operator,
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' =>$this->safari_operator,
                        'name' => $this->user_name
                    ],
                    'to_mail' => \Yii::$app->params['adminEmail'] ,
                    'cc' => [],
                    'bcc' => [],
                ]
            ],
            'firebase' => [
                // [
                //     'master_notification_template_id' => $this->firebaseTemplateId(),
                //     'message' => 'Hello ' . $this->interested_user . ', welcome to our Safari!',
                //     'sent_data' => NULL,
                //     'user_id' => $this->userId,
                //     'image_url' => NULL,
                //     'action' => NULL,
                // ],
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
        $this->master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate:: FOLLOW_OPERATOR, 'status' => 1])->limit(1)->one();
        if ($this->master_notification_template) {
            return $this->master_notification_template->id;
        }
        return null;
    }

    private function title()
    {
        return $this->engine->render($this->master_notification_template->title, []);
    }

    private function message()
    {
        return $this->engine->render($this->master_notification_template->message, ['var1' => $this->user_name]);
    }
}
