<?php

namespace common\events\operator;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\User;
use yii\base\Event;

class QuotationSendByOperator extends Event
{
    public $quotation;
    public $amount;
    protected $user;
    protected $partner_user;
    protected $engine;

    public $templates;
    public $channelName;

    protected $channels = [
        'email',
    ];
    protected $mail_template_code = 'QSBO';// New Quote Raised by Safari Operator 

    public function __construct($quotation, $user_id)
    {
        $this->quotation = $quotation;
        $this->user = User::find()->where(['id' => $user_id])->one();
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
                        'user_email' => $this->user->email,
                        'accomodation'=>$this->quotation->staycatgory->title,
                        'parkname' =>  @$this->quotation->park_label,
                        'partner_user' =>$this->quotation->partner->business_name,
                        'no_of_safari' => $this->quotation->safaris,
                        'no_of_travelers'=>$this->quotation->travelers,
                        'start_date'=>$this->quotation->start_date,
                        'end_date'=>$this->quotation->end_date,
                        'validity_date'=>$this->quotation->validity_date,
                        'permit_booking_date'=>$this->quotation->permit_booking_date,
                        'addional_notes' => $this->quotation->addional_notes,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->quotation->net_payment_price),
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
