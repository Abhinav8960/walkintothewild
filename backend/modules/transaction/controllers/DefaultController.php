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

        // Prepare CCAvenue payment request
        $merchantId = Yii::$app->params['ccavenue']['merchantId'];
        $accessCode = Yii::$app->params['ccavenue']['accessCode'];
        $workingKey = Yii::$app->params['ccavenue']['workingKey']; // Encryption key
        $redirectUrl = Yii::$app->params['ccavenue']['redirectUrl'];

        $orderId = $model->id; // Use LeadPartnerQuotes ID as order ID
        $amount = $model->partner_selling_price; // Example: use selling price as amount
        $currency = 'INR'; // Example: Indian Rupee

        // Encrypt payment request
        $paymentData = [
            'merchant_id' => $merchantId,
            'order_id' => $orderId,
            'amount' => $amount,
            'currency' => $currency,
            'redirect_url' => $redirectUrl,
            'cancel_url' => $redirectUrl,
            'language' => 'EN',
        ];
        $encryptedData = $this->encryptCCAvenueData(http_build_query($paymentData), $workingKey);

        // Send request to CCAvenue
        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://secure.ccavenue.com/transaction/initTrans')
            ->setData(['encRequest' => $encryptedData, 'access_code' => $accessCode])
            ->send();

        if ($response->isOk) {
            $responseData = $response->getData();
            // Handle the response (e.g., log transaction details, update database)
            Yii::$app->session->setFlash('success', 'Transaction initiated successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to initiate transaction.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Encrypt data for CCAvenue
     * @param string $data
     * @param string $workingKey
     * @return string
     */
    private function encryptCCAvenueData($data, $workingKey)
    {
        return openssl_encrypt($data, 'AES-128-CBC', $workingKey, 0, $workingKey);
    }
}
