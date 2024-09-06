<?php

namespace frontend\models;

use common\models\User;
use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\MailLog;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;

/**
 * OperatorQuoteForm is the model behind the contact form.
 */
class OperatorQuoteForm extends Model
{
    public $safari_park_id;
    public $stay_category_id;
    public $start_date;
    public $end_date;
    public $full_name;
    public $email;
    public $phone_no;
    public $safaris;
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
            // [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'full_name', 'email', 'start_date', 'end_date', 'phone_no'], 'required'],
            [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'start_date', 'end_date'], 'required'],
            [['phone_no'], 'match', 'pattern' => '/^[123456789]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['email'], 'email'],
            [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'status'], 'integer'],
            [['full_name', 'email', 'start_date', 'end_date', 'user_agent'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
            [['safaris', 'travelers'], 'number', 'min' => 1],
            [['ip_address'], 'string', 'max' => 45],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park',
            'safaris' => 'Safaris',
            'travelers' => 'Travelers',
            'stay_category_id' => 'Stay Category',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'user_agent' => 'User Agent',
            'ip_address' => 'Ip Address',
            'status' => 'Status',
        ];
    }



    public function request(SafariOperator $operator)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $operator_quote = new OperatorQuote();
        $operator_quote->safari_park_id = $this->safari_park_id;
        $operator_quote->safaris = $this->safaris;
        $operator_quote->travelers = $this->travelers;
        $operator_quote->stay_category_id = $this->stay_category_id;
        $operator_quote->full_name = $this->full_name;
        $operator_quote->email = $this->email;
        $operator_quote->start_date = $this->start_date;
        $operator_quote->end_date = $this->end_date;
        $operator_quote->phone_no = $this->phone_no;
        $operator_quote->operator_id = $operator->id;
        $operator_quote->ip_address = Yii::$app->getRequest()->getUserIp();
        $operator_quote->device_type = $agent->device();
        $operator_quote->user_agent =  Yii::$app->request->userAgent;
        $operator_quote->browser = $agent->browser();
        $operator_quote->os = $agent->platform();
        $operator_quote->status = 1;

        if ($operator_quote->save(false)) {
            //save quote chat 
            $login_user = Yii::$app->user->identity;
            $individual_user = User::find()->where(['id' => $operator->user_id])->limit(1)->one();

            $chat = new Chat();
            $short_msg = $message = "<b>Park: </b>" . $operator_quote->park->title . "<br/>";
            $message .= "<b>Safaries: </b>" . $operator_quote->safaris . "<br/>";
            $message .= "<b>Travelers: </b>" . $operator_quote->travelers . "<br/>";
            $message .= "<b>Stay Category: </b>" . $operator_quote->staycatgory->title . "<br/>";
            $message .= "<b>Start Date: </b>" . date('M j, Y', strtotime($operator_quote->start_date)) . "<br/>";
            $message .= "<b>End Date: </b>" . date('M j, Y', strtotime($operator_quote->end_date)) . "<br/>";

            $chat->generateChatHash();
            $chat->user_id = $login_user->id;
            $chat->recipient_user_id = $individual_user->id;
            $chat->last_message = $short_msg;
            $chat->last_message_at = time();
            $chat->status = 1;
            $chat->chat_type = 2;
            $chat->park_id = $operator_quote->safari_park_id;
            $chat->quote_id = $operator_quote->id;

            if ($chat->save()) {
                $chat_message = new ChatMessage();
                $chat_message->chat_id = $chat->id;
                $chat_message->message = $message;
                $chat_message->status = 1;
                if ($chat_message->save()) {
                    //create mail log
                }
            }
            //save done quote chat

            $to_mail = $operator_quote->email;
            $subject = 'Request Free Quote';
            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_FREE_QUOTE;
            $req = ['username' => $operator_quote->full_name, 'parkname' => $operator_quote->park->title, 'is_email_sending' => true];

            $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                GeneralModel::sendmailfromlog($maillog_data['log_id']);
            }

            return $operator_quote;
        }
    }
}
