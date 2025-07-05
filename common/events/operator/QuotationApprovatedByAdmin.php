<?php

namespace common\events\operator;

use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\operator\SafariOperator;
use common\models\User;
use yii\base\Event;

class QuotationApprovatedByAdmin extends Event
{
    public $quotation;
    protected $user;
    protected $partner_user;
    protected $master_notification_template;
    protected $engine;
    protected $payment_url;
    protected $payment_url_email;

    public $templates;
    public $channelName;

    protected $channels = [
        'email',
    ];
    protected $mail_template_code_for_user = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_QUOTATION_APPROVED_BY_ADMIN_FOR_USER; // New User Registration
    protected $mail_template_code_for_operator = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_QUOTATION_APPROVED_BY_ADMIN_FOR_OPERATOR; // New User Registration

    public function __construct($quotation, $payment_url, $user_id, $partner_user_id)
    {
        $this->user = User::find()->where(['id' => $user_id])->one();
        $this->partner_user = User::find()->where(['id' => $partner_user_id])->one();
        $this->quotation = $quotation;
        $this->payment_url  =  $payment_url;
        $this->payment_url_email  =  $payment_url . '?utm_source=email';
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
                    'subject' => 'Quote Received for ' . @$this->quotation->park_label,
                    'mail_template_id'  => $this->emailTemplateIdForUser(),
                    'params' => [
                        'username' => $this->user->name,
                        'parkname' =>  @$this->quotation->park_label,
                        'travelers' => $this->quotation->travelers,
                        'safaris' => $this->quotation->safaris,
                        'start_date' => date('d M, Y', strtotime($this->quotation->start_date)),
                        'end_date' => date('d M, Y', strtotime($this->quotation->end_date)),
                        'validity_date' => !empty($this->quotation->validity_date) ? date('d M, Y', strtotime($this->quotation->validity_date)) : null,
                        'permit_booking_date' => !empty($this->quotation->permit_booking_date) ? date('d M, Y', strtotime($this->quotation->permit_booking_date)) : null,
                        'night_stay_count' => round((strtotime($this->quotation->end_date) - strtotime($this->quotation->start_date)) / 86400),
                        'staycategory' => @$this->quotation->staycatgory->title,
                        'addional_notes' => $this->quotation->addional_notes,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->quotation->due_quatation->amount),
                        'payment_url' => urlencode($this->payment_url_email),
                        'qr_code' => isset($this->quotation->due_quatation->qr_code_file) ? urlencode(\Yii::$app->params['s3_endpoint'] . '/' . $this->quotation->due_quatation->qr_code_file) : null,
                    ],
                    'to_mail' => $this->user->email,
                    'cc' => [],
                    'bcc' => [],
                ],
                [
                    'subject' => 'Quote approved and forwared to user ' . $this->user->name,
                    'mail_template_id'  => $this->emailTemplateIdForOperartor(),
                    'params' => [
                        'username' => $this->partner_user->name,
                        // 'lead' => $this->quotation->lead,
                        'user' => $this->user->name,
                        'parkname' =>  @$this->quotation->park_label,
                        'travelers' => $this->quotation->travelers,
                        'safaris' => $this->quotation->safaris,
                        'start_date' => date('d M, Y', strtotime($this->quotation->start_date)),
                        'end_date' => date('d M, Y', strtotime($this->quotation->end_date)),
                        'validity_date' => !empty($this->quotation->validity_date) ? date('d M, Y', strtotime($this->quotation->validity_date)) : null,
                        'permit_booking_date' => !empty($this->quotation->permit_booking_date) ? date('d M, Y', strtotime($this->quotation->permit_booking_date)) : null,
                        'night_stay_count' => round((strtotime($this->quotation->end_date) - strtotime($this->quotation->start_date)) / 86400),
                        'staycategory' =>  @$this->quotation->staycatgory->title,
                        'addional_notes' => $this->quotation->addional_notes,
                        'amount' => \common\models\GeneralModel::formatIndianCurrency($this->quotation->due_quatation->amount),
                    ],
                    'to_mail' => $this->partner_user->email,
                    'cc' => [],
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
