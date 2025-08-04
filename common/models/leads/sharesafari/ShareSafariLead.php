<?php
namespace common\models\leads\sharesafari;

use Yii;

/**
 * This is the model class for table "share_safari_lead".
 *
 * @property int $id
 * @property int $share_safari_id
 * @property int $share_safari_user_id
 * @property int|null $share_safari_partner_id
 * @property int $version
 * @property int $type 1=>share safari, 2=> Fixed Departure
 * @property int $quantity seat
 * @property int $notes
 * @property int|null $user_id
 * @property int $name
 * @property int $email
 * @property int $phone
 * @property string $start_date
 * @property string $end_date
 * @property float $cost_per_quantity
 * @property float $gross_price
 * @property float $discount
 * @property float $net_price
 * @property int $installment
 * @property float $received_amount
 * @property int $is_payment_received
 * @property string $payment_receipt
 * @property string|null $transaction_datetime
 * @property int $payment_gateway 1=>payu,2=>icici    
 * @property int $is_payment_expired
 * @property string|null $collection
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class ShareSafariLead extends \yii\db\ActiveRecord
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
        return 'share_safari_lead';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_partner_id', 'user_id', 'transaction_datetime', 'collection', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['installment'], 'default', 'value' => 1],
            [['is_payment_expired'], 'default', 'value' => 0],
            [['share_safari_id', 'share_safari_user_id', 'version', 'type', 'notes', 'name', 'email', 'phone', 'start_date', 'end_date', 'net_price', 'payment_receipt', 'payment_gateway', 'status'], 'required'],
            [['share_safari_id', 'share_safari_user_id', 'share_safari_partner_id', 'version', 'type', 'quantity', 'notes', 'user_id', 'name', 'email', 'phone', 'installment', 'is_payment_received', 'payment_gateway', 'is_payment_expired', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'transaction_datetime', 'collection'], 'safe'],
            [['cost_per_quantity', 'gross_price', 'discount', 'net_price', 'received_amount'], 'number'],
            [['payment_receipt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'share_safari_user_id' => 'Share Safari User ID',
            'share_safari_partner_id' => 'Share Safari Partner ID',
            'version' => 'Version',
            'type' => 'Type',
            'quantity' => 'Quantity',
            'notes' => 'Notes',
            'user_id' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'cost_per_quantity' => 'Cost Per Quantity',
            'gross_price' => 'Gross Price',
            'discount' => 'Discount',
            'net_price' => 'Net Price',
            'installment' => 'Installment',
            'received_amount' => 'Received Amount',
            'is_payment_received' => 'Is Payment Received',
            'payment_receipt' => 'Payment Receipt',
            'transaction_datetime' => 'Transaction Datetime',
            'payment_gateway' => 'Payment Gateway',
            'is_payment_expired' => 'Is Payment Expired',
            'collection' => 'Collection',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

}