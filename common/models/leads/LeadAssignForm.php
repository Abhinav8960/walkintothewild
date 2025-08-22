<?php

namespace common\models\leads;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\User;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\park\SafariPark;
use Yii;
use yii\base\Model;

/**
 * LeadAssignForm is the model behind the contact form.
 */
class LeadAssignForm extends Model
{
    public $partner_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_id'], 'required'],
            [['partner_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'partner_id' => 'Select Partner',
        ];
    }


    public function assign($lead, $partner_id)
    {
        $operator = SafariOperator::find()->where(['id' => $partner_id, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();
        $lead_park = SafariPark::find()->where(['id' => $lead->park_id, 'status' => SafariPark::STATUS_ACTIVE])->limit(1)->one();

        $this->assignToPartnerByAdmin($lead, $operator);
        $this->prepareChat($lead, $lead_park, $operator);
    }

    private function assignToPartnerByAdmin($lead, $operator)
    {

        \Yii::$app->params['active_user_id'] = $lead->user_id;
        $assign_to_partner = new LeadPartners();
        $assign_to_partner->lead_id = $lead->id;
        $assign_to_partner->partner_id = $operator->id;
        $assign_to_partner->status = true;
        $assign_to_partner->is_assign_by_admin = 1;
        $assign_to_partner->assign_by_admin_date_time = time();
        $assign_to_partner->created_by = Yii::$app->user->identity->id;
        $assign_to_partner->updated_by = Yii::$app->user->identity->id;
        return $assign_to_partner->save(false);
    }

    private function prepareChat($lead, $park, $operator)
    {
        $individual_user = User::find()->where(['id' => $operator->user_id])->limit(1)->one();

        $chat = new Chat();
        $short_msg = $message = "Hi, I am interested in" . "\n";
        $short_msg .= "Park: " . $park->title . "\n";
        $message .= "Park: " . $park->title . "\n";
        $message .= "Safaries: " . $lead->safaris . "\n";
        $message .= "Travelers:" . $lead->travelers . "\n";
        $message .= "Accommodation:" . $lead->staycatgory->title . "\n";
        $message .= "Start Date:" . date('M j, Y', strtotime($lead->from_date)) . "\n";
        $message .= "End Date:" . date('M j, Y', strtotime($lead->to_date)) . "\n";
        if ($lead->user_notes != null) {
            $message .= "Notes:" . $lead->user_notes . "\n";
        }

        $chat->generateChatHash();
        $chat->lead_id = $lead->id;

        $chat->user_id = $lead->user_id;
        $chat->recipient_user_id = $individual_user->id;
        $chat->last_message = $short_msg;
        $chat->last_message_at = time();
        $chat->status = 1;
        $chat->chat_type = 2;
        $chat->park_id = $lead->park_id;
        $chat->is_seen = 0;
        $chat->created_by = $lead->user_id;
        $chat->updated_by = $lead->user_id;

        if ($chat->save(false)) {
            $chat_message = new ChatMessage();
            $chat_message->chat_id = $chat->id;
            $chat_message->message = $message;
            // $chat_message->data = json_encode($package_data);
            $chat_message->data = NULL;
            $chat_message->status = 1;
            $chat_message->created_by = $lead->user_id;
            $chat_message->updated_at = $lead->user_id;
            $chat_message->save(false);

            if ($chat_message->save(false)) {
                // $this->PrepapareNotification($park, $operator, $login_user, $chat);
            }
        }
    }

    private function PrepapareNotification($park, $operator, $login_user, $chat)
    {
        new \common\events\leads\PartnerLeadReceived($park, $operator->id, $login_user->id, $chat->chat_hash);
    }
}
