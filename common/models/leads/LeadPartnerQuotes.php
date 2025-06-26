<?php

namespace common\models\leads;

use common\models\meta\MetaPackageRange;
use common\models\meta\MetaStayCategory;
use common\models\operator\SafariOperator;
use common\models\park\SafariPark;
use Yii;

/**
 * This is the model class for table "lead_partner_quotes".
 *
 * @property int $id
 * @property int $lead_partner_id
 * @property int $lead_id
 * @property int $partner_id
 * @property int|null $park_id
 * @property string|null $addional_notes
 * @property int $safaris
 * @property int $travelers
 * @property int $stay_category_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string $start_date
 * @property string $end_date
 * @property float $partner_selling_price
 * @property int $plateform_partner_fees_percentage %
 * @property float $plateform_partner_fees
 * @property float $partner_net_selling_price
 * @property float $plateform_customer_discount
 * @property float $net_payment_price
 * @property int $installment
 * @property float $received_amount
 * @property string|null $addtional_data
 * @property int $is_approved_by_admin
 * @property string|null $datetime_of_approval_by_admin
 * @property string|null $rejection_reason
 * @property string|null $quotation_filepath
 * @property int|null $status
 * @property int|null $created_at
 * @property int $is_payment_received
 * @property string|null $transaction_id
 * @property string|null $transaction_datetime
 * @property int|null $payment_gateway 1=>payu,2=>hdfc
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class LeadPartnerQuotes extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    const IS_APPROVED_BY_ADMIN_PENDING = 0;
    const IS_APPROVED_BY_ADMIN_APPROVED = 1;
    const IS_APPROVED_BY_ADMIN_REJECT = 2;

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

    // /**
    //  * {@inheritdoc}
    //  */
    // public function rules()
    // {
    //     return [
    //         [['addtional_data', 'datetime_of_approval_by_admin', 'quotation_filepath', 'created_at', 'updated_at', 'created_by', 'updated_by', 'park_id'], 'default', 'value' => null],
    //         [['received_amount', 'is_approved_by_admin'], 'default', 'value' => 0],
    //         [['status'], 'default', 'value' => 1],
    //         [['lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'name', 'email', 'start_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'partner_net_selling_price', 'net_payment_price', 'end_date'], 'required'],
    //         [['lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
    //         [['start_date', 'end_date', 'addtional_data', 'addional_notes', 'rejection_reason'], 'safe'],
    //         [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'received_amount'], 'number'],
    //         [['name', 'email'], 'string', 'max' => 255],
    //         [['phone'], 'string', 'max' => 50],


    //     ];
    // }

    public function rules()
    {
        return [
            [['park_id', 'addional_notes', 'name', 'email', 'phone', 'addtional_data', 'datetime_of_approval_by_admin', 'rejection_reason', 'quotation_filepath', 'created_at', 'transaction_id', 'transaction_datetime', 'payment_gateway', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['is_payment_received'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'start_date', 'end_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'partner_net_selling_price', 'net_payment_price'], 'required'],
            [['lead_partner_id', 'lead_id', 'partner_id', 'park_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'is_approved_by_admin', 'status', 'created_at', 'is_payment_received', 'payment_gateway', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['addional_notes'], 'string'],
            [['start_date', 'end_date', 'addtional_data', 'datetime_of_approval_by_admin', 'transaction_datetime'], 'safe'],
            [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'received_amount'], 'number'],
            [['name', 'email', 'rejection_reason', 'quotation_filepath', 'transaction_id'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['validity_date', 'permit_booking_date'], 'safe'],
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
            'park_id' => 'Park ID',
            'addional_notes' => 'Addional Notes',
            'safaris' => 'Safaris',
            'travelers' => 'Travelers',
            'stay_category_id' => 'Stay Category ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'partner_selling_price' => 'Partner Selling Price',
            'plateform_partner_fees_percentage' => 'Plateform Partner Fees Percentage',
            'plateform_partner_fees' => 'Plateform Partner Fees',
            'partner_net_selling_price' => 'Partner Net Selling Price',
            'plateform_customer_discount' => 'Plateform Customer Discount',
            'net_payment_price' => 'Net Payment Price',
            'installment' => 'Installment',
            'received_amount' => 'Received Amount',
            'addtional_data' => 'Addtional Data',
            'is_approved_by_admin' => 'Is Approved By Admin',
            'datetime_of_approval_by_admin' => 'Datetime Of Approval By Admin',
            'rejection_reason' => 'Rejection Reason',
            'quotation_filepath' => 'Quotation Filepath',
            'status' => 'Status',
            'created_at' => 'Created At',
            'is_payment_received' => 'Is Payment Received',
            'transaction_id' => 'Transaction ID',
            'transaction_datetime' => 'Transaction Datetime',
            'payment_gateway' => 'Payment Gateway',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'validity_date' => 'Validity Date',
            'permit_booking_date' => 'Permit Booking Date',
        ];
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getPark_label()
    {
        return $this->park->title ?? NULL;
    }

    public function getLead()
    {
        return $this->hasOne(Lead::className(), ['id' => 'lead_id']);
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'partner_id']);
    }

    public function getStaycatgory()
    {
        return $this->hasOne(MetaStayCategory::className(), ['id' => 'stay_category_id']);
    }

    public function getDue_quatation()
    {
        return $this->hasOne(LeadPartnerQuoteInstallments::className(), ['lead_partner_quote_id' => 'id'])->where(['is NOT', 'payment_link', NULL])->orderBy(['id' => SORT_DESC]);
    }

    public function getInstallment()
    {
        // return $this->hasOne(LeadPartnerQuoteInstallments::className(), ['lead_partner_quote_id' => 'id'])->where(['is NOT', 'transaction_id', NULL])->orderBy(['id' => SORT_DESC]);
        return $this->hasOne(LeadPartnerQuoteInstallments::className(), ['lead_partner_quote_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $quotation = LeadPartnerQuotes::find()->where(['status' => LeadPartnerQuotes::STATUS_ACTIVE, 'id' => $this->id])->one();
        if ($quotation != null) {
            return new \common\events\operator\QuotationSendByOperator($quotation, $this->lead->user_id, $this->partner->user_id);
        }
    }
}
