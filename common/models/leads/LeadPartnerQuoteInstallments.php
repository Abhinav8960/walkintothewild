<?php

namespace common\models\leads;

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
 * @property string $before_datetime
 * @property int $status 0=>not recived
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class LeadPartnerQuoteInstallments extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
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
            [['payment_link', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['lead_partner_quote_id', 'lead_id', 'partner_id', 'amount', 'payment_hash', 'before_datetime'], 'required'],
            [['lead_partner_quote_id', 'lead_id', 'partner_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['before_datetime'], 'safe'],
            [['payment_link', 'payment_hash'], 'string', 'max' => 255],
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
            'before_datetime' => 'Before Datetime',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
