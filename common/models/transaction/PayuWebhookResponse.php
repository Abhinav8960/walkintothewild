<?php

namespace common\models\transaction;

use Yii;

/**
 * This is the model class for table "payu_webhook_response".
 *
 * @property int $id
 * @property string|null $mihpayid
 * @property string|null $mode
 * @property string|null $status
 * @property string|null $unmappedstatus
 * @property string|null $key
 * @property string|null $txnid
 * @property string|null $amount
 * @property string|null $card_category
 * @property string|null $discount
 * @property string|null $net_amount_debit
 * @property string|null $addedon
 * @property string|null $productinfo
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $zipcode
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $udf1
 * @property string|null $udf2
 * @property string|null $udf3
 * @property string|null $udf4
 * @property string|null $udf5
 * @property string|null $udf6
 * @property string|null $udf7
 * @property string|null $udf8
 * @property string|null $udf9
 * @property string|null $udf10
 * @property string|null $hash
 * @property string|null $field1
 * @property string|null $field2
 * @property string|null $field3
 * @property string|null $field4
 * @property string|null $field5
 * @property string|null $field6
 * @property string|null $field7
 * @property string|null $field8
 * @property string|null $field9
 * @property string|null $payment_source
 * @property string|null $pa_name
 * @property string|null $pg_type
 * @property string|null $bank_ref_num
 * @property string|null $bankcode
 * @property string|null $error
 * @property string|null $error_Message
 * @property string|null $cardnum
 * @property string|null $cardhash
 * @property string|null $response
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class PayuWebhookResponse extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

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

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payu_webhook_response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mihpayid', 'mode', 'status', 'unmappedstatus', 'key', 'txnid', 'amount', 'card_category', 'discount', 'net_amount_debit', 'addedon', 'productinfo', 'firstname', 'lastname', 'address1', 'address2', 'city', 'state', 'country', 'zipcode', 'email', 'phone', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5', 'udf6', 'udf7', 'udf8', 'udf9', 'udf10', 'hash', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'payment_source', 'pa_name', 'pg_type', 'bank_ref_num', 'bankcode', 'error', 'error_Message', 'cardnum', 'cardhash', 'response', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['addedon', 'response'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['mihpayid', 'status', 'unmappedstatus', 'txnid', 'amount', 'card_category', 'discount', 'net_amount_debit', 'productinfo', 'firstname', 'lastname', 'address1', 'address2', 'city', 'state', 'country', 'zipcode', 'email', 'phone', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5', 'udf6', 'udf7', 'udf8', 'udf9', 'udf10', 'hash', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'payment_source', 'pa_name', 'pg_type', 'bank_ref_num', 'bankcode', 'error', 'error_Message', 'cardnum', 'cardhash'], 'string', 'max' => 255],
            [['mode', 'key'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mihpayid' => 'Mihpayid',
            'mode' => 'Mode',
            'status' => 'Status',
            'unmappedstatus' => 'Unmappedstatus',
            'key' => 'Key',
            'txnid' => 'Txnid',
            'amount' => 'Amount',
            'card_category' => 'Card Category',
            'discount' => 'Discount',
            'net_amount_debit' => 'Net Amount Debit',
            'addedon' => 'Addedon',
            'productinfo' => 'Productinfo',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'zipcode' => 'Zipcode',
            'email' => 'Email',
            'phone' => 'Phone',
            'udf1' => 'Udf1',
            'udf2' => 'Udf2',
            'udf3' => 'Udf3',
            'udf4' => 'Udf4',
            'udf5' => 'Udf5',
            'udf6' => 'Udf6',
            'udf7' => 'Udf7',
            'udf8' => 'Udf8',
            'udf9' => 'Udf9',
            'udf10' => 'Udf10',
            'hash' => 'Hash',
            'field1' => 'Field1',
            'field2' => 'Field2',
            'field3' => 'Field3',
            'field4' => 'Field4',
            'field5' => 'Field5',
            'field6' => 'Field6',
            'field7' => 'Field7',
            'field8' => 'Field8',
            'field9' => 'Field9',
            'payment_source' => 'Payment Source',
            'pa_name' => 'Pa Name',
            'pg_type' => 'Pg Type',
            'bank_ref_num' => 'Bank Ref Num',
            'bankcode' => 'Bankcode',
            'error' => 'Error',
            'error_Message' => 'Error Message',
            'cardnum' => 'Cardnum',
            'cardhash' => 'Cardhash',
            'response' => 'Response',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
