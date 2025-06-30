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
    /**
     * Renders the index view for the module
     * @return string
     */
    // public function actionIndex()
    // {
    //     $searchModel = new TransactionSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

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
        $data['payu'] = [
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

        return Yii::$app->api->sendResponse($data);

        // // Log the payment data for debugging purposes
        // Yii::info('PayU Payment Data: ' . json_encode($data), 'transaction');

        // // Build the HTML form for POST request
        // $formHtml = '<form id="payuForm" action="' . $payuBaseUrl . '/_payment" method="POST">';
        // foreach ($data as $key => $value) {
        //     $formHtml .= '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '">';
        // }
        // $formHtml .= '</form>';
        // $formHtml .= '<script>document.getElementById("payuForm").submit();</script>';


        // // Output the form to the browser
        // return $formHtml;
    }

    private function generatePayuHash($data, $salt)
    {
        // Define the order of fields for the hash string
        // $fieldsOrder = ['key', 'txnid', 'amount', 'productinfo', 'firstname', 'email', 'phone', 'surl', 'furl', 'udf1', 'udf2'];
        // $fieldsOrder = ['key', 'txnid', 'amount', 'productinfo', 'firstname', 'email', 'phone',  'udf1', 'udf2', 'udf3', 'udf4', 'udf5', 'udf6', 'udf7', 'udf8', 'udf9', 'udf10'];
        $hashPattern = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $fieldsOrder = explode('|', $hashPattern);
        // Initialize the hash string
        $hashString = '';

        // Append values from $data based on the order
        foreach ($fieldsOrder as $field) {
            $hashString .= isset($data[$field]) ? $data[$field] . '|' : '|';
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
}
