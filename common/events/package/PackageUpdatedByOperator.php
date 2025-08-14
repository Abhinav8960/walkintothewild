<?php

namespace common\events\package;

use api\models\sharesafari\ShareSafari;
use common\broadcast\services\BroadcastService;
use common\models\master\email\MasterMailTemplate;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\package\Package;
use common\models\package\PackageVersion;
use yii\base\Event;

class PackageUpdatedByOperator extends Event
{
    public $userId;
    public $email;
    public $name;
    public $templates;
    public $channelName;
    public $package_id;
    public $package_name;
    public $no_of_safari; 
    public $start_date;
    public $end_date ;
    public $start_location;
    public $end_location;
    public $cost_per_person;
    public $shared_safari_title;
    public $receiverUserIds = [];
    public $package_url;
    protected $sent_data = [];
    protected $package;
    protected $engine;
    protected $master_notification_template;

    protected $channels = [
        // 'email',
        // 'firebase',
    ];

    protected $mail_template_code = 'OUNP';  // Package Updated by Opertor

    public function __construct(array $receiverUserIds,$userId,$email,$name,$package_id)
    {
        $this->receiverUserIds = $receiverUserIds;
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->package_id = $package_id;
        $this->engine = \Yii::$app->engine;
        $this->prepareData();
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
                    'subject' => 'Check Out Updated Package !!',
                    'mail_template_id' => $this->emailTemplateId(),
                    'params' => [
                        'operator_name' => $this->name,
                        'email' => $this->email,
                        'package_name' => $this->package_name,
                        'no_of_safari'=>$this->no_of_safari,
                        'start_location'=>$this->start_location,
                        'end_location'=>$this->end_location,
                        'start_date'=>$this->start_date,
                        'end_date'=>$this->end_date,
                        'cost_per_person'=>$this->cost_per_person,
                        'package_url' => $this->package_url,
                    ],
                    'to_mail' => \Yii::$app->params['adminEmail'],
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
        $this->master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::PACKAGE_UPDATED, 'status' => 1])->limit(1)->one();
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

        $this->package = PackageVersion::find()->where(['id' => $this->package_id])->one();  
        $this->package_name = $this->package->package_name;
        $this->no_of_safari = $this->package->no_of_safari;
        $this->start_location = $this->package->start_location;
        $this->end_location = $this->package-> end_location;
        $this->start_date = $this->package->start_date;
        $this->end_date = $this->package-> end_date;
        $this->cost_per_person = $this->package->cost_per_person;

        $this->package_url = urlencode(\Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'id' => $this->package->id]));
        $this->userId = $this->package->safari_operator_id;
        if ($this->package->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            $this->email = $this->package->safarioperator->email;
            $this->name =  $this->package->safarioperator->business_name;
        } else {
            $this->email = $this->package->user->email;
            $this->name =  $this->package->user->name;
        }
        $this->sent_data = [
            'package_name' => $this->package->package_name,
            'id'=>$this->package->id,
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
