<?php

namespace common\events\park;


use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use yii\base\Event;

class ParkReviewApprovalEvent extends Event
{

    public $templates;
    public $channelName;
    public $review;
    public $park_title;


    protected $engine;


    protected $channels = [
        'email',
    ];

    protected $mail_template_code = 'PRRA';

    public function __construct($park_title, $review)
    {

        $this->park_title = $park_title;
        $this->review = $review;
        $this->engine = \Yii::$app->engine;
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
                    'subject' => 'New Review for approval ' . $this->park_title . ' !',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'park_title' => $this->park_title,
                        'review' => $this->review,
                    ],
                    'to_mail' => \Yii::$app->params['supportEmail'],
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
