<?php

namespace common\models\payments;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $payment_hash
 * @property int $lead_id
 * @property int $partner_id
 * @property float $amount
 * @property int $lead_partner_quote_id
 * @property int $gateway 1=>payu,2=>hdfc
 * @property int $status 1=>initied,2=>Success,3=>failed
 * @property int $created_at
 * @property int $updated_at
 */
class Payments extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['payment_hash', 'lead_id', 'partner_id', 'amount', 'lead_partner_quote_id', 'gateway', 'created_at', 'updated_at'], 'required'],
            [['payment_hash', 'lead_id', 'partner_id', 'lead_partner_quote_id', 'gateway', 'status', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_hash' => 'Payment Hash',
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'amount' => 'Amount',
            'lead_partner_quote_id' => 'Lead Partner Quote ID',
            'gateway' => 'Gateway',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}