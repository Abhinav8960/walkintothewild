<?php

namespace api\modules\transaction\controllers;

use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use common\models\transaction\Transaction;
use common\models\transaction\TransactionSearch;
use api\controllers\RestController;

use yii;

/**
 * Default controller for the `error` module
 */
class DefaultController extends RestController
{


    public function actionInitiate($lead_partner_quotes_id, $payment_gateway)
    {

        if (in_array($payment_gateway, [LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_ICICI, LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_ICICI_LABEL])) {
            return $this->icici($lead_partner_quotes_id);
        } elseif (in_array($payment_gateway, [LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_PAYU, LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_PAYU_LABEL])) {
            return $this->payu($lead_partner_quotes_id);
        }
        // elseif (in_array($payment_gateway, [LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_HDFC, LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_HDFC_LABEL])) {
        //     return $this->redirect(['hdfc', 'lead_partner_quotes_id' => $lead_partner_quotes_id]);
        // } else {
        //     Yii::$app->session->setFlash('error', 'Invalid payment gateway selected.');
        //     return $this->redirect(['index']);
        // }
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Invalid payment gateway selected."]);
    }

    protected function findModel($lead_partner_quotes_id)
    {
        $model = LeadPartnerQuotes::find()->andWhere(['id' => $lead_partner_quotes_id])->one();
        if (!$model) {
            // Yii::$app->session->setFlash('error', 'Lead Partner Quote not found.');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Lead Partner Quote not found."]);
        }
        if ($model->status != LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED) {
            Yii::$app->session->setFlash('error', 'Lead Partner Quote is not approved by admin.');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Lead Partner Quote is not approved by admin."]);
        }
        return $model;
    }

    private function payu($lead_partner_quotes_id)
    {
        $model = $this->findModel($lead_partner_quotes_id);

        // Fetch PayU configuration parameters
        $merchantKey = Yii::$app->params['payu']['merchantKey'];
        $salt = Yii::$app->params['payu']['salt'];
        $payuBaseUrl = Yii::$app->params['payu']['host_url'];

        // Validate merchantKey
        if (empty($merchantKey)) {
            Yii::error('Merchant Key is missing in PayU configuration.', 'transaction');
            // Yii::$app->session->setFlash('error', 'Payment gateway configuration error: Merchant Key is missing.');
            // return $this->redirect(['index']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Faced payment gateway Technical error, please try again later."]);
        }

        // Prepare transaction details
        $orderId = Transaction::orderId($model->id);
        $reference_id = Transaction::referenceId($model->id);
        $amount = $model->partner_selling_price;
        // $currency = 'INR';

        // Prepare data for PayU
        $data = [];
        $store = $data['payu'] = [
            'key' => $merchantKey,
            'txnid' => $orderId,
            'amount' => $amount,
            'productinfo' => 'Lead Partner Quote Payment',
            'firstname' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'surl' => Yii::$app->params['payu']['successUrl'],
            'furl' => Yii::$app->params['payu']['failureUrl'],
            'udf1' => $reference_id,
            'udf2' => $orderId,
        ];

        // Generate hash for PayU
        $data['payu']['hash'] = $this->generatePayuHash($data, $salt);
        \Yii::error('PayU Data: ' . json_encode($data), 'transaction');
        // store the transaction in the database
        $this->storePayu($lead_partner_quotes_id,  $store);
        return Yii::$app->api->sendResponse($data);
    }

    private function generatePayuHash($data, $salt)
    {

        $hashPattern = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $fieldsOrder = explode('|', $hashPattern);
        // Initialize the hash string
        $hashString = '';

        // Append values from $data based on the order
        foreach ($fieldsOrder as $field) {
            $hashString .= isset($data['payu'][$field]) ? $data['payu'][$field] . '|' : '|';
        }

        // Append the salt at the end
        $hashString .= $salt;
        // echo $hashString;
        // die();
        // Generate and return the hash
        return strtolower(hash('sha512', $hashString));
    }

