<?php

namespace common\models\paymentgateway\payu;

use Yii;

/**
 * This is the model class for table "payment_links".
 *
 * @property int $id
 * @property int $service 1=>PayU
 * @property string $link
 * @property string $objective
 * @property int $collection
 * @property int $collection_id
 * @property string|null $purpose
 * @property int $customer_name
 * @property int $email
 * @property int $phone_no
 * @property int $user_id
 * @property string|null $link_expiry_datetime
 * @property float $gross_amount
 * @property float $discount_amount
 * @property float $total_amount
 * @property float $gst_amount
 * @property float $net_amount
 * @property int $status 1=>link Generated
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $link_generated_datetime
 * @property string|null $payment_initiated_datetime
 */
class PaymentLinks extends \yii\db\ActiveRecord
{

    const SERVICE_PAYU = 1; // PayU
    const STATUS_DELETED = -1; // PayU
    const STATUS_CREATED = 1; // PayU
    const STATUS_INITITAED = 2; // PayU
    const STATUS_SUCCESS = 3; // PayU
    const STATUS_FAILED = 4; // PayU
    const STATUS_HOLD = 5; // PayU

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purpose', 'link_expiry_datetime', 'link_generated_datetime', 'payment_initiated_datetime'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['service', 'collection', 'collection_id',  'phone_no', 'user_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['link_hash', 'link', 'objective', 'collection', 'collection_id', 'customer_name', 'email', 'phone_no', 'user_id', 'gross_amount', 'discount_amount', 'total_amount', 'gst_amount', 'net_amount', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['link_expiry_datetime', 'link_generated_datetime', 'payment_initiated_datetime'], 'safe'],
            [['gross_amount', 'discount_amount', 'total_amount', 'gst_amount', 'net_amount'], 'number'],
            [['link', 'objective', 'purpose','customer_name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service' => 'Service',
            'link_hash' => 'Link Hash',
            'link' => 'Link',
            'objective' => 'Objective',
            'collection' => 'Collection',
            'collection_id' => 'Collection ID',
            'purpose' => 'Purpose',
            'customer_name' => 'Customer Name',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'user_id' => 'User ID',
            'link_expiry_datetime' => 'Link Expiry Datetime',
            'gross_amount' => 'Gross Amount',
            'discount_amount' => 'Discount Amount',
            'total_amount' => 'Total Amount',
            'gst_amount' => 'Gst Amount',
            'net_amount' => 'Net Amount',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'link_generated_datetime' => 'Link Generated Datetime',
            'payment_initiated_datetime' => 'Payment Initiated Datetime',
        ];
    }

    public function getStatuslabel()
    {
        switch ($this->status) {
            case self::STATUS_CREATED:
                return 'Link Generated';
            case self::STATUS_INITITAED:
                return 'Payment Initiated';
            case self::STATUS_SUCCESS:
                return 'Payment Success';
            case self::STATUS_FAILED:
                return 'Payment Failed';
            case self::STATUS_HOLD:
                return 'Payment Hold';
            default:
                return 'Unknown Status';
        }
    }

    public function getServiceLabel()
    {
        switch ($this->service) {
            case self::SERVICE_PAYU:
                return 'PayU';
            default:
                return 'Unknown Service';
        }
    }

    
}
