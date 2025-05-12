<?php

namespace common\models\leads\form;;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\chat\Chat;
use api\models\package\Package;
use common\models\chat\ChatMessage;
use common\models\leads\Lead;
use common\models\leads\LeadPartners;

/**
 * PackageQuoteForm is the model behind the contact form.
 */
class PackageLeadForm extends Model
{
    public $package_id;
    public $pack_start_date;
    public $travelers;
    public $status;
    public $name;
    public $email;
    public $phone;
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'action_validate_url', 'action_url'], 'safe'],
            [['travelers', 'pack_start_date'], 'required', 'message' => '{attribute} is Required'],
            [['pack_start_date'], 'date', 'format' => 'php:Y-m-d'],
            [['travelers'], 'integer', 'min' => 1, 'max' => 100, 'tooSmall' => 'Minimum 1 traveler', 'tooBig' => 'Maximum 100 travelers'],
            [['pack_start_date'], 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>=', 'type' => 'date', 'message' => '{attribute} must be today or a future date.'],


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
            'status' => 'Status',
        ];
    }

    public function request($package_id, $login_user)
    {

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $package = Package::find()->where(['id' => $package_id])->limit(1)->one();
            $lead = new Lead();
            $lead->source = Lead::SOURCE_PACKAGE;
            $lead->package_id = $package_id;
            $lead->package_version = $package->live_version;
            $lead->operator_id = $package->owned_by_id;
            $lead->name = $this->name ?? $login_user->name;
            $lead->email = $this->email ?? $login_user->email;
            $lead->phone = $this->phone;
            $lead->travelers = $this->travelers;
            $lead->from_date = $this->pack_start_date;
            $lead->user_id = $login_user->id;
            $lead->created_by = $login_user->id;
            $lead->updated_by = $login_user->id;
            $lead->status = 1;

            if ($lead->save(false)) {
                $this->assignToPartner($lead, $package, $login_user);
                $this->prepareChat($lead, $package, $login_user);
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            // If any exception occurs, rollback the transaction
            $transaction->rollBack();
            throw $e; // Re-throw the exception to handle it higher up
        }
    }

    private function assignToPartner($lead, $package, $login_user)
    {

        $assign_to_partner = new LeadPartners();
        $assign_to_partner->lead_id = $lead->id;
        $assign_to_partner->partner_id = $package->owned_by_id;
        $assign_to_partner->status = true;
        $assign_to_partner->created_by = $login_user->id;
        $assign_to_partner->updated_by = $login_user->id;
        return $assign_to_partner->save(false);
    }

    private function prepareChat($lead, $package, $login_user)
    {
        $package_data = Package::find()->where(['id' => $lead->package_id])->asArray()->one();
        $individual_user = User::find()->where(['id' => $package->safarioperator->user_id])->limit(1)->one();

        $chat = new Chat();
        $short_msg = $message = "<b>Package: </b>" . $package->package_name . "<br/>";
        $message .= "<b>Travelers: </b>" . $lead->travelers . "<br/>";
        $message .= "<b>Start Date: </b>" . date('M j, Y', strtotime($lead->from_date)) . "<br/>";

        $chat->generateChatHash();
        $chat->lead_id = $lead->id;
        $chat->user_id = $login_user->id;
        $chat->recipient_user_id = $individual_user->id;
        $chat->last_message = $short_msg;
        $chat->last_message_at = time();
        $chat->status = 1;
        $chat->chat_type = 2;
        $chat->package_id = $lead->package_id;
        $chat->quote_id = $lead->id;
        $chat->is_seen = 0;

        if ($chat->save(false)) {
            $chat_message = new ChatMessage();
            $chat_message->chat_id = $chat->id;
            $chat_message->message = $message;
            $chat_message->data = json_encode($package_data);
            $chat_message->status = 1;
            $chat_message->save();

            if ($chat_message->save(false)) {
                $this->PrepapareNotification($package, $login_user, $chat);
            }
        }
        return true;
    }

    private function PrepapareNotification($package, $login_user, $chat)
    {
        new \common\events\leads\PackageLeadReceived($package, $login_user->id, $chat->chat_hash);
    }
}
