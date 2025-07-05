<?php

namespace webhook\controllers;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\leads\LeadPartnerQuotes;
use common\models\transaction\Transaction;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii;

/**
 * Default controller for the `error` module
 */
class PayuController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['success', 'failed', 'refund', 'dispute'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'success' => ['POST', 'GET'],
                    'failed' => ['POST', 'GET'],
                    'refund' => ['POST', 'GET'],
                    'dispute' => ['POST', 'GET'],
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if (in_array($action->id, ['success', 'failed', 'refund', 'dispute'])) {
            // Disable CSRF validation for the payu-response action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionSuccess()
    {
        $data = Yii::$app->request->post();
        $this->storeResponse($data);
        \Yii::info('PayU Response Sucess: ' . json_encode($data), 'payu-webhook');
    }

    public function actionFailed()
    {
        $data = Yii::$app->request->post();
        $this->storeResponse($data);

        \Yii::info('PayU Response Failed: ' . json_encode($data), 'payu-webhook');
    }

    public function actionRefund()
    {
        $data = Yii::$app->request->post();
        $this->storeResponse($data);

        \Yii::info('PayU Response Refund: ' . json_encode($data), 'payu-webhook');
    }

    public function actionDispute()
    {
        $data = Yii::$app->request->post();
        $this->storeResponse($data);

        \Yii::info('PayU Response Dispute: ' . json_encode($data), 'payu-webhook');
    }

    private function storeResponse($data)
    {
        $payuResponse = new \common\models\transaction\PayuWebhookResponse();

        $payuResponse->mihpayid = $data['mihpayid'] ?? null;
        $payuResponse->mode = $data['mode'] ?? null;
        $payuResponse->status = $data['status'] ?? null;
        $payuResponse->unmappedstatus = $data['unmappedstatus'] ?? null;
        $payuResponse->key = $data['key'] ?? null;
        $payuResponse->txnid = $data['txnid'] ?? null;
        $payuResponse->amount = $data['amount'] ?? null;
        $payuResponse->card_category = $data['cardCategory'] ?? null;
        $payuResponse->discount = $data['discount'] ?? null;
        $payuResponse->net_amount_debit = $data['net_amount_debit'] ?? null;
        $payuResponse->addedon = $data['addedon'] ?? null;
        $payuResponse->productinfo = $data['productinfo'] ?? null;
        $payuResponse->firstname = $data['firstname'] ?? null;
        $payuResponse->lastname = $data['lastname'] ?? null;
        $payuResponse->address1 = $data['address1'] ?? null;
        $payuResponse->address2 = $data['address2'] ?? null;
        $payuResponse->city = $data['city'] ?? null;
        $payuResponse->state = $data['state'] ?? null;
        $payuResponse->country = $data['country'] ?? null;
        $payuResponse->zipcode = $data['zipcode'] ?? null;
        $payuResponse->email = $data['email'] ?? null;
        $payuResponse->phone = $data['phone'] ?? null;
        $payuResponse->udf1 = $data['udf1'] ?? null;
        $payuResponse->udf2 = $data['udf2'] ?? null;
        $payuResponse->udf3 = $data['udf3'] ?? null;
        $payuResponse->udf4 = $data['udf4'] ?? null;
        $payuResponse->udf5 = $data['udf5'] ?? null;
        $payuResponse->udf6 = $data['udf6'] ?? null;
        $payuResponse->udf7 = $data['udf7'] ?? null;
        $payuResponse->udf8 = $data['udf8'] ?? null;
        $payuResponse->udf9 = $data['udf9'] ?? null;
        $payuResponse->udf10 = $data['udf10'] ?? null;
        $payuResponse->hash = $data['hash'] ?? null;
        $payuResponse->field1 = $data['field1'] ?? null;
        $payuResponse->field2 = $data['field2'] ?? null;
        $payuResponse->field3 = $data['field3'] ?? null;
        $payuResponse->field4 = $data['field4'] ?? null;
        $payuResponse->field5 = $data['field5'] ?? null;
        $payuResponse->field6 = $data['field6'] ?? null;
        $payuResponse->field7 = $data['field7'] ?? null;
        $payuResponse->field8 = $data['field8'] ?? null;
        $payuResponse->field9 = $data['field9'] ?? null;
        $payuResponse->payment_source = $data['payment_source'] ?? null;
        $payuResponse->pa_name = $data['pa_name'] ?? null;
        $payuResponse->pg_type = $data['PG_TYPE'] ?? null;
        $payuResponse->bank_ref_num = $data['bank_ref_num'] ?? null;
        $payuResponse->bankcode = $data['bankcode'] ?? null;
        $payuResponse->error = $data['error'] ?? null;
        $payuResponse->error_Message = $data['error_Message'] ?? null;
        $payuResponse->cardnum = $data['cardnum'] ?? null;
        $payuResponse->response = json_encode($data) ?? null;

        return $payuResponse->save(false);
    }
}
