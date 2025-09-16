<?php

namespace common\events\leads;

use api\models\leads\Lead;
use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\operator\SafariOperator;
use common\models\User;
use yii\base\Event;

class PaymentRecievedForQuotation extends Event
{
    public $transaction;
    protected $user;
    protected $partner_user;
    protected $master_notification_template;
    protected $engine;

    public $templates;
    public $channelName;
    public $reference_no;

    protected $channels = [
        'email',
    ];
    protected $mail_template_code_for_user = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_PAYMENT_RECEIVED_AGAINST_QUOTATION_FOR_USER; // New User Registration
    protected $mail_template_code_for_operator = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_PAYMENT_RECEIVED_AGAINST_QUOTATION_FOR_OPERATOR; // New User Registration

    public function __construct($transaction, $reference_no, $user_id, $partner_user_id)
    {
        $this->user = User::find()->where(['id' => $user_id])->one();
        $this->partner_user = User::find()->where(['id' => $partner_user_id])->one();
        $this->transaction = $transaction;
        $this->reference_no = $reference_no;

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
                    'subject' => 'Payment Received for ' . @$this->transaction->park_label,
                    'mail_template_id'  => $this->emailTemplateIdForUser(),
                    'params' => [
                        'username' => $this->user->name,
                        'parkname' =>  @$this->transaction->park_label,
                        'travelers' => $this->transaction->travelers,
                        'safaris' => $this->transaction->safaris,
                        'start_date' => date('d M, Y', strtotime($this->transaction->start_date)),
                        'end_date' => date('d M, Y', strtotime($this->transaction->end_date)),
                        // 'validity_date' => !empty($this->transaction->validity_date) ? date('d M, Y', strtotime($this->transaction->validity_date)) : null,
                        // 'permit_booking_date' => !empty($this->transaction->permit_booking_date) ? date('d M, Y', strtotime($this->transaction->permit_booking_date)) : null,
                        'night_stay_count' => round((strtotime($this->transaction->end_date) - strtotime($this->transaction->start_date)) / 86400),
                        'staycategory' => @$this->transaction->staycatgory_lable,
                        'addional_notes' => $this->transaction->addional_notes,
                        'reference_no' => $this->reference_no,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->transaction->received_amount),
                        'operatorsDetails' => [
                            'name' => $this->partner_user->name,
                            'email' => $this->partner_user->email,
                            'phone' => $this->partner_user->phone_no
                        ]
                        // 'payment_url' => urlencode($this->payment_url_email),
                        // 'qr_code' => isset($this->transaction->due_quatation->qr_code_file) ? urlencode(\Yii::$app->params['s3_endpoint'] . '/' . $this->transaction->due_quatation->qr_code_file) : null,
                    ],
                    'to_mail' => $this->user->email,
                    'cc' => [],
                    'bcc' => [
                        \Yii::$app->params['adminEmail']                        
                    ],
                ],
                [
                    'subject' => 'Payment Received for user ' . $this->user->name,
                    'mail_template_id'  => $this->emailTemplateIdForOperartor(),
                    'params' => [
                        'username' => $this->partner_user->name,
                        // 'lead' => $this->transaction->lead,
                        'user' => $this->user->name,
                        'parkname' =>  @$this->transaction->park_label,
                        'travelers' => $this->transaction->travelers,
                        'safaris' => $this->transaction->safaris,
                        'start_date' => date('d M, Y', strtotime($this->transaction->start_date)),
                        'end_date' => date('d M, Y', strtotime($this->transaction->end_date)),
                        // 'validity_date' => !empty($this->transaction->validity_date) ? date('d M, Y', strtotime($this->transaction->validity_date)) : null,
                        // 'permit_booking_date' => !empty($this->transaction->permit_booking_date) ? date('d M, Y', strtotime($this->transaction->permit_booking_date)) : null,
                        'night_stay_count' => round((strtotime($this->transaction->end_date) - strtotime($this->transaction->start_date)) / 86400),
                        'staycategory' =>  @$this->transaction->staycatgory_lable,
                        'addional_notes' => $this->transaction->quotation->addional_notes,
                        'reference_no' => $this->reference_no,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->transaction->received_amount),
                        'travelersDetails' => [
                            'name' => $this->user->name,
                            'email' => $this->user->email,
                            'phone' => $this->user->mobile_no
                        ]
                    ],
                    'to_mail' => $this->partner_user->email,
                    'cc' => [],
                    'bcc' => [
                        \Yii::$app->params['adminEmail']
                    ],
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
        $template = MasterMailTemplate::find()->where(['code' => $this->mail_template_code_for_operator, 'status' => 1])->limit(1)->one();
        if ($template) {
            return $template->id;
        }
        return null;
    }

    // private function title()
    // {
    //     return $this->engine->render($this->master_notification_template->title, ['package_name' => $this->package->package_name]);
    // }
    // private function message()
    // {
    //     return $this->engine->render($this->master_notification_template->message, ['package_name' => $this->package->package_name, 'user_name' => $this->user->name]);
    // }
}
