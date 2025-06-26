<?php

namespace backend\modules\transaction\controllers;

use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use common\models\transaction\Transaction;
use common\models\transaction\TransactionSearch;
use yii\web\Controller;
use yii;

/**
 * Default controller for the `error` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInitiate($lead_partner_quotes_id, $payment_gateway)
    {

        if ($payment_gateway == LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_ICICI) {
            return $this->icici($lead_partner_quotes_id);
        } elseif ($payment_gateway == LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_PAYU) {
            return $this->payu($lead_partner_quotes_id);
        } elseif ($payment_gateway == LeadPartnerQuoteInstallments::PAYMENT_GATEWAY_HDFC) {
            return $this->redirect(['hdfc', 'lead_partner_quotes_id' => $lead_partner_quotes_id]);
        } else {
            Yii::$app->session->setFlash('error', 'Invalid payment gateway selected.');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($lead_partner_quotes_id)
    {
        $model = LeadPartnerQuotes::find()->andWhere(['id' => $lead_partner_quotes_id])->one();
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Lead Partner Quote not found.');
            return  $this->redirect(Yii::$app->request->referrer);
        }
        if ($model->status != LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED) {
            Yii::$app->session->setFlash('error', 'Lead Partner Quote is not approved by admin.');
            return $this->redirect(Yii::$app->request->referrer);
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
            Yii::$app->session->setFlash('error', 'Payment gateway configuration error: Merchant Key is missing.');
            return $this->redirect(['index']);
        }

        // Prepare transaction details
        $orderId = Transaction::orderId($model->id);
        $reference_id = Transaction::orderId($model->id);
        $amount = $model->partner_selling_price;
        $currency = 'INR';

        // Prepare data for PayU
        $data = [
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
        $data['hash'] = $this->generatePayuHash($data, $salt);

        // Build the PayU payment URL
        $queryString = http_build_query($data);
        $paymentUrl = $payuBaseUrl . '/_payment?' . $queryString;

        // Log the payment URL for debugging purposes
        Yii::info('PayU Payment URL: ' . $paymentUrl, 'transaction');

        // Redirect to the PayU payment gateway
        return $this->redirect($paymentUrl);
    }

    private function generatePayuHash($data, $salt)
    {
        // Define the order of fields for the hash string

        $fieldsOrder = ['key', 'txnid', 'amount', 'productinfo', 'firstname', 'email', 'phone', 'surl', 'furl', 'udf1', 'udf2'];

        // Initialize the hash string
        $hashString = '';

        // Append values from $data based on the order
        foreach ($fieldsOrder as $field) {
            $hashString .= isset($data[$field]) ? $data[$field] . '|' : '|';
        }

        // Append empty fields and the salt
        $hashString .= str_repeat('|', 10) . $salt;

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

        // print_r($data);
        // die();

        $dataString = http_build_query($data);

        try {
            $encryptedData = $this->encryptCCAvenueData($dataString, $workingKey);
            if ($encryptedData === false) {
                throw new \yii\base\InvalidArgumentException('Encryption failed.');
            }
            $paymentUrl = $api_url . '?encRequest=' . urlencode($encryptedData) . '&access_code=' . $accessCode;

            Yii::info('Encrypted Data: ' . $encryptedData, 'transaction');
            Yii::info('Payment URL: ' . $paymentUrl, 'transaction');

            return $this->redirect($paymentUrl);
        } catch (\yii\base\InvalidArgumentException $e) {
            Yii::$app->session->setFlash('error', 'Encryption failed: ' . $e->getMessage());
            return $this->redirect(['index']);
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