    private function icici($lead_partner_quotes_id)
    {
        $model = $this->findModel($lead_partner_quotes_id);

        $merchantId = Yii::$app->params['ccavenue']['merchantId'];
        $accessCode = Yii::$app->params['ccavenue']['accessCode'];
        $workingKey = Yii::$app->params['ccavenue']['workingKey'];
        $redirectUrl = Yii::$app->params['ccavenue']['redirectUrl'];
        $api_url = Yii::$app->params['ccavenue']['api_url'];

        $orderId = Transaction::orderId($model->id);
        $amount = $model->partner_selling_price;
        $currency = 'INR';
        $data = [
            'merchant_id' => $merchantId,
            'order_id' => $orderId,
            'amount' => $amount,
            'currency' => $currency,
            'redirect_url' => $redirectUrl,
            'cancel_url' => Yii::$app->params['ccavenue']['cancelUrl'],
            'language' => 'EN',
            'billing_name' => $model->name,
            // 'billing_tel' => $model->phone,
            'billing_tel' => '9650901148',
            'billing_email' => $model->email,
            'merchant_param1' => $model->lead->id,
            'merchant_param2' => $model->partner->id,
            'tid' => time() . '-' . $model->id,
        ];

        // echo "<pre>";
        // print_r($data);
        // die();

        $dataString = http_build_query($data);

        try {
            $encryptedData = $this->encryptCCAvenueData($dataString, $workingKey);

            if ($encryptedData === false) {
                throw new \yii\base\InvalidArgumentException('Encryption failed.');
            }
            // echo "Encrypted Data: " . $encryptedData;
            // echo "<br>";
            // echo "accessCode Data: " . $accessCode;
            // die();
            // $paymentUrl = '?encRequest=' . urlencode($encryptedData) . '&access_code=' . $accessCode;
            // $paymentUrl = $api_url . '?encRequest=' . urlencode($encryptedData) . '&access_code=' . $accessCode;
            $paymentUrl = $api_url;

            Yii::info('Encrypted Data: ' . $encryptedData, 'transaction');
            Yii::info('Payment URL: ' . $paymentUrl, 'transaction');
            $output = [];
            $output['icici'] = [
                'encRequest' => $encryptedData,
                'access_code' => $accessCode,
                'payment_url' => $paymentUrl,
            ];
            // store the transaction in the database
            $this->store($payment_gateway = LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_ICICI, $lead_partner_quotes_id, $data);
            return Yii::$app->api->sendResponse($output);

            // return $this->redirect($paymentUrl);
        } catch (\yii\base\InvalidArgumentException $e) {
            // Yii::$app->session->setFlash('error', 'Encryption failed: ' . $e->getMessage());
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Faced payment gateway Technical error, please try again later."]);

            // return $this->redirect(['index']);
        }
    }

    /**
     * Encrypt data for CCAvenue
     * @param string $data
     * @param string $workingKey
     * @return string
     * @throws yii\base\InvalidArgumentException if encryption fails
     */
    private function encryptCCAvenueData($data, $workingKey)
    {
        if (empty($data)) {
            throw new \yii\base\InvalidArgumentException('Data to encrypt cannot be empty.');
        }

        if (empty($workingKey) || strlen($workingKey) < 16) {
            throw new \yii\base\InvalidArgumentException('Working key must be at least 16 characters long.');
        }

        // Ensure the IV is 16 bytes long
        $iv = substr($workingKey, 0, 16);

        $encryptedData = openssl_encrypt($data, 'AES-128-CBC', $workingKey, 0, $iv);

        if ($encryptedData === false) {
            throw new \yii\base\InvalidArgumentException('Failed to encrypt data.');
        }

        return $encryptedData;
    }

    private function storePayu($lead_partner_quotes_id, $data = [])
    {


        // db transaction begin
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($lead_partner_quotes_id);
            // Store the transaction in the database
            $t = new Transaction();
            $t->user_id = $this->userinfoId;
            $t->lead_partner_quotes_id = $model->id;

            $t->lead_partner_quote_installments_id = $model->installmentDue->id ?? null;
            $t->safaris = $model->safaris;
            $t->travelers = $model->travelers;
            $t->stay_category_id = $model->stay_category_id;
            $t->billing_name = $model->name;

            $t->lead_partner_id = $model->lead_partner_id;
            $t->lead_id = $model->lead_id;
            $t->partner_id = $model->partner_id;
            $t->park_id = $model->park_id;
            $t->order_id = $data['txnid'];
            $t->reference_id = $data['udf1'];
            $t->currency = 'INR'; // Assuming INR
            $t->received_amount = $data['amount'];
            $t->payment_gateway = Transaction::PAYMENT_GATEWAY_PAYU;
            $t->name = $model->name;
            $t->email = $model->email;
            $t->phone = $model->phone;
            $t->start_date = $model->start_date;
            $t->end_date = $model->end_date;
            $t->validity_date = $model->validity_date;
            $t->permit_booking_date = $model->permit_booking_date;
            $t->partner_selling_price = $model->partner_selling_price;
            $t->plateform_partner_fees_percentage = $model->plateform_partner_fees_percentage;
            $t->plateform_partner_fees = $model->plateform_partner_fees;
            $t->partner_net_selling_price = $model->partner_net_selling_price;
            $t->plateform_customer_discount = $model->plateform_customer_discount;
            $t->net_payment_price = $model->net_payment_price;
            $t->installment = $model->installment->id ?? 0;
            $t->addional_notes = $model->addional_notes;
            $t->addtional_data = json_encode($data);
            // $t->billing_name = $model->name;
            // $t->billing_address = $model->billing_address;
            // $t->billing_city = $model->billing_city;
            // $t->billing_state = $model->billing_state;
            // $t->billing_zip = $model->billing_zip;
            // $t->billing_country = $model->billing_country;
            // $t->billing_tel = $model->phone;
            // $t->billing_email = $model->email;
            $t->param1 = $data['udf1'];
            $t->param2 = $data['udf2'];
            // $t->param3 = $model->id;
            // $t->param4 = $model->installment->id ?? null;
            // $t->param5 = $model->installment->installment ?? 0;
            $t->status = Transaction::STATUS_INITIATED;
            $t->created_at = time();
            $t->updated_at = time();
            $t->created_by = $this->userinfoId;
            $t->updated_by = $this->userinfoId;
            if (!$t->save()) {
                Yii::error('Transaction save failed: ' . json_encode($transaction->getErrors()), 'transaction');
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
