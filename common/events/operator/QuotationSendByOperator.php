<?php

namespace common\events\operator;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\User;
use yii\base\Event;

class QuotationSendByOperator extends Event
{
    public $amount;
    protected $user;
    protected $partner_user;
    protected $engine;

    public $templates;
    public $channelName;

    protected $channels = [
        // 'email',
    ];
    protected $mail_template_code = 'QSBO';// New Quote Raised by Safari Operator 

    public function __construct($amount, $user_id, $partner_user_id)
    {
        $this->user = User::find()->where(['id' => $user_id])->one();
        $this->partner_user = User::find()->where(['id' => $partner_user_id])->one();
        $this->amount = $amount;
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
                    'subject' => 'Quote Received',
                    'mail_template_id'  => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->user->name,
                        'partner_user' =>$this->partner_user->name,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->amount),
                    ],
                    'to_mail' => \Yii::$app->params['adminEmail'],
                    'cc' => [],
                    'bcc' => [],
                ],
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

}
