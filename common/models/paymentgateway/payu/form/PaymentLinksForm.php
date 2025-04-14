<?php

namespace common\models\paymentgateway\payu\form;

use common\models\paymentgateway\payu\PaymentLinks;
use common\models\paymentgateway\payu\PaymentPayuBearerTokens;
use common\models\User;
use Yii;
use yii\base\Model;


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

class PaymentLinksForm extends model
{

    public $service;
    public $link_hash;
    public $link;
    public $objective;
    public $collection;
    public $collection_id;
    public $purpose;
    public $customer_name;
    public $email;
    public $phone_no;
    public $user_id;
    public $link_expiry_datetime;
    public $gross_amount;
    public $discount_amount;
    public $total_amount;
    public $gst_amount;
    public $net_amount;
    public $status;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $link_generated_datetime;
    public $payment_initiated_datetime;

    public $form_model;


    public function __construct(PaymentLinks $form_model = null)
    {

        $this->form_model = Yii::createObject([
            'class' => PaymentLinks::className()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purpose', 'link_expiry_datetime', 'link_generated_datetime', 'payment_initiated_datetime'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['service', 'collection', 'collection_id', 'phone_no', 'user_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [[ 'objective', 'collection', 'collection_id', 'customer_name', 'email', 'phone_no',], 'required'],
            [['link_hash', 'link', 'link_expiry_datetime', 'link_generated_datetime', 'payment_initiated_datetime','user_id', 'gross_amount', 'discount_amount', 'total_amount', 'gst_amount', 'net_amount', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'safe'],
            [['gross_amount', 'discount_amount', 'total_amount', 'gst_amount', 'net_amount'], 'number'],
            [['link', 'objective', 'purpose','customer_name', 'email', ], 'string', 'max' => 255],
            [['email', ], 'email'],
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

    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->form_model->service = PaymentLinks::SERVICE_PAYU;
        $this->form_model->link_hash = \Yii::$app->security->generateRandomString(24) . '' . time();
        $this->form_model->link = $this->generatePayuPaymentLinks()['paymentLink'] ?? '';
        $this->form_model->objective = $this->objective;
        $this->form_model->collection = $this->collection;
        $this->form_model->collection_id = $this->collection_id;
        $this->form_model->purpose = $this->purpose ?? NULL;
        $this->form_model->customer_name = $this->customer_name;
        $this->form_model->email = $this->email;
        $this->form_model->phone_no = $this->phone_no;
        $this->form_model->user_id = User::findByEmailFrontend($this->email)->id ?? 0;
        $this->form_model->link_expiry_datetime = $this->link_expiry_datetime;

        // $this->form_model->gross_amount = $this->gross_amount;
        // $this->form_model->discount_amount = $this->discount_amount;
        // $this->form_model->total_amount = $this->total_amount;
        // $this->form_model->gst_amount = $this->gst_amount;
        // $this->form_model->net_amount = $this->net_amount;

        $this->form_model->gross_amount = $this->gross_amount;
        $this->form_model->discount_amount = 0.00;
        $this->form_model->total_amount = $this->gross_amount;
        $this->form_model->gst_amount = 0.00;
        $this->form_model->net_amount = $this->gross_amount;

        $this->form_model->status = PaymentLinks::STATUS_CREATED;
        $this->form_model->link_generated_datetime = date("Y-m-d H:i:s");
    }

    public function generatePayuPaymentLinks()
    {
        $curl = curl_init();

        $postData = [
            'isAmountFilledByCustomer' => false,
            'customer' => [
                'name' => $this->customer_name,
                'email' => $this->email,
                'phone' => $this->phone_no
            ],
            'description' => $this->purpose ?? 'payment',
            'source' => 'API',
            'isPartialPaymentAllowed' => false,
            'maxPaymentsAllowed' => 1,
            // 'viaEmail' => true,
            'successURL' => 'http://admin.walkintothewild.io/paymentlinks/default/create?collection=1&collection_id=1&objective=Packages',
            'failureURL' => 'http://admin.walkintothewild.io/paymentlinks/default/create?collection=1&collection_id=1&objective=Packages',
            // 'userToken' => 'link_hash',
            'subAmount' => $this->net_amount,
        ];
        if (!empty($this->link_expiry_datetime)) {
            $postData['expiryDate'] = $this->link_expiry_datetime;
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => \Yii::$app->params['payu_host_url'] . "/payment-links",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/json",
                "authorization: Bearer " . $this->payUBearerToken()
            ],
        ]);

        echo $response = curl_exec($curl);
        $err = curl_error($curl);
        die();
        curl_close($curl);

        if ($err) {
            Yii::error("cURL Error: " . $err, __METHOD__);
            return ['success' => false, 'message' => $err];
        }

        $responseData = json_decode($response, true);

        if (isset($responseData['status']) && $responseData['status'] === 'success') {
            return [
                'success' => true,
                'paymentLink' => $responseData['result']['paymentLink']
            ];
        } else {
            Yii::error("PayU API Error: " . $response, __METHOD__);
            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Unknown error occurred'
            ];
        }
    }

    private function payUBearerToken()
    {

        $m =  PaymentPayuBearerTokens::find()->where(['>','expiry_datetime', date('Y-m-d H:i:s')])->orderBy(['id' => SORT_DESC])->one();
        if (!empty($m)) {
            return $m->access_token;
        }

        $curl = curl_init();

        $postData = [
            'client_id' => \Yii::$app->params['payu_client_id'],
            'client_secret' => \Yii::$app->params['payu_client_secret'],
            'scope' => 'create_payment_links',
            'grant_type' => 'client_credentials'
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL =>  "https://uat-accounts.payu.in/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);


        curl_close($curl);

        if ($err) {
            Yii::error("cURL Error: " . $err, __METHOD__);
            return ['success' => false, 'message' => $err];
        }

        $responseData = json_decode($response, true);
        PaymentPayuBearerTokens::storeToken($responseData);
        return $responseData['access_token'] = $responseData['access_token'] ?? null;
    }
}
