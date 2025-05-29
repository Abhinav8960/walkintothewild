<?php

namespace backend\modules\leads\model;

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
    public $payment_gateway_options = [];
    public $transaction_id;
    public $transaction_datetime;
    public $status;

    public $action_url;
    public $action_validate_url;
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
        $this->payment_gateway_options = GeneralModel::PaymentgatewayOptions();
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
}
