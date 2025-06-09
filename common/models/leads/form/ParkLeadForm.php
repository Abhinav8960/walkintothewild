<?php

namespace common\models\leads\form;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use common\models\leads\Lead;
use Yii;
use yii\base\Model;
use common\models\leads\LeadPartners;
use common\models\park\SafariPark;
use common\models\User;

/**
 * OperatorQuoteForm is the model behind the contact form.
 */
class ParkLeadForm extends Model
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

    public $user_notes;


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
            [['user_notes'], 'string', 'max' => 1000],

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

    public function request($login_user)
    {

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $park = SafariPark::find()->where(['id' => $this->safari_park_id])->one();
            $lead = new Lead();
            $lead->source = Lead::SOURCE_PARK;
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
            // $lead->status = 1;
            $lead->status = 0;
            $lead->user_notes = $this->user_notes;
            $lead->assigned_operator_count = 0;


            if ($lead->save(false)) {

                $safarioperatorlist = [];
                foreach ($park->safarioperatorlist as $op) {

                    if (!empty($op->operator)) {

                        $safarioperatorlist[$op->safari_operator_id] = $op;
                        // $this->assignToPartner($lead, $op->operator, $login_user);
                        // $this->prepareChat($lead, $park, $op->operator, $login_user);
                    }
                }

                if(count($safarioperatorlist) > 0){
                    $lead->status = 1;
                    $lead->assigned_operator_count = count($safarioperatorlist);
                    $lead->save(false);
                }

                foreach ($safarioperatorlist as $op) {

                    if (!empty($op->operator)) {

                        $this->assignToPartner($lead, $op->operator, $login_user);
                        $this->prepareChat($lead, $park, $op->operator, $login_user);
                    }
                }
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
        $operator_user = User::find()->where(['id' => $operator->user_id])->limit(1)->one();

        $chat = new Chat();
        $short_msg = $message = "Hi, I am interested in". "\n";
        $short_msg .= "Park: " . $park->title . "\n";
        $message .= "Park: " . $park->title . "\n";
        $message .= "Safaries: " . $this->safaris . "\n";
        $message .= "Travelers:" . $this->travelers . "\n";
        $message .= "Stay Category:" . $lead->staycatgory->title . "\n";
        $message .= "Start Date:" . date('M j, Y', strtotime($this->start_date)) . "\n";
        $message .= "End Date:" . date('M j, Y', strtotime($this->end_date)) . "\n";
        if ($lead->user_notes != null) {
            $message .= "Notes:" . $lead->user_notes . "\n";
        }

        $chat->generateChatHash();
        $chat->lead_id = $lead->id;

        $chat->user_id = $login_user->id;
        $chat->recipient_user_id = $operator_user->id;
        $chat->last_message = $short_msg;
        $chat->last_message_at = time();
        $chat->sender_id = $login_user->id;
        $chat->status = 1;
        $chat->call_id = null;
        $chat->is_call_request = false;
        $chat->chat_type = 2;
        $chat->park_id = $lead->park_id;
        $chat->is_seen = 0;
        $chat->created_by = $login_user->id;
        $chat->updated_by = $login_user->id;

        if ($chat->save(false)) {
            $chat_message = new ChatMessage();
            $chat_message->chat_id = $chat->id;
            $chat_message->message = $message;
            // $chat_message->data = json_encode($package_data);
            $chat_message->data = NULL;
            $chat_message->status = 1;
            $chat_message->created_by = $login_user->id;
            $chat_message->updated_at = $login_user->id;
            $chat_message->save(false);

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
}
