<?php

namespace common\events\leads;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\operator\SafariOperator;
use common\models\User;
use yii\base\Event;

class QuotationPaymentReceived extends Event
{
    public $quotation;
    protected $user;
    protected $partner_user;
    protected $master_notification_template;
    protected $engine;
    protected $transaction_id;
    protected $payment_date;

    public $templates;
    public $channelName;

    protected $channels = [
        'email',
    ];
    protected $mail_template_code_for_user = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_QUOTATION_PAYMENT_RECEIVED_FOR_USER; // New User Registration
    protected $mail_template_code_for_Operator = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_QUOTATION_PAYMENT_RECEIVED_FOR_PARTNER; // New User Registration

    public function __construct($quotation, $user_id, $partner_user_id, $transaction_id, $payment_date)
    {
        $this->user = User::find()->where(['id' => $user_id])->one();
        $this->partner_user = User::find()->where(['id' => $partner_user_id])->one();
        $this->quotation = $quotation;
        $this->transaction_id = $transaction_id;
        $this->payment_date = $payment_date;
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
                    'subject' => 'Payment Received and safari Booking Confirmation for ' . @$this->quotation->park_label,
                    'mail_template_id'  => $this->emailTemplateIdForUser(),
                    'params' => [
                        'username' => $this->user->name,
                        'parkname' =>  @$this->quotation->park_label,
                        'travelers' => $this->quotation->travelers,
                        'safaris' => $this->quotation->safaris,
                        'start_date' => date('d M, Y', strtotime($this->quotation->start_date)),
                        'end_date' => date('d M, Y', strtotime($this->quotation->end_date)),
                        // 'validity_date' => !empty($this->quotation->validity_date) ? date('d M, Y', strtotime($this->quotation->validity_date)) : null,
                        // 'permit_booking_date' => !empty($this->quotation->permit_booking_date) ? date('d M, Y', strtotime($this->quotation->permit_booking_date)) : null,
                        'night_stay_count' => round((strtotime($this->quotation->end_date) - strtotime($this->quotation->start_date)) / 86400),
                        'staycategory' => @$this->quotation->staycatgory->title,
                        'addional_notes' => $this->quotation->addional_notes,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->quotation->due_quatation->amount),
                        'transaction_id' => $this->transaction_id,
                        'payment_date' => date('d M, Y', strtotime($this->payment_date)),
                    ],
                    'to_mail' => $this->user->email,
                    'cc' => [
                        \Yii::$app->params['adminEmail']
                    ],
                    'bcc' => [],
                ],
                [
                    'subject' => 'Lead Booked and Payment Received for ' . @$this->quotation->name,
                    'mail_template_id'  => $this->emailTemplateIdForOperartor(),
                    'params' => [
                        'username' => $this->partner_user->name,
                        'lead_name' => $this->quotation->name,
                        'lead_email' => $this->quotation->email,
                        'lead_phone' => $this->quotation->phone,
                        'parkname' =>  @$this->quotation->park_label,
                        'travelers' => $this->quotation->travelers,
                        'safaris' => $this->quotation->safaris,
                        'start_date' => date('d M, Y', strtotime($this->quotation->start_date)),
                        'end_date' => date('d M, Y', strtotime($this->quotation->end_date)),
                        // 'validity_date' => !empty($this->quotation->validity_date) ? date('d M, Y', strtotime($this->quotation->validity_date)) : null,
                        // 'permit_booking_date' => !empty($this->quotation->permit_booking_date) ? date('d M, Y', strtotime($this->quotation->permit_booking_date)) : null,
                        'night_stay_count' => round((strtotime($this->quotation->end_date) - strtotime($this->quotation->start_date)) / 86400),
                        'staycategory' => @$this->quotation->staycatgory ? $this->quotation->staycatgory->title : '',
                        'addional_notes' => $this->quotation->addional_notes,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->quotation->due_quatation ? $this->quotation->due_quatation->amount : 0),
                        'transaction_id' => $this->transaction_id,
                        'payment_date' => date('d M, Y', strtotime($this->payment_date)),
                    ],
                    'to_mail' => $this->partner_user ? $this->partner_user->email : '',
                    'cc' => [
                        \Yii::$app->params['adminEmail']
                    ],
                    'bcc' => [],
                ]

            ],

            // Add more templates for other channels as needed
        ];
        return $arr;
    }

    protected function emailTemplateIdForUser()
    {
        $template = MasterMailTemplate::find()->where(['code' => $this->mail_template_code_for_user, 'status' => 1])->limit(1)->one();
        if ($template) {
            return $template->id;
        }
        return null;
    }

    protected function emailTemplateIdForOperartor()
    {
        $template = MasterMailTemplate::find()->where(['code' => $this->mail_template_code_for_Operator, 'status' => 1])->limit(1)->one();
        if ($template) {
            return $template->id;
        }
        return null;
    }
}
