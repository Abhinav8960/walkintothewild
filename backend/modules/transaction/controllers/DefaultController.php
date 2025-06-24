<?php

namespace backend\modules\transaction\controllers;

use common\models\leads\LeadPartnerQuotes;
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

    public function actionInitiate($lead_partner_quotes_id)
    {
        $model = LeadPartnerQuotes::find()->andWhere(['id' => $lead_partner_quotes_id])->one();
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Lead Partner Quote not found.');
            return $this->redirect(['index']);
        }
        if ($model->status != LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED) {
            Yii::$app->session->setFlash('error', 'Lead Partner Quote is not approved by admin.');
            return $this->redirect(['index']);
        }

        $merchantId = Yii::$app->params['ccavenue']['merchantId'];
       echo $accessCode = Yii::$app->params['ccavenue']['accessCode'];
        $workingKey = Yii::$app->params['ccavenue']['workingKey'];
        $redirectUrl = Yii::$app->params['ccavenue']['redirectUrl'];
        $api_url = Yii::$app->params['ccavenue']['api_url'];

        $orderId = 'O-' . date('ym') . '-' . time() . '-' . $model->id . '-' . uniqid();
        $amount = $model->partner_selling_price;
        $currency = 'INR';
        die();
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
