<?php

namespace webhook\controllers;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\leads\LeadPartnerQuotes;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii;

/**
 * Default controller for the `error` module
 */
class PaymentResponseController extends Controller
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
                        'actions' => ['payu-verify', 'payu-response'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'payu-verify' => ['POST'],
                    'payu-response' => ['POST', 'GET'],
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if ($action->id === 'payu-response' || $action->id === 'payu-verify') {
            // Disable CSRF validation for the payu-response action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    public function actionPayuResponse()
    {

        // Verify payment response from PayU
        $data = Yii::$app->request->post();
        $salt = Yii::$app->params['payu']['salt'];
        \Yii::info('PayU Response: ' . json_encode($data), 'payu');
        $is_verify = $this->verifyPayuPayment($data, $salt);
        // Compare the calculated hash with the received hash
        if ($is_verify) {
            Yii::info('Payment verified successfully.', 'transaction');
            $this->transactionupdate();
            // if ($data['status'] == 'success') {
            //     return $this->redirect(Yii::$app->params['frontend_url_for_payments'] . '/payment/success/' . ($data['udf1'] ?? ''));
            // } elseif ($data['status'] == 'failure') {
            //     return $this->redirect(Yii::$app->params['frontend_url_for_payments'] . '/payment/cancel/' . ($data['udf1'] ?? ''));
            // } elseif ($data['status'] == 'pending') {
            //     return $this->redirect(Yii::$app->params['frontend_url_for_payments'] . '/payment/pending/' . ($data['udf1'] ?? ''));
            // }
            // return $this->redirect(Yii::$app->params['frontend_url_for_payments'] . '/payment/error/' . ($data['udf1'] ?? ''));

            if ($data['status'] == 'success') {
                return $this->redirect(Yii::$app->params['frontend_url_for_payments'] . '/payment/success/' . ($data['udf1'] ?? ''));
            }
            return $this->redirect(Yii::$app->params['frontend_url_for_payments'] . '/payment/failed/' . ($data['udf1'] ?? ''));
        }


        return $this->redirect(Yii::$app->params['frontend_url_for_payments'] . '/payment/failed/' . ($data['udf1'] ?? '') . '?error=Payment verification failed. Please try again.');
    }

    private function transactionupdate()
    {
        $data = Yii::$app->request->post();

        $transaction = \common\models\transaction\Transaction::find()->where(['reference_id' => $data['udf1']])->one();
        $message = "Payment Failed";
        if ($transaction) {
            if (strtolower($data['status']) == 'success') {
                $transaction->status = \common\models\transaction\Transaction::STATUS_SUCCESS;
                $message = "Payment Received";
            } elseif (strtolower($data['status']) == 'failure') {
                $transaction->status = \common\models\transaction\Transaction::STATUS_FAILED;
            } elseif (strtolower($data['status']) == 'pending') {
                $transaction->status = \common\models\transaction\Transaction::STATUS_HOLD;
            }
            $transaction->payment_gateway = \common\models\transaction\Transaction::PAYMENT_GATEWAY_PAYU;
            $transaction->transaction_datetime = date('Y-m-d H:i:s');

            $transaction->save(false);
            $transaction->triggerTransactionEvent();
            $this->prepareChat($transaction->lead_partner_quotes_id, $message, $transaction->status);
            $this->updatePayuResponse($data, $transaction->id);
            Yii::info('Transaction updated successfully.', 'transaction');
        } else {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Transaction not found."]);
        }
    }

    private function updatePayuResponse($data, $transactionId)
    {
        $payuResponse = \common\models\transaction\PayuResponse::find()->where(['transaction_id' => $transactionId])->one();
        if (!$payuResponse) {
            $payuResponse = new \common\models\transaction\PayuResponse();
        }

        $payuResponse->transaction_id = $transactionId;

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


        // Save the response
        if ($payuResponse->save(false)) {
            Yii::info('PayU response saved successfully.', 'transaction');
            return true;
        } else {
            Yii::error('Failed to save PayU response: ' . json_encode($payuResponse->getErrors()), 'transaction');
            return false;
        }
    }

    private function verifyPayuPayment($params, $salt)
    {
        // Validate required parameters
        $requiredParams = ['key', 'txnid', 'amount', 'productinfo', 'firstname', 'email', 'udf1', 'udf2', 'status', 'hash'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                Yii::error("Missing required parameter: $param", 'transaction');
                return false;
            }
        }

        // Extract parameters
        $key = Yii::$app->params['payu']['merchantKey'];
        $txnid = $params['txnid'];
        $amount = $params['amount'];
        $productInfo = $params['productinfo'];
        $firstname = $params['firstname'];
        $email = $params['email'];
        $udf1 = $params['udf1'] ?? '';
        $udf2 = $params['udf2'] ?? '';
        $udf3 = $params['udf3'] ?? '';
        $udf4 = $params['udf4'] ?? '';
        $udf5 = $params['udf5'] ?? '';
        $udf6 = $params['udf6'] ?? '';
        $udf7 = $params['udf7'] ?? '';
        $udf8 = $params['udf8'] ?? '';
        $udf9 = $params['udf9'] ?? '';
        $udf10 = $params['udf10'] ?? '';

        $status = $params['status'];
        $resphash = $params['hash'];

        // Construct the key string
        $keyString = implode('|', [
            $key,
            $txnid,
            $amount,
            $productInfo,
            $firstname,
            $email,
            $udf1,
            $udf2,
            $udf3,
            $udf4,
            $udf5,
            $udf6,
            $udf7,
            $udf8,
            $udf9,
            $udf10,
        ]);

        // Reverse the key string
        $reverseKeyString = implode('|', array_reverse(explode('|', $keyString)));
        // Calculate hash without additional charges
        $CalcHashString = strtolower(hash('sha512', $salt . '|' . $status . '|' . $reverseKeyString));

        // Check for presence of additional charges
        if (isset($params['additionalCharges'])) {
            $additionalCharges = $params['additionalCharges'];
            // Calculate hash with additional charges
            $CalcHashString = strtolower(hash('sha512', $additionalCharges . '|' . $salt . '|' . $status . '|' . $reverseKeyString));
        }

        // Compare calculated hash with response hash
        if ($resphash == $CalcHashString) {
            return true;
        } else {
            Yii::error('Hash mismatch during payment verification.', 'transaction');
            return false;
        }
    }

    private function prepareChat($quotation_id, $message, $status)
    {

        // $chat_model = Chat::find()->andWhere(['lead_id' => $quotation->lead_id])->andWhere(['or', ['user_id' => [$quotation->lead->user_id, $quotation->partner->user_id]], ['recipient_user_id' => [$quotation->lead->user_id, $quotation->partner->user_id]]])->andWhere(['chat_type' => 2])->one();
        $quotation = LeadPartnerQuotes::find()->where(['id' => $quotation_id])->one();
        $chat_model = Chat::find()
            ->andWhere(['lead_id' => $quotation->lead_id])
            ->andWhere([
                'or',
                [
                    'user_id' => $quotation->partner->user_id,
                    'recipient_user_id' => $quotation->lead->user_id
                ],
                [
                    'user_id' => $quotation->lead->user_id,
                    'recipient_user_id' => $quotation->partner->user_id
                ]
            ])
            ->andWhere(['chat_type' => 2])
            ->one();

        if (!$chat_model) {
            return false;
        }

        // $message = "Payment received: ";

        // if (isset($quotation->park->title)) {
        //     $message = "Park: " . $quotation->park->title;
        //     $message .= "\n";
        //     $message .= "Safaris: " . $quotation->safaris;
        // }
        // $message .= "\n";
        // $message .= "\n";
        // $message .= "\n";
        // $message .= "Travelers: " . $quotation->travelers;
        // $message .= "\n";
        // $message .= "Stay Category: " . @\common\models\GeneralModel::staycategoryoption()[$quotation->stay_category_id];
        // $message .= "\n";
        // $message .= "Start Date: " . date('M d, Y', strtotime($quotation->start_date));
        // $message .= "\n";
        // $message .= "End Date: " . date('M d, Y', strtotime($quotation->end_date));
        // if (!empty($quotation->validity_date)) {
        //     $message .= "\n";
        //     $message .= "Validity Date: " . date('M d, Y', strtotime($quotation->validity_date));
        // }
        // if (!empty($quotation->permit_booking_date)) {
        //     $message .= "\n";
        //     $message .= "Permit Booking Date: " . date('M d, Y', strtotime($quotation->permit_booking_date));
        // }
        // $message .= "\n";
        // $message .= "Notes:";
        // $message .= "\n";
        // $message .= $quotation->addional_notes;

        // $x = \api\models\leads\LeadPartnerQuotes::find()->where(['id' => $quotation->id])->one();
        // $data = $x->preparedata;
        // $this->storeMessage($chat_model->id, $quotation->lead->user_id, $message, $data);
        if($status == 1){

            ChatMessage::updateAll(['is_quotation_active' => 0], ['chat_id' => $chat_model->id]);
        }
        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_model->id;
        $chat_message->message = $message;
        // $chat_message->is_quotation_message = false;
        // $chat_message->quotation_id = $quotation->id;
        // $chat_message->is_quotation_active = false;
        // $chat_message->data = json_encode($data);
        $chat_message->status = 1;
        $chat_message->sender_id = $quotation->partner->user_id;

        if ($chat_message->save(false)) {

            $chat = Chat::find()->where(['id' => $chat_model->id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxlength($message);
            $chat->last_message_at = time();
            $chat->sender_id = $quotation->partner->user_id;
            // $chat->quote_id = $quotation->id;
            $chat->is_lead_chat_open_for_user = 1;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            return $chat->save(false);
        }

        return false;
    }
}
