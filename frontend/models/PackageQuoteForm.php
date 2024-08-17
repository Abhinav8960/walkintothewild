<?php

namespace frontend\models;

use common\models\MailLog;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use common\models\package\PackageQuote;
use Yii;
use yii\base\Model;

/**
 * PackageQuoteForm is the model behind the contact form.
 */
class PackageQuoteForm extends Model
{
    public $package_id;
    public $pack_start_date;
    public $travelers;
    public $status;
    public $user_agent;
    public $ip_address;
    public $os;
    public $browser;
    public $device_type;
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['travelers', 'pack_start_date'], 'required', 'message' => 'Required'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_id' => 'Package',
            'travelers' => 'Travelers',
            'pack_start_date' => 'Start Date',
            'user_agent' => 'User Agent',
            'ip_address' => 'Ip Address',
            'status' => 'Status',
        ];
    }

    public function request($package_id)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $package_quote = new PackageQuote();
        $package_quote->package_id = $package_id;
        $package_quote->travelers = $this->travelers;
        $package_quote->start_date = $this->pack_start_date;
        $package_quote->ip_address = Yii::$app->getRequest()->getUserIp();
        $package_quote->device_type = $agent->device();
        $package_quote->user_agent =  Yii::$app->request->userAgent;
        $package_quote->browser = $agent->browser();
        $package_quote->os = $agent->platform();
        $package_quote->status = 1;

        if ($package_quote->save(false)) {
            return $package_quote;
        }
        // if ($package_quote->save()) {
        //     $to_mail = $package_quote->email;
        //     $subject = 'Request Free Quote';
        //     $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_FREE_QUOTE;
        //     $req = ['username' => $package_quote->full_name];

        //     MailLog::createMailLog($to_mail, $subject, $template, $req, []);
        //     return $package_quote->save();
        // }
    }
}
