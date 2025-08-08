<?php

namespace common\events\sharesafari;


use common\models\sharesafari\ShareSafari;
use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use Yii;
use yii\base\Event;

class SafariBookedByUser extends Event
{
    public $email;
    public $name;
    public $templates;
    public $channelName;
    public $shared_safari_id;
    public $shared_safari_name;
    public $no_of_safari;
    public $start_date;
    public $end_date;
    public $booked_seat;
    public $type;
    public $shared_safari_title;
    public $referenceId;
    public $amount;
    public $park;
    protected $shared_safari;
    protected $engine;

    protected $channels = [
        'email',
        // 'firebase',
    ];

    protected $mail_template_code = 'SSBU';  // New Safari Created By User mail to admin


    public function __construct($email, $name, $shared_safari_id, $referenceId, $amount, $booked_seat, $start_date, $end_date)
    {

        $this->name = $name;
        $this->email = $email;
        $this->shared_safari_id = $shared_safari_id;
        $this->referenceId = $referenceId;
        $this->amount = $amount;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->booked_seat = $booked_seat;
        $this->engine = \Yii::$app->engine;
        $this->prepareData();
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
                    'subject' => $this->shared_safari_title . 'Booked, get ready for adventure!!',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'name' => $this->name,
                        // 'email' => $this->email,
                        // 'shared_safari' => $this->shared_safari_name,
                        'shared_safari_title' => $this->shared_safari_title,
                        'no_of_safari' => $this->no_of_safari,
                        'start_date' => $this->start_date,
                        'end_date' => $this->end_date,
                        'booked_seat' => $this->booked_seat,
                        'referenceId' => $this->referenceId,
                        'amount' => $this->amount,
                        'park' => $this->park,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ]

            ],
            'firebase' => $this->prepareFirebaseTemplate()
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



    public function prepareData()
    {
        $this->shared_safari = ShareSafari::find()->where(['id' => $this->shared_safari_id])->one();
        $this->shared_safari_title = $this->shared_safari->share_safari_title;        
        $this->no_of_safari = $this->shared_safari->no_of_safari;        
        $this->park = $this->shared_safari->park->title;


        // $this->sent_data = [
        //     'shared_safari_title' => $this->shared_safari->share_safari_title,
        //     'slug' => $this->shared_safari->slug,
        //     'no_of_safari' => $this->no_of_safari,
        //     'start_date' => $this->start_date,
        //     'end_date' => $this->end_date,
        //     'booked_seat' => $this->booked_seat,
        // ];
    }
}
