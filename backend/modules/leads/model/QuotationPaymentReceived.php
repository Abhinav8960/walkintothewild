<?php

namespace backend\modules\leads\model;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;

/**
 * Class AboutForm
 * @package common\models\cms\about\form
 *
 * Handles the creation and updating of About models
 */
class QuotationPaymentReceived extends Model
{
    public $payment_gateway;
    public $transaction_id;
    public $transaction_datetime;
    public $status;

    public $form_model;

    public function __construct($form_model = null, $config = [])
    {
        parent::__construct($config);

        if ($form_model != null) {

            $this->form_model = $form_model;
            $this->payment_gateway = $this->form_model->payment_gateway;
            $this->transaction_id = $this->form_model->transaction_id;
            $this->transaction_datetime = $this->form_model->transaction_datetime;
            $this->status = $this->form_model->status;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_gateway', 'transaction_id', 'transaction_datetime'], 'required'],
            [['transaction_id'], 'string', 'max' => 251],
            [['transaction_datetime'], 'date', 'format' => 'php:Y-m-d H:i'],
            [['payment_gateway'], 'string', 'max' => 100],
            [['transaction_id'], 'unique', 'targetClass' => LeadPartnerQuotes::class, 'message' => 'This transaction ID has already been used.'],
            [['status'], 'safe'],
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_gateway' => 'Payment Gateway',
            'transaction_id' => 'Transaction ID',
            'transaction_datetime' => 'Transaction Datetime',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize form values
     *
     * @return void
     */
    public function markPaymentReceived()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->updateQuotation();
            $this->updateQuotationInstallment();
            $this->updateLead();
            $this->prepareChat();
            $this->prepareNotification();
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error marking payment received: " . $e->getMessage(), __METHOD__);
            return false;
        }
    }

    private function updateQuotation()
    {
        $this->form_model->is_payment_received = true;
        $this->form_model->transaction_id = $this->transaction_id;
        $this->form_model->payment_gateway = $this->payment_gateway;
        $this->form_model->transaction_datetime = $this->transaction_datetime;
        $this->form_model->received_amount = $this->form_model->received_amount;
        return $this->form_model->save(false);
    }

    private function updateQuotationInstallment()
    {
        $installment = $this->form_model->installment;
        $installment = LeadPartnerQuoteInstallments::find()
            ->where(['lead_partner_quote_id' => $this->form_model->id])
            ->andWhere(['status' => false])
            ->one();
        if ($installment) {
            $installment->status = true;
            $installment->payment_gateway = $this->payment_gateway;
            $installment->transaction_id = $this->transaction_id;
            $installment->transaction_datetime = $this->transaction_datetime;
            return $installment->save(false);
        }
        return true;
    }

    private function updateLead()
    {
        $lead = $this->form_model->lead;
        if ($lead) {
            $lead->is_payment_received = true;
            $lead->booked_operator_id = $this->form_model->partner_id;
            $lead->payment_gateway = $this->payment_gateway;
            $lead->transaction_id = $this->transaction_id;
            $lead->transaction_datetime = $this->transaction_datetime;
            return $lead->save(false);
        }
        return false;
    }

    private function prepareChat()
    {

        $quotation = $this->form_model;
        // $chat_model = Chat::find()->andWhere(['lead_id' => $quotation->lead_id])->andWhere(['or', ['user_id' => [$quotation->lead->user_id, $quotation->partner->user_id]], ['recipient_user_id' => [$quotation->lead->user_id, $quotation->partner->user_id]]])->andWhere(['chat_type' => 2])->one();

        $chat_model = Chat::find()
            ->andWhere(['lead_id' => $quotation->lead_id])
            ->andWhere([
                'or',
                [
                    'user_id' => $quotation->partner->user_id,
                    'recipient_user_id' => $quotation->lead->user_id
                ],
                [
                    'user_id' => $quotation->lead->user_id,
                    'recipient_user_id' => $quotation->partner->user_id
                ]
            ])
            ->andWhere(['chat_type' => 2])
            ->one();

        if (!$chat_model) {
            return Yii::$app->api->sendFailedResponse([], 'you can not send quote on this chat', 400);
        }

        $message = "Payment received for the send quotation.\n";
        $message .= "Transaction ID: " . $this->transaction_id;
        $message .= "\n";
        $message .= "Amount: " . $this->form_model->received_amount;
        $message .= "\n";



        if (isset($quotation->park->title)) {
            $message .= "Park: " . $quotation->park->title;
            $message .= "\n";
            $message .= "Safaris: " . $quotation->safaris;
        }
        $message .= "\n";
        $message .= "Travelers: " . $quotation->travelers;
        $message .= "\n";
        $message .= "Stay Category: " . @\common\models\GeneralModel::staycategoryoption()[$quotation->stay_category_id];
        $message .= "\n";
        $message .= "Start Date: " . date('M d, Y', strtotime($quotation->start_date));
        $message .= "\n";
        $message .= "End Date: " . date('M d, Y', strtotime($quotation->end_date));
        $message .= "\n";
        if (!empty($quotation->validity_date)) {
            $message .= "Validity Date: " . date('M d, Y', strtotime($quotation->validity_date));
            $message .= "\n";
        }
        if (!empty($quotation->permit_booking_date)) {
            $message .= "Permit Booking Date: " . date('M d, Y', strtotime($quotation->permit_booking_date));
            $message .= "\n";
        }

        $message .= "Notes: ";
        $message .= "\n";
        $message .= $quotation->addional_notes;

        // $x = \api\models\leads\LeadPartnerQuotes::find()->where(['id' => $quotation->id])->one();
        // $data = $x->preparedata;
        // $this->storeMessage($chat_model->id, $quotation->lead->user_id, $message, $data);
        ChatMessage::updateAll(['is_quotation_active' => 0], ['chat_id' => $chat_model->id]);
        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_model->id;
        $chat_message->message = $message;
        $chat_message->is_quotation_message = false;
        // $chat_message->quotation_id = $quotation->id;
        $chat_message->is_quotation_active = false;
        // $chat_message->data = json_encode($data);
        $chat_message->status = 1;
        $chat_message->sender_id = $quotation->partner->user_id;

        if ($chat_message->save(false)) {

            $chat = Chat::find()->where(['id' => $chat_model->id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxlength($message);
            $chat->last_message_at = time();
            $chat->quote_id = $quotation->id;
            $chat->sender_id = $quotation->partner->user_id;
            $chat->call_id = null;
            $chat->is_call_request = false;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            return $chat->save(false);
        }

        return false;
    }

    private function prepareNotification()
    {
        new \common\events\leads\QuotationPaymentReceived(
            $quotation = $this->form_model,
            $user_id = $this->form_model->lead->user_id,
            $partner_id = $this->form_model->partner_id,
            $transaction_id = $this->transaction_id,
            $payment_date = $this->transaction_datetime,
        );
        return true;
        // Prepare notification message or any other related operations
        // This is a placeholder for actual notification preparation logic
    }
}
