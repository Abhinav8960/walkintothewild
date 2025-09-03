<?php

namespace common\events\operator;

use api\models\sharesafari\ShareSafari;
use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\operator\SafariOperator;
use yii\base\Event;

class FixedDepartureSendForApprovalEvent extends Event
{
 
    public $templates;
    public $channelName;
    public $shared_safari_title;
    
    protected $shared_safari;
    protected $engine;
    protected $objective;

    public $safari_operator_id;
    public $safari_operator;
    public $safari_operator_name;


    protected $channels = [
        'email',
    ];

    protected $mail_template_code = 'OSFA';

    public function __construct($safari_operator_id,$shared_safari_title)
    {
        
        $this->safari_operator = SafariOperator::find()->Where(['id'=>$safari_operator_id])->one();
        $this->safari_operator_name = $this->safari_operator->business_name;
        $this->shared_safari_title = $shared_safari_title;
        $this->engine = \Yii::$app->engine;
        $this->objective = ShareSafari::OBJECTIVE;
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
                    'subject' => 'New Fixed Departure !',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'operator_name' => $this->safari_operator_name,
                        'title' => $this->shared_safari_title,
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