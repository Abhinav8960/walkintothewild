<?php

namespace common\models\bookings;

use common\models\leads\LeadPartners;
use Yii;

/**
 * This is the model class for table "booking".
 *
 * @property int $id
 * @property int $transaction_id
 * @property string $reference_id
 * @property string $order_id
 * @property string $currency
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
 * @property string|null $validity_date
 * @property string|null $permit_booking_date
 * @property float $partner_selling_price
 * @property int $plateform_partner_fees_percentage %
 * @property float $plateform_partner_fees
 * @property float $partner_net_selling_price
 * @property float $plateform_customer_discount
 * @property float $net_payment_price
 * @property int $installment
 * @property float $received_amount
 * @property string|null $addtional_data
 * @property string|null $datetime_of_approval_by_admin
 * @property string|null $quotation_filepath
 * @property int $is_payment_received
 * @property string|null $transaction_datetime
 * @property int|null $payment_gateway     1=>payu,2=>icic,3=>hdfc
 * @property string $billing_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $billing_address
 * @property string|null $billing_city
 * @property string|null $billing_state
 * @property string|null $billing_zip
 * @property string|null $billing_country
 * @property string|null $billing_tel
 * @property string|null $billing_email
 * @property string|null $param1
 * @property string|null $param2
 * @property string|null $param3
 * @property string|null $param4
 * @property string|null $param5
 * @property int|null $status
 */
