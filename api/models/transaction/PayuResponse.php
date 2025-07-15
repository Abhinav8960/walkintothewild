<?php

namespace api\models\transaction;

use Yii;

/**
 * This is the model class for table "payu_response".
 *
 * @property int $id
 * @property string $transaction_id
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
class PayuResponse extends \common\models\transaction\PayuResponse {}
