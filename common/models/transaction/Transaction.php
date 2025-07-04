<?php

namespace common\models\transaction;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $reference_id
 * @property int $lead_partner_quotes_id
 * @property int $lead_partner_quote_installments_id
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
class Transaction extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{

    public const STATUS_INITIATED = 0;
    public const STATUS_SUCCESS = 1;
    public const STATUS_FAILED = 2;
    public const STATUS_HOLD = 3;
    public const STATUS_REFUNDED = 4;
    public const STATUS_CONFLICT = 5;


    public const PAYMENT_GATEWAY_PAYU = 1;
    public const PAYMENT_GATEWAY_ICICI = 2;
    public const PAYMENT_GATEWAY_HDFC = 3;

    public const PAYMENT_GATEWAY_PAYU_LABEL = "payu";
    public const PAYMENT_GATEWAY_ICICI_LABEL = "icici";
    public const PAYMENT_GATEWAY_HDFC_LABEL = "hdfc";


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
                // 'value' => function () {
                //     return $this->getActiveUserId();
                // },
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
        return \Yii::$app->user->identity->id ?? \Yii::$app->params['active_user_id'];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['park_id', 'addional_notes', 'user_id', 'name', 'email', 'phone', 'validity_date', 'permit_booking_date', 'addtional_data', 'datetime_of_approval_by_admin', 'quotation_filepath', 'transaction_datetime', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by', 'billing_address', 'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'billing_tel', 'billing_email', 'param1', 'param2', 'param3', 'param4', 'param5'], 'default', 'value' => null],
            [['currency'], 'default', 'value' => 'INR'],
            [['is_payment_received'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['reference_id', 'lead_partner_quotes_id', 'lead_partner_quote_installments_id', 'order_id', 'lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'start_date', 'end_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'partner_net_selling_price', 'net_payment_price', 'billing_name'], 'required'],
            [['lead_partner_quotes_id', 'lead_partner_quote_installments_id', 'lead_partner_id', 'lead_id', 'partner_id', 'park_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'is_payment_received', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
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
            'user_id' => 'User ID',
            'reference_id' => 'Reference ID',
            'lead_partner_quotes_id' => 'Lead Partner Quotes ID',
            'lead_partner_quote_installments_id' => 'Lead Partner Quotes Lead Partner Quote Installments     ID',
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

    public static function orderId($identifier)
    {
        return 'O-' . uniqid() . '-' . date('ym') . '-' . time() . '-' . $identifier;
    }

    public static function referenceId($identifier)
    {
        return 'R-' . uniqid() . '-' . date('ym') . '-' . time() . '-' . $identifier;
    }

    public function afterSave($insert, $changedAttributes)
    {
        // if ststus is 1 the create a row in booking table
        if ($this->status == self::STATUS_SUCCESS) {
            $this->makebooking();
            \common\models\transaction\TransactionEvents::store(\common\models\transaction\TransactionEvents::EVENT_PAYMENT_STATUS_SUCCESS, $this->lead_partner_quotes_id, $this->id);
        } else {
            \common\models\transaction\TransactionEvents::store(\common\models\transaction\TransactionEvents::EVENT_PAYMENT_STATUS_FAILED, $this->lead_partner_quotes_id, $this->id);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    private function makebooking()
    {
        $booking = new \common\models\bookings\Booking();
        $booking->transaction_id = $this->id;
        $booking->order_id = $this->order_id;
        $booking->currency = $this->currency;
        $booking->reference_id = $this->reference_id; // use the same
        $booking->lead_partner_quotes_id = $this->lead_partner_quotes_id;
        // $booking->lead_partner_quote_installments_id = $this->lead_partner_quote_installments_id;
        $booking->lead_partner_id = $this->lead_partner_id;
        $booking->lead_id = $this->lead_id;
        $booking->partner_id = $this->partner_id;
        $booking->park_id = $this->park_id;
        $booking->addional_notes = $this->addional_notes;
        $booking->safaris = $this->safaris;
        $booking->travelers = $this->travelers;
        $booking->stay_category_id = $this->stay_category_id;
        $booking->name = $this->name;
        $booking->email = $this->email;
        $booking->phone = $this->phone;
        $booking->start_date = $this->start_date;
        $booking->end_date = $this->end_date;
        $booking->validity_date = $this->validity_date;
        $booking->permit_booking_date = $this->permit_booking_date;
        $booking->partner_selling_price = $this->partner_selling_price;
        $booking->plateform_partner_fees_percentage = $this->plateform_partner_fees;
        $booking->plateform_partner_fees = $this->plateform_partner_fees;
        $booking->partner_net_selling_price = $this->partner_net_selling_price;
        $booking->plateform_customer_discount = $this->plateform_customer_discount;
        $booking->net_payment_price = $this->net_payment_price;
        $booking->installment = $this->installment;
        $booking->received_amount = $this->received_amount;
        $booking->addtional_data = $this->addtional_data;
        $booking->datetime_of_approval_by_admin = $this->datetime_of_approval_by_admin;
        $booking->quotation_filepath = $this->quotation_filepath;
        $booking->is_payment_received = 1;
        $booking->transaction_datetime = $this->transaction_datetime;
        $booking->billing_name = $this->billing_name;
        $booking->billing_address = $this->billing_address;
        $booking->billing_city = $this->billing_city;
        $booking->billing_state = $this->billing_state;
        $booking->billing_zip = $this->billing_zip;
        $booking->billing_country = $this->billing_country;
        $booking->billing_tel = $this->billing_tel;
        $booking->billing_email = $this->billing_email;
        $booking->param1 = $this->param1;
        $booking->param2 = $this->param2;
        $booking->param3 = $this->param3;
        $booking->param4 = $this->param4;
        $booking->param5 = $this->param5;
        $booking->status = 1; // initial status is 0 (initiated)
        // set the status to 1
        $booking->status = 1;
        return $booking->save(false);
    }
}
