<?php

namespace common\events\leads;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\operator\SafariOperator;
use common\models\User;
use yii\base\Event;

class PartnerLeadReceived extends Event
{
    public $park;
    protected $user;
    protected $partner;
    protected $to_mail;
    protected $master_notification_template;
    protected $engine;
    protected $chat_url;

    public $templates;
    public $channelName;

    protected $channels = [
        'email',
        'firebase',
    ];
    protected $mail_template_code = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_TOUR_OPERATOR_FREE_QUOTE_REQUEST; // New User Registration

    public function __construct($park, $partner_id, $user_id, $chat_hash)
    {
        $this->partner = SafariOperator::find()->where(['id' => $partner_id])->limit(1)->one();
        $this->user = User::find()->where(['id' => $user_id])->one();
        $this->park = $park;
        $this->to_mail = $this->partner->email;
        $this->chat_url  = \Yii::$app->params['frontend_url'] .'/'. $this->user->user_handle . "/" . $chat_hash;
        $this->engine  = \Yii::$app->engine;

        $this->broadcast();
    }

    public function broadcast()
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
                    'subject' => 'New Quote Request for ' . $this->park->title,
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->partner->business_name,
                        'parkname' => $this->park->title,
                        'chat_url' => urlencode($this->chat_url),
                    ],
                    'to_mail' => $this->to_mail,
                    'cc' => [],
                    'bcc' => [],
                ]
            ],
            'firebase' => [
                [
                    'master_notification_template_id' => $this->firebaseTemplateId(),
                    'title'                             => $this->title(),
                    'message'                           => $this->message(),
                    'sent_data' => NULL,
                    'user_id' => $this->partner->user_id,
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
        $this->master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::PARTNER_QUOTATION_RECEIVED, 'status' => 1])->limit(1)->one();
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
        return $this->engine->render($this->master_notification_template->message, ['park_name' => $this->park->title, 'user_name' => $this->user->name]);
    }
}
