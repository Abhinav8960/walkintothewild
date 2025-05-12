<?php

namespace common\models\leads\form;

use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\leads\Lead;
use Yii;
use yii\base\Model;
use common\models\leads\LeadPartners;
use common\models\park\SafariPark;
use common\models\User;

/**
 * OperatorQuoteForm is the model behind the contact form.
 */
class PartnerLeadForm extends Model
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
            [['full_name', 'email', 'start_date', 'end_date',], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
            [['safaris', 'travelers'], 'number', 'min' => 1],
            // ['stay_category_id', 'exist', 'targetClass' => MetaStayCategory::class, 'targetAttribute' => ['stay_category_id' => 'id']],
            // ['safari_park_id', 'exist', 'targetClass' => SafariPark::class, 'targetAttribute' => ['safari_park_id' => 'id']],
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

    public function request($operator, $login_user)
    {

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $park = SafariPark::find()->where(['id' => $this->safari_park_id])->one();
            $lead = new Lead();
            $lead->source = Lead::SOURCE_PARTNER;
            $lead->park_id = $this->safari_park_id;
            $lead->safaris = $this->safaris;
            $lead->travelers = $this->travelers;
            $lead->stay_category_id = $this->stay_category_id;
            $lead->name = $login_user->name;
            $lead->email = $login_user->email;
            $lead->from_date = $this->start_date;
            $lead->to_date = $this->end_date;
            $lead->phone = $this->phone_no;
            $lead->user_id = $login_user->id;
            $lead->operator_id = $operator->id;
            $lead->status = 1;


            if ($lead->save(false)) {
                $this->assignToPartner($lead, $operator, $login_user);
                $this->prepareChat($lead, $park, $operator, $login_user);
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            // If any exception occurs, rollback the transaction
            $transaction->rollBack();
            throw $e; // Re-throw the exception to handle it higher up
        }
    }

    private function assignToPartner($lead, $operator, $login_user)
    {

        $assign_to_partner = new LeadPartners();
        $assign_to_partner->lead_id = $lead->id;
        $assign_to_partner->partner_id = $operator->id;
        $assign_to_partner->status = true;
        $assign_to_partner->created_by = $login_user->id;
        $assign_to_partner->updated_by = $login_user->id;
        return $assign_to_partner->save(false);
    }

    private function prepareChat($lead, $park, $operator, $login_user)
    {
        $individual_user = User::find()->where(['id' => $operator->user_id])->limit(1)->one();

        $chat = new Chat();
        $short_msg = $message = "<b>Park: </b>" . $park->title . "<br/>";
        $message .= "<b>Safaries: </b>" . $this->safaris . "<br/>";
        $message .= "<b>Travelers: </b>" . $this->travelers . "<br/>";
        $message .= "<b>Stay Category: </b>" . $lead->staycatgory->title . "<br/>";
        $message .= "<b>Start Date: </b>" . date('M j, Y', strtotime($this->start_date)) . "<br/>";
        $message .= "<b>End Date: </b>" . date('M j, Y', strtotime($this->end_date)) . "<br/>";

        $chat->generateChatHash();
        $chat->user_id = $login_user->id;
        $chat->recipient_user_id = $individual_user->id;
        $chat->last_message = $short_msg;
        $chat->last_message_at = time();
        $chat->status = 1;
        $chat->chat_type = 2;
        $chat->park_id = $lead->park_id;
        $chat->quote_id = $lead->id;
        $chat->is_seen = 0;

        if ($chat->save(false)) {
            $chat_message = new ChatMessage();
            $chat_message->chat_id = $chat->id;
            $chat_message->message = $message;
            // $chat_message->data = json_encode($package_data);
            $chat_message->data = NULL;
            $chat_message->status = 1;
            $chat_message->save();

            if ($chat_message->save(false)) {
                $this->PrepapareNotification($park, $operator, $login_user, $chat);
            }
        }
        return true;
    }

    private function PrepapareNotification($park, $operator, $login_user, $chat)
    {
        new \common\events\leads\PartnerLeadReceived($park, $operator->id, $login_user->id, $chat->chat_hash);
    }



    // public function request(SafariOperator $operator, $login_user)
    // {

    //     $agent = new \Jenssegers\Agent\Agent();
    //     $agent->setUserAgent(Yii::$app->request->userAgent);
    //     $operator_quote = new OperatorQuote();
    //     $operator_quote->safari_park_id = $this->safari_park_id;
    //     $operator_quote->safaris = $this->safaris;
    //     $operator_quote->travelers = $this->travelers;
    //     $operator_quote->stay_category_id = $this->stay_category_id;
    //     $operator_quote->full_name = $this->full_name;
    //     $operator_quote->email = $this->email;
    //     $operator_quote->start_date = $this->start_date;
    //     $operator_quote->end_date = $this->end_date;
    //     $operator_quote->phone_no = $this->phone_no;
    //     $operator_quote->operator_id = $operator->id;
    //     $operator_quote->ip_address = Yii::$app->getRequest()->getUserIp();
    //     $operator_quote->device_type = $agent->device();
    //     $operator_quote->user_agent =  Yii::$app->request->userAgent;
    //     $operator_quote->browser = $agent->browser();
    //     $operator_quote->os = $agent->platform();
    //     $operator_quote->status = 1;

    //     if ($operator_quote->save(false)) {
    //         //save quote chat 
    //         $individual_user = User::find()->where(['id' => $operator->user_id])->limit(1)->one();

    //         $chat = new Chat();
    //         $short_msg = $message = "<b>Park: </b>" . $operator_quote->park->title . "<br/>";
    //         $message .= "<b>Safaries: </b>" . $operator_quote->safaris . "<br/>";
    //         $message .= "<b>Travelers: </b>" . $operator_quote->travelers . "<br/>";
    //         $message .= "<b>Stay Category: </b>" . $operator_quote->staycatgory->title . "<br/>";
    //         $message .= "<b>Start Date: </b>" . date('M j, Y', strtotime($operator_quote->start_date)) . "<br/>";
    //         $message .= "<b>End Date: </b>" . date('M j, Y', strtotime($operator_quote->end_date)) . "<br/>";

    //         $chat->generateChatHash();
    //         $chat->user_id = $login_user->id ?? \Yii::$app->params['active_user_id'];
    //         $chat->recipient_user_id = $individual_user->id;
    //         $chat->last_message = $short_msg;
    //         $chat->last_message_at = time();
    //         $chat->status = 1;
    //         $chat->chat_type = 2;
    //         $chat->park_id = $operator_quote->safari_park_id;
    //         $chat->quote_id = $operator_quote->id;
    //         $chat->is_quote_accept = 0;
    //         $chat->is_seen = 0;

    //         if ($chat->save()) {
    //             $chat_message = new ChatMessage();
    //             $chat_message->chat_id = $chat->id;
    //             $chat_message->message = $message;
    //             $chat_message->status = 1;
    //             if ($chat_message->save()) {
    //                 //create mail log
    //                 $operator = SafariOperator::find()->where(['id' => $operator->id])->limit(1)->one();
    //                 $to_mail = isset($operator->user) ? $operator->user->username : '';
    //                 $subject = 'New Quote Request';
    //                 $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_FREE_QUOTE;

    //                 $chat_url = Yii::$app->urlManager->createAbsoluteUrl("/chat/message/" . Yii::$app->user->identity->user_handle . "/" . base64_encode($chat->id));
    //                 $req = ['username' => $operator->business_name, 'chat_url' => $chat_url, 'parkname' => $operator_quote->park->title, 'is_email_sending' => true];

    //                 $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //                 if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
    //                     GeneralModel::sendmailfromlog($maillog_data['log_id']);
    //                 }

    //                 FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity, $chat_url);
    //             }
    //         }
    //         //save done quote chat


    //         return $operator_quote;
    //     }
    // }
}
