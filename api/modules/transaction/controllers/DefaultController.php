<?php

namespace api\modules\transaction\controllers;

use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use common\models\transaction\Transaction;
use common\models\transaction\TransactionSearch;
use api\controllers\RestController;
use common\models\GeneralModel;
use yii;

/**
 * Default controller for the `error` module
 */
class DefaultController extends RestController
{


    public function actionInitiate($lead_partner_quotes_id, $payment_gateway)
    {

        $lead_partner_quotes_id = GeneralModel::decrypt($lead_partner_quotes_id);

        $lead_installments = LeadPartnerQuoteInstallments::find()->andWhere(['lead_partner_quote_id' => $lead_partner_quotes_id, 'is_payment_expired' => 0])->one();

        if (!$lead_installments) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Payment link expired or not valid."]);
        }
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
        return LeadPartnerQuotes::find()->andWhere(['id' => $lead_partner_quotes_id])->one();
    }

    private function payu($lead_partner_quotes_id)
    {
        $model = $this->findModel($lead_partner_quotes_id);

        if (!$model) {
            // Yii::$app->session->setFlash('error', 'Lead Partner Quote not found.');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Lead Partner Quote not found."]);
        }
        if ($model->is_payment_received == 1) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Payment already received for this"]);
        }
        // if ($model->status != LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED) {
        //     Yii::$app->session->setFlash('error', 'Lead Partner Quote is not approved by admin.');
        //     return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Lead Partner Quote is not approved by admin."]);
        // }

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
            // 'email' => 'annu@triline.co.in',
            'phone' => $model->phone,
            'surl' => Yii::$app->params['payu']['successUrl'],
            'furl' => Yii::$app->params['payu']['failureUrl'],
            'udf1' => $reference_id,
            'udf2' => $orderId,
        ];

        // Generate hash for PayU
        $data['payu']['hash'] = $this->generatePayuHash($data, $salt);
        $data['payu_transaction_url'] = Yii::$app->params['payu']['host_url'] . '/_payment';
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

        if (!$model) {
            // Yii::$app->session->setFlash('error', 'Lead Partner Quote not found.');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Lead Partner Quote not found."]);
        }
        if ($model->is_payment_received == 1) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Payment already received for this"]);
        }
        if ($model->status != LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED) {
            Yii::$app->session->setFlash('error', 'Lead Partner Quote is not approved by admin.');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Lead Partner Quote is not approved by admin."]);
        }

        $merchantId = Yii::$app->params['ccavenue']['merchantId'];
        $accessCode = Yii::$app->params['ccavenue']['accessCode'];
        $workingKey = Yii::$app->params['ccavenue']['workingKey'];
        $redirectUrl = Yii::$app->params['ccavenue']['redirectUrl'];
        $api_url = Yii::$app->params['ccavenue']['api_url'];

        $orderId = Transaction::orderId($model->id);
        $referenceId = Transaction::referenceId($model->id);
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
            'merchant_param1' => $referenceId,
            'merchant_param2' => $orderId,
            'merchant_param3' => $model->lead->id,
            'merchant_param4' => $model->partner->id,
            'tid' => time() . '-' . $model->id,
        ];

        // echo "<pre>";
        // print_r($data);
        // die();

        // $dataString = http_build_query($data);

        try {
            $encryptedData = $this->encryptCCAvenueData($data, $workingKey);

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
            $this->storeIcic($lead_partner_quotes_id, $data);
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
        $merchant_data = '';

        foreach ($data as $key => $value) {
            $merchant_data .= $key . '=' . $value . '&';
        }

        $key = $this->hextobin(md5($workingKey));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($merchant_data, 'AES-128-CBC', $workingKey, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;


        // if (empty($data)) {
        //     throw new \yii\base\InvalidArgumentException('Data to encrypt cannot be empty.');
        // }

        // if (empty($workingKey) || strlen($workingKey) < 16) {
        //     throw new \yii\base\InvalidArgumentException('Working key must be at least 16 characters long.');
        // }

        // // Ensure the IV is 16 bytes long
        // $iv = substr($workingKey, 0, 16);

        // $encryptedData = openssl_encrypt($data, 'AES-128-CBC', $workingKey, 0, $iv);

        // if ($encryptedData === false) {
        //     throw new \yii\base\InvalidArgumentException('Failed to encrypt data.');
        // }

        // return $encryptedData;
    }

    private function decryptCCAvenueData($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    private function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }

    private function storePayu($lead_partner_quotes_id, $data = [])
    {

        $utm_source = Yii::$app->request->get('utm_source', null);

        // db transaction begin
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($lead_partner_quotes_id);
            // Store the transaction in the database
            $t = new Transaction();
            $t->utm_source = $utm_source;
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
            $headers = Yii::$app->getRequest()->getHeaders();
            $device = strtolower($headers->get('x-device')) ?? null;
            $platform = strtolower($headers->get('x-platform')) ?? null;
            $platform_version = strtolower($headers->get('x-platform-version')) ?? null;
            $application_version = strtolower($headers->get('x-application-version')) ?? null;
            $t->device = $device;
            $t->platform = $platform;
            $t->platform_version = $platform_version;
            $t->browser = null;
            $t->browser_version = null;
            $t->application_version =  $application_version;



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
            \common\models\transaction\TransactionEvents::store(\common\models\transaction\TransactionEvents::EVENT_PAYMENT_INITIATED, $model->lead_id, $lead_partner_quotes_id, $t->id);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    private function storeIcic($lead_partner_quotes_id, $data = [])
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
            $t->order_id = $data['order_id'];
            $t->reference_id = $data['udf1'];
            $t->currency =  $data['currency'] ?? 'INR'; // Assuming INR
            $t->received_amount = $data['amount'];
            $t->payment_gateway = Transaction::PAYMENT_GATEWAY_ICICI;
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
            $t->billing_email = $data['billing_email'] ?? $model->email;
            $t->billing_tel = $data['billing_tel'] ?? $model->phone;
            $t->param1 = $data['merchant_param1'];
            $t->param2 = $data['merchant_param2'];
            $t->param3 = $data['merchant_param3'];
            $t->param4 = $data['merchant_param4'];
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


    public function actionTransactionInfo($reference)
    {
        $model = Transaction::find()->andWhere(['reference_id' => $reference])->one();
        if (!$model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Transaction not found."]);
        }

        if (isset($model->lead->package_id)) {
            $title = "Package - " . $model->lead->package->package_name;
        } else {
            $title = "Customer safari enquiry - " . $model->park_label;
        }

        $data['transaction'] = [
            'id' => $model->id,
            'reference_id' => $model->reference_id,
            // 'order_id' => $model->order_id,
            'partner' => $model->partner->business_name ?? null,
            "title" => $title,
            "park_name" => $model->park_label ?? '',
            'status' => $model->status,
            'amount' => $model->received_amount,
            'currency' => $model->currency,
            'payment_gateway' => $model->payment_gateway == Transaction::PAYMENT_GATEWAY_PAYU ? 'PayU' : ($model->payment_gateway == Transaction::PAYMENT_GATEWAY_ICICI ? 'ICICI' : 'HDFC'),
            'safaris' => $model->safaris,
            'travelers' => $model->travelers,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'start_date' => $model->start_date,
            'end_date' => $model->end_date,
            'status' => $model->status,
            'status_label' => $model->status == Transaction::STATUS_INITIATED ? 'Initiated' : ($model->status == Transaction::STATUS_SUCCESS ? 'Success' : ($model->status == Transaction::STATUS_FAILED ? 'Failed' : ($model->status == Transaction::STATUS_HOLD ? 'Hold' : ($model->status == Transaction::STATUS_REFUNDED ? 'Refunded' : 'Conflict')))),
            // 'lead_partner_quotes_id' => $model->lead_partner_quotes_id,
            // 'lead_partner_quote_installments_id' => $model->lead_partner_quote_installments_id,
            // 'lead_partner_id' => $model->lead_partner_id,
            // 'lead_id' => $model->lead_id,
            // 'partner_id' => $model->partner_id,
            // 'park_id' => $model->park_id,
            // 'billing_name' => $model->billing_name,
            // 'billing_address' => $model->billing_address,
            // 'billing_city' => $model->billing_city,
            // 'billing_state' => $model->billing_state,
            // 'billing_zip' => $model->billing_zip,
            // 'billing_country' => $model->billing_country,
            // 'billing_tel' => $model->billing_tel,
            // 'billing_email' => $model->billing_email,
            // 'param1' => $model->param1,
            // 'param2' => $model->param2,
            // 'param3' => $model->param3,
            // 'param4' => $model->param4,
            // 'param5' => $model->param5,

            'created_at' => date('Y-m-d H:i:s', $model->created_at),
            // 'updated_at' => date('Y-m-d H:i:s', $model->updated_at),
            // Add other fields as necessary
        ];
        \common\models\transaction\TransactionEvents::store(\common\models\transaction\TransactionEvents::EVENT_PAYMENT_STATUS_PAGE_OPEN, $model->lead_id, $model->lead_partner_quotes_id, $model->id);


        return Yii::$app->api->sendResponse($data);
    }

    public function actionQuotationInfo($hash)
    {
        $model = LeadPartnerQuoteInstallments::find()->andWhere(['payment_hash' => $hash, 'is_payment_expired' => 0])->one();
        if (empty($model)) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Payment link expired or not valid."]);
        }
        $quotation = \api\models\leads\LeadPartnerQuotes::find()->andWhere(['id' => $model->lead_partner_quote_id])->one();

        if (empty($quotation)) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Quotation not found."]);
        }


        if (isset($quotation->lead->package_id)) {
            $title = "Package - " . $quotation->lead->package->package_name;
        } else {
            $title = "Customer safari enquiry - " . $quotation->park_label;
        }
        $data['quotation'] = [
            "quotation_id" => $quotation->id,
            "lead_id" => $quotation->lead_id,
            "title" => $title,
            "park_name" => $quotation->park_label ?? '',
            "safaris" => $quotation->safaris,
            "travelers" => $quotation->travelers,
            "stay_category_label" => $quotation->staycatgory->title ?? '',
            "name" => $quotation->name,
            "email" => $quotation->email,
            "phone" => $quotation->phone,
            'profile_display_image' => $quotation->lead->user->profile_display_image ?? null,
            'partner' => $quotation->partner->business_name ?? null,
            "start_date" => date('M d, Y', strtotime($quotation->start_date)),
            "end_date" => date('M d, Y', strtotime($quotation->end_date)),
            // "validity_date" => date('M d, Y', strtotime($quotation->validity_date)),
            // "permit_booking_date" => date('M d, Y', strtotime($quotation->permit_booking_date)),
            "amount" => $quotation->net_payment_price,
            "quantity" => 1,
            "additional_notes" => $quotation->addional_notes,
            "is_payment_received" => (bool) $quotation->is_payment_received,
            "if_payment_received_then_message" => $quotation->is_payment_received == 1 ? "Payment has already been received." : null,
            // "installments" => array_map(function ($installment) {
            //     return [
            //         "id" => $installment->id,
            //         "amount" => $installment->amount,
            //         "due_date" => date('M d, Y', strtotime($installment->due_date)),
            //         "is_paid" => $installment->is_paid,
            //         "payment_link" => $installment->payment_link,
            //     ];
            // }, $quotation->installments ?? []),
        ];
        \common\models\transaction\TransactionEvents::store(\common\models\transaction\TransactionEvents::EVENT_CART_OPEN, $quotation->lead_id, $quotation->id, $transaction_id = null);

        return Yii::$app->api->sendResponse($data);
    }
}
