<?php

namespace console\controllers;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\leads\LeadPartners;
use api\models\park\SafariPark;
use api\models\User;
use common\models\leads\Lead;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use Yii;
use yii\console\Controller;

/**
 * LeadAssignController implements the CRUD actions for FrontendRequestLog model.
 */
class LeadAssignController extends Controller
{


    public function actionLeadAssign()
    {
        $safari_operator_id = 90;
        $op = SafariOperator::find()->where(['id'=>$safari_operator_id])->limit(1)->one();
        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $safari_operator_id, 'status' => SafariOperatorPark::STATUS_ACTIVE])->all();
        foreach ($operator_parks as $lead_park) {
            $leads = Lead::find()->where(['>=', 'from_date', date('Y-m-d')])->andWhere(['<=', 'created_at', 1750427999])->andWhere(['status' => Lead::STATUS_ACTIVE, 'park_id' => $lead_park->park_id, 'source' => Lead::SOURCE_PARK, 'transaction_id' => null])->all();
            foreach ($leads as $lead) {
                $this->request($lead,$op,$lead_park);
            }
        }
        echo "Done";
    }

    public function request($lead,$op,$lead_park)
    {

        // $transaction = \Yii::$app->db->beginTransaction();
        // try {

        if(!$this->IsAssignToPartner($lead, $op)){
            $this->assignToPartner($lead, $op);
            $this->prepareChat($lead, $lead_park, $op);

        }

            // $transaction->commit();
            // return true;
        // } catch (\Exception $e) {
        //     $transaction->rollBack();
        //     throw $e; 
        // }
    }

    private function IsAssignToPartner($lead, $operator)
    {

        return LeadPartners::find()->where(['lead_id'=>$lead->id,'partner_id'=>$operator->id])->exists();
       
    }

    private function assignToPartner($lead, $operator)
    {

        $assign_to_partner = new LeadPartners();
        $assign_to_partner->lead_id = $lead->id;
        $assign_to_partner->partner_id = $operator->id;
        $assign_to_partner->status = true;
        $assign_to_partner->created_by = $lead->user_id;
        $assign_to_partner->updated_by = $lead->user_id;
        return $assign_to_partner->save(false);
    }

    private function prepareChat($lead, $park, $operator)
    {
        $operator_user = User::find()->where(['id' => $operator->user_id])->limit(1)->one();

        $chat = new Chat();
        $short_msg = $message = "Hi, I am interested in" . "\n";
        $short_msg .= "Park: " . $park->park->title . "\n";
        $message .= "Park: " . $park->park->title . "\n";
        $message .= "Safaries: " . $lead->safaris . "\n";
        $message .= "Travelers:" . $lead->travelers . "\n";
        $message .= "Stay Category:" . $lead->staycatgory->title . "\n";
        $message .= "Start Date:" . date('M j, Y', strtotime($lead->from_date)) . "\n";
        $message .= "End Date:" . date('M j, Y', strtotime($lead->to_date)) . "\n";
        if ($lead->user_notes != null) {
            $message .= "Notes:" . $lead->user_notes . "\n";
        }

        $chat->generateChatHash();
        $chat->lead_id = $lead->id;

        $chat->user_id = $lead->user_id;
        $chat->recipient_user_id = $operator->user_id;
        $chat->last_message = $short_msg;
        $chat->last_message_at = time();
        // $chat->sender_id = $lead->user_id;
        $chat->status = 1;
        // $chat->call_id = null;
        // $chat->is_call_request = false;
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
        return true;
    }

    private function PrepapareNotification($park, $operator, $login_user, $chat)
    {
        new \common\events\leads\PartnerLeadReceived($park, $operator->id, $login_user->id, $chat->chat_hash);
    }
}
