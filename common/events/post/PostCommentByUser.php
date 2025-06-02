<?php

namespace common\events\post;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\User;
use yii\base\Event;

class PostCommentByUser extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;


    public $user;
    public $host_user;
    public $host_user_id;
  


    public $admin_mail;
    protected $sent_data = [];
    protected $engine;
    protected $master_notification_template;
    
    protected $channels = [
        // 'email',
        'firebase',
    ];

    protected $mail_template_code = 'THOS';  // To Host on Comment 
    protected $var2_name = 'post';

    public function __construct($user,$host_user_id,$host_user)
    {
        
        $this->user = $user;
        $this->userId = $host_user_id;
        $this->host_user = $host_user;
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
            $broadcastService->send($this,true);
        }
    }

    public function getTemplates()
    {
        $arr = [
            'email' => [
                [
                    'subject' => $this->user . ' commented your post',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->user,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],
                [
                    'subject' => $this->user . ' has commented ' . $this->host_user . "'s" . 'post',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->user,
                    ],
                    'to_mail' => \Yii::$app->params['adminEmail'],  
                    'cc' => [],
                    'bcc' => [],
                ]
            ],
            'firebase' => [
                [
                    'master_notification_template_id' => $this->firebaseTemplateId(),
                    'message' => $this->message(),
                    'sent_data' => NULL,
                    'user_id' => $this->userId,
                    'image_url' => NULL,
                    'action' => NULL,
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

    protected function firebaseTemplateId()
    {
        $this->master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::SAFARI_NEW_COMMENT, 'status' => 1])->limit(1)->one();
        if ($this->master_notification_template) {
            return $this->master_notification_template->id;
        }
        return null;
    }

    private function message()
    {
        return $this->engine->render($this->master_notification_template->message, ['var1'=>$this->user,'var2'=>$this->var2_name]);
    }

}
