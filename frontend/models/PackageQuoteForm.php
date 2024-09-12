<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\MailLog;
use common\models\chat\Chat;
use common\models\GeneralModel;
use common\models\package\Package;
use common\models\chat\ChatMessage;
use common\models\package\PackageQuote;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\Helper\FrontendNotificationHelper;

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
            //save quote chat 
            $login_user = Yii::$app->user->identity;
            $package = Package::find()->where(['id' => $package_id])->limit(1)->one();

            $package_data = Package::find()->where(['id' => $package_quote->package_id])->asArray()->one();
            $individual_user = User::find()->where(['id' => $package->safarioperator->user_id])->limit(1)->one();

            $chat = new Chat();
            $short_msg = $message = "<b>Package: </b>" . $package_quote->package->package_name . "<br/>";
            $message .= "<b>Travelers: </b>" . $package_quote->travelers . "<br/>";
            $message .= "<b>Start Date: </b>" . date('M j, Y', strtotime($package_quote->start_date)) . "<br/>";

            $chat->generateChatHash();
            $chat->user_id = $login_user->id;
            $chat->recipient_user_id = $individual_user->id;
            $chat->last_message = $short_msg;
            $chat->last_message_at = time();
            $chat->status = 1;
            $chat->chat_type = 2;
            $chat->package_id = $package_quote->package_id;
            $chat->quote_id = $package_quote->id;

            if ($chat->save(false)) {
                $chat_message = new ChatMessage();
                $chat_message->chat_id = $chat->id;
                $chat_message->message = $message;
                $chat_message->data = json_encode($package_data);
                $chat_message->status = 1;
                $chat_message->save();

                if ($chat_message->save(false)) {
                    //create mail log
                    if ($package) {
                        $operator = SafariOperator::find()->where(['id' => $package->owned_by_id])->limit(1)->one();
                        $to_mail = $operator->email;
                        $subject = 'New Quote Request for ' . $package->packagename . '';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_TOUR_OPERATOR_FREE_QUOTE_REQUEST;
                        $chat_url = "/chat/message/" . Yii::$app->user->identity->user_handle . "/" . base64_encode($chat->id);
                        $req = ['username' => $operator->business_name, 'parkname' => $package->packagename, 'chat_url' => $chat_url, 'is_email_sending' => true];

                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                            FrontendNotificationHelper::packageNewQuote($package, Yii::$app->user->identity, $chat_url);
                        }
                    }
                }
            }
            //end save done quote chat
        }
        return true;
    }
}
