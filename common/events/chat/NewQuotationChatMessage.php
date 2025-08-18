<?php

namespace common\events\chat;

use api\models\package\Package;
use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\operator\SafariOperator;
use common\models\User;
use yii\base\Event;

class NewQuotationChatMessage extends Event
{

    protected $user;
    protected $partner;
    protected $to_mail;
    protected $engine;
    protected $chat_url;
    public $message;
    public $chat;
    public $templates;
    public $channelName;

    protected $channels = [
        'email',
    ];
    protected $mail_template_code = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_QUOTATION_MESSAGE;

    public function __construct($sender, $message, $chat_hash, $chat)
    {
        $this->user       = User::find()->where(['id' => $sender])->one();
        $this->sender     = $sender;
        $this->message    = $message;
        $this->chat       = $chat;
        $this->to_mail    = $this->user->email;
        $this->chat_url   = \Yii::$app->params['frontend_url'] . '/' . $this->user->user_handle . "/" . $chat_hash;
        $this->engine     = \Yii::$app->engine;
        $this->broadcast();
    }

    public function broadcast()
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
                    'subject' => 'New Quote Message',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'reply_by' => $this->user->name,
                        'message' => $this->message,
                    ],
                    'to_mail' => $this->to_mail,
                    'cc' => [],
                    'bcc' => [],
                ]
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
