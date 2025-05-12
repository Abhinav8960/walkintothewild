<?php

namespace common\models\leads;

use Yii;

/**
 * This is the model class for table "lead_partner_quotes".
 *
 * @property int $id
 * @property int $lead_partner_id
 * @property int $lead_id
 * @property int $partner_id
 * @property int $safari
 * @property int $travellers
 * @property int $stay_category_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $start_date
 * @property float $partner_selling_price
 * @property int $plateform_partner_fees_percentage %
 * @property float $plateform_partner_fees
 * @property float $partner_net_selling_price
 * @property float $plateform_customer_discount
 * @property float $net_payment_price
 * @property int $installment
 * @property float $recived_amount
 * @property string $end_date
 * @property string|null $addtional_data
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class LeadPartnerQuotes extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
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
        return 'lead_partner_quotes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['addtional_data', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['recived_amount'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['lead_partner_id', 'lead_id', 'partner_id', 'safari', 'travellers', 'stay_category_id', 'name', 'email', 'phone', 'start_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'partner_net_selling_price', 'net_payment_price', 'end_date'], 'required'],
            [['lead_partner_id', 'lead_id', 'partner_id', 'safari', 'travellers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'addtional_data'], 'safe'],
            [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'recived_amount'], 'number'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_partner_id' => 'Lead Partner ID',
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'safari' => 'Safari',
            'travellers' => 'Travellers',
            'stay_category_id' => 'Stay Category ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'start_date' => 'Start Date',
            'partner_selling_price' => 'Partner Selling Price',
            'plateform_partner_fees_percentage' => 'Plateform Partner Fees Percentage',
            'plateform_partner_fees' => 'Plateform Partner Fees',
            'partner_net_selling_price' => 'Partner Net Selling Price',
            'plateform_customer_discount' => 'Plateform Customer Discount',
            'net_payment_price' => 'Net Payment Price',
            'installment' => 'Installment',
            'recived_amount' => 'Recived Amount',
            'end_date' => 'End Date',
            'addtional_data' => 'Addtional Data',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
