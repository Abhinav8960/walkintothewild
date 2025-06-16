<?php

namespace common\events\sharesafari;

use common\models\sharesafari\ShareSafari;
use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\User;
use yii\base\Event;

class SafariCommentByUser extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;
    public $interested_user;
    public $admin_mail;
    public $shared_safari_id;
    public $shared_safari_name;
    public $shared_safari_url;
    public $objective;
    public $slug;
    protected $sent_data = [];
    protected $shared_safari;
    protected $engine;
    protected $master_notification_template;

    protected $channels = [
        // 'email',
        'firebase',
    ];

    protected $mail_template_code = 'THOS';  // To Host on Comment Safari

    public function __construct($sharesafarislug, $interested_user, $shared_safari_id)
    {

        $this->interested_user = $interested_user;
        $this->shared_safari_id = $shared_safari_id;
        $this->slug = $sharesafarislug;
        $this->objective = ShareSafari::OBJECTIVE;
        $this->engine = \Yii::$app->engine;
        $this->prepareData();
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
                    'subject' => $this->interested_user . ' commented your Shared Safari!',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->interested_user,
                        'shared_safari' => $this->shared_safari_name,
                        'shared_safari_url' => $this->shared_safari_url,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],
                [
                    'subject' => $this->interested_user . ' has commented ' . $this->name . "'s" . ' Shared Safari',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->interested_user,
                        'shared_safari' => $this->shared_safari_name,
                        'shared_safari_url' => $this->shared_safari_url,
                    ],
                    'to_mail' => \Yii::$app->params['adminEmail'],
                    'cc' => [],
                    'bcc' => [],
                ]
            ],
            'firebase' => [
                [
                    'master_notification_template_id' => $this->firebaseTemplateId(),
                    'title' => $this->title(),
                    'message' => $this->message(),
                    'sent_data' => MasterNotificationTemplate::prepareSendData($this->title(), $this->message(), ['objective' => $this->objective, 'slug' => $this->slug]),
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

    private function title()
    {
        return $this->engine->render($this->master_notification_template->title, []);
    }

    private function message()
    {
        return $this->engine->render($this->master_notification_template->message, ['var1' => $this->interested_user, 'var2' => $this->shared_safari_name]);
    }

    public function prepareData()
    {
        $this->shared_safari = ShareSafari::find()->where(['id' => $this->shared_safari_id])->one();
        $this->shared_safari_name = $this->shared_safari->share_safari_title;
        $this->shared_safari_url = urlencode(\Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $this->shared_safari->slug, 'organized_slug' => $this->shared_safari->organizedslug ? $this->shared_safari->organizedslug : '']));
        // $this->userId = $this->shared_safari->host_user_id;
        if ($this->shared_safari->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            $this->userId = $this->shared_safari->safarioperator->user_id;
            $this->email = $this->shared_safari->safarioperator->operator_email;
            $this->name =  $this->shared_safari->safarioperator->business_name;
        } else {
            $this->userId = $this->shared_safari->host_user_id;
            $this->email = $this->shared_safari->user->email;
            $this->name =  $this->shared_safari->user->name;
        }
        $this->shared_safari_url = urlencode("http://walkintothewild.io" . $this->shared_safari['slug']);
        $this->sent_data = [
            'share_safari_title' => $this->shared_safari->share_safari_title,
            'slug' => $this->shared_safari->slug
        ];
    }
}
