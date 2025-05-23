<?php

namespace common\events\operator;

use api\models\sharesafari\ShareSafari;
use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use yii\base\Event;

class FixedDepartureCreatedByOperator extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;
    public $shared_safari_id;
    public $shared_safari_name;
    public $no_of_safari; 
    public $start_date;
    public $end_date ;
    public $total_seat;
    public $shared_safari_title;
    public $receiverUserIds = [];
    public $shared_safari_url;
    protected $sent_data = [];
    protected $shared_safari;
    protected $engine;
    protected $master_notification_template;

    protected $channels = [
        // 'email',
        // 'firebase',
    ];

    protected $mail_template_code = 'OCNF';  // Fixed Departure Created by Opertor

    public function __construct(array $receiverUserIds,$userId, $email, $name ,$shared_safari_id)
    {
        
        $this->receiverUserIds = $receiverUserIds;
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->shared_safari_id = $shared_safari_id;
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
                    'subject' => 'Check Out new Safari !!',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'username' => $this->name,
                        'email' => $this->email,
                        // 'shared_safari' => $this->shared_safari_name,
                        'shared_safari_title'=>$this->shared_safari_title,
                        'no_of_safari'=>$this->no_of_safari,
                        'start_date'=>$this->start_date,
                        'end_date'=>$this->end_date,
                        'total_seat'=>$this->total_seat,
                        'shared_safari_url' => $this->shared_safari_url,
                    ],
                    'to_mail' => $this->email,
                    'cc' => [],
                    'bcc' => [],
                ],
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

    protected function firebaseTemplateId()
    {
        $this->master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::FIXED_DEPARTURE_CREATED, 'status' => 1])->limit(1)->one();
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
        return $this->engine->render($this->master_notification_template->message, ['username'=>$this->name]);
    }

    public function prepareData()
    {

        $this->shared_safari = ShareSafari::find()->where(['id' => $this->shared_safari_id])->one();
        $this->shared_safari_title = $this->shared_safari->share_safari_title;
        $this->no_of_safari = $this->shared_safari->no_of_safari;
        $this->start_date = $this->shared_safari->start_date;
        $this->end_date = $this->shared_safari-> end_date;
        $this->total_seat = $this->shared_safari->total_seat;

        $this->shared_safari_url = urlencode(\Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $this->shared_safari->slug, 'organized_slug' => $this->shared_safari->organizedslug ? $this->shared_safari->organizedslug : '']));
        $this->userId = $this->shared_safari->host_user_id;
        if ($this->shared_safari->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            $this->email = $this->shared_safari->safarioperator->email;
            $this->name =  $this->shared_safari->safarioperator->business_name;
        } else {
            $this->email = $this->shared_safari->user->email;
            $this->name =  $this->shared_safari->user->name;
        }
        $this->sent_data = [
            'shared_safari_title' => $this->shared_safari->share_safari_title,
            'slug' => $this->shared_safari->slug,
            'no_of_safari'=>$this->no_of_safari,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'total_seat'=>$this->total_seat,
        ];
    }


    private function prepareFirebaseTemplate()
    {
        foreach ($this->receiverUserIds as $userId) {
            $arr[] =  [
                'master_notification_template_id'   => $this->firebaseTemplateId(),
                'title'                             => $this->title(),
                'message'                           => $this->message(),
                'sent_data'                         => $this->sent_data,
                'user_id'                           => $userId,
                'image_url'                         => NULL,
                'action'                            => NULL,
            ];
        }
        return $arr;
    }
}