class Booking extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{



    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => function () {
                    return $this->getActiveUserId(); // Use current user ID or null if guest
                },
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    protected function getActiveUserId()
    {
        return \Yii::$app->user->identity->id ?? \Yii::$app->params['active_user_id'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['park_id', 'addional_notes', 'name', 'email', 'phone', 'validity_date', 'permit_booking_date', 'addtional_data', 'datetime_of_approval_by_admin', 'quotation_filepath', 'transaction_datetime', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by', 'billing_address', 'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'billing_tel', 'billing_email', 'param1', 'param2', 'param3', 'param4', 'param5'], 'default', 'value' => null],
            [['currency'], 'default', 'value' => 'INR'],
            [['is_payment_received'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['transaction_id', 'reference_id', 'order_id', 'lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'start_date', 'end_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'partner_net_selling_price', 'net_payment_price', 'billing_name'], 'required'],
            [['transaction_id', 'lead_partner_id', 'lead_id', 'partner_id', 'park_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'is_payment_received', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'lead_partner_quotes_id'], 'integer'],
            [['addional_notes'], 'string'],
            [['start_date', 'end_date', 'validity_date', 'permit_booking_date', 'addtional_data', 'datetime_of_approval_by_admin', 'transaction_datetime'], 'safe'],
            [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'received_amount'], 'number'],
            [['reference_id', 'order_id', 'name', 'email', 'quotation_filepath', 'billing_name', 'billing_address', 'billing_city', 'billing_state', 'billing_country', 'billing_email', 'param1', 'param2', 'param3', 'param4', 'param5'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            [['phone'], 'string', 'max' => 50],
            [['billing_zip'], 'string', 'max' => 30],
            [['billing_tel'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'reference_id' => 'Reference ID',
            'order_id' => 'Order ID',
            'currency' => 'Currency',
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
            'validity_date' => 'Validity Date',
            'permit_booking_date' => 'Permit Booking Date',
            'partner_selling_price' => 'Partner Selling Price',
            'plateform_partner_fees_percentage' => 'Plateform Partner Fees Percentage',
            'plateform_partner_fees' => 'Plateform Partner Fees',
            'partner_net_selling_price' => 'Partner Net Selling Price',
            'plateform_customer_discount' => 'Plateform Customer Discount',
            'net_payment_price' => 'Net Payment Price',
            'installment' => 'Installment',
            'received_amount' => 'Received Amount',
            'addtional_data' => 'Addtional Data',
            'datetime_of_approval_by_admin' => 'Datetime Of Approval By Admin',
            'quotation_filepath' => 'Quotation Filepath',
            'is_payment_received' => 'Is Payment Received',
            'transaction_datetime' => 'Transaction Datetime',
            'payment_gateway' => 'Payment Gateway',
            'billing_name' => 'Billing Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'billing_address' => 'Billing Address',
            'billing_city' => 'Billing City',
            'billing_state' => 'Billing State',
            'billing_zip' => 'Billing Zip',
            'billing_country' => 'Billing Country',
            'billing_tel' => 'Billing Tel',
            'billing_email' => 'Billing Email',
            'param1' => 'Param1',
            'param2' => 'Param2',
            'param3' => 'Param3',
            'param4' => 'Param4',
            'param5' => 'Param5',
            'status' => 'Status',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->status == 1 && $insert) {
            // lead booking status update
            $this->updateLeadBookingStatus();
            // close lead chat
            $this->closeLeadChat();
            // close all payment links
            $this->closePaymentLinks();
            // send booking confirmation email
            // $this->sendBookingConfirmationEmail();
        }
    }



    private function updateLeadBookingStatus()
    {
        $lead = \common\models\leads\Lead::findOne($this->lead_id);
        if ($lead) {
            $lead->is_payment_received = 1;
            $lead->payment_gateway = $this->payment_gateway;
            $lead->transaction_id = $this->transaction_id;
            $lead->transaction_datetime = $this->transaction_datetime;
            $lead->save(false);
        }
        $leadPartner = LeadPartners::findOne($this->lead_partner_id);
        if ($leadPartner) {
            $leadPartner->is_payment_received = 1;
            $leadPartner->payment_gateway = $this->payment_gateway;
            $leadPartner->transaction_id = $this->transaction_id;
            $leadPartner->transaction_datetime = $this->transaction_datetime;
            $leadPartner->save(false);
        }
        $leadPartnerQuotes = \common\models\leads\LeadPartnerQuotes::findOne(['id' => $this->lead_partner_quotes_id]);
        if ($leadPartnerQuotes) {
            $leadPartnerQuotes->is_payment_received = 1;
            $leadPartnerQuotes->payment_gateway = $this->payment_gateway;
            $leadPartnerQuotes->transaction_id = $this->transaction_id;
            $leadPartnerQuotes->transaction_datetime = $this->transaction_datetime;
            $leadPartnerQuotes->save(false);
        }
        $leadPartnerQuoteInstallments = \common\models\leads\LeadPartnerQuoteInstallments::findOne(['lead_partner_quote_id' => $this->lead_partner_quotes_id]);
        // Update the installment status if it exists
        // This assumes that the installment is linked to the lead and partner quote
        if ($leadPartnerQuoteInstallments) {
            $leadPartnerQuoteInstallments->is_payment_received = 1;
            $leadPartnerQuoteInstallments->status = \common\models\leads\LeadPartnerQuoteInstallments::STATUS_RECEIVED;
            $leadPartnerQuoteInstallments->payment_gateway = $this->payment_gateway;
            $leadPartnerQuoteInstallments->transaction_id = $this->transaction_id;
            $leadPartnerQuoteInstallments->transaction_datetime = $this->transaction_datetime;
            $leadPartnerQuoteInstallments->save(false);
        }
    }

    private function closeLeadChat()
    {
        $leadPartnerQuotes = \common\models\leads\LeadPartnerQuotes::findOne(['id' => $this->lead_partner_quotes_id]);
        if ($leadPartnerQuotes) {
            return  $leadPartnerQuotes->closeChat($this->lead_partner_quotes_id);
        }
        return true;
    }

    private function closePaymentLinks()
    {
        $leadPartnerQuoteInstallments = \common\models\leads\LeadPartnerQuoteInstallments::findAll(['lead_partner_quote_id' => $this->lead_partner_quotes_id, 'is_payment_received' => 0]);
        if (!empty($leadPartnerQuoteInstallments)) {
            foreach ($leadPartnerQuoteInstallments as $installment) {
                $installment->is_payment_expired = 1;
                $installment->save(false);
            }
        }
        return true;
    }
}
