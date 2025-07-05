<?php

namespace api\models\leads;

use Yii;

/**
 * This is the model class for table "lead_partner_quote_installments".
 *
 * @property int $id
 * @property int $lead_partner_quote_id
 * @property int $lead_id
 * @property int $partner_id
 * @property float $amount
 * @property string|null $payment_link
 * @property string $payment_hash
 * @property string|null $qr_code_file
 * @property string $before_datetime
 * @property int $status 0=>not received, 1=> received
 * @property int|null $payment_gateway 1=>payu,2=>hdfc
 * @property string|null $transaction_id
 * @property string|null $transaction_datetime
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class LeadPartnerQuoteInstallments extends \common\models\leads\LeadPartnerQuoteInstallments
{
    public function fields()
    {
        $fields = [
            'amount',
            'payment_initiate_link',
            // 'payment_hash',
            'before_datetime',
        ];
        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_partner_quote_installments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_link', 'qr_code_file', 'payment_gateway', 'transaction_id', 'transaction_datetime', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['lead_partner_quote_id', 'lead_id', 'partner_id', 'amount', 'payment_hash', 'before_datetime'], 'required'],
            [['lead_partner_quote_id', 'lead_id', 'partner_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['before_datetime'], 'safe'],
            [['payment_link', 'payment_hash'], 'string', 'max' => 255],
            [['transaction_datetime'], 'date', 'format' => "php:Y-m-d H:i:s"],
            [['transaction_id'], 'string', 'max' => 100],
            [['payment_hash'], 'unique', 'message' => 'This payment hash has already been used.'],
            [['payment_link'], 'url', 'defaultScheme' => 'https', 'message' => 'The payment link must be a valid URL.'],
            [['is_payment_expired', 'payment_expired_datetime', 'payment_expired_reason'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_partner_quote_id' => 'Lead Partner Quote ID',
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'amount' => 'Amount',
            'payment_link' => 'Payment Link',
            'payment_hash' => 'Payment Hash',
            'qr_code_file' => 'Qr Code File',
            'before_datetime' => 'Before Datetime',
            'status' => 'Status',
            'payment_gateway' => 'Payment Gateway',
            'transaction_id' => 'Transaction ID',
            'transaction_datetime' => 'Transaction Datetime',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getPayment_initiate_link()
    {
        // return \Yii::$app->params['frontend_url'] . '/payment/' . $this->payment_hash;
        return $this->payment_link . '?utm_source=chat';
    }
}
