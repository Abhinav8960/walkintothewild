<?php

namespace api\modules\transaction\controllers;

use api\controllers\RestController;
use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use yii\filters\AccessControl;
use yii;

/**
 * Default controller for the `error` module
 */
class PaymentResponseController extends RestController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors += [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['payu-verify'],
                'rules' => [
                    [
                        'actions' => ['payu-verify', 'payu-response'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'payu-verify' => ['POST'],
                    'payu-response' => ['POST'],
                ],
            ],
        ];
    }

    public function actionPayuVerify()
    {
        // Verify payment response from PayU
        $data = Yii::$app->request->post();
        // $sanitizedData = $this->sanitizeData($data);
        // $hash = $data['hash'] ?? null;
        // $key = $data['key'] ?? null;
        // $txnid = $data['txnid'] ?? null;
        // $amount = $data['amount'] ?? null;
        // $productinfo = urldecode($data['productinfo'] ?? 'Lead Partner Quote Payment');
        // $firstname = urldecode($data['firstname'] ?? null);
        // $email = urldecode($data['email'] ?? null);
        // $udf1 = $data['udf1'] ?? null;
        // $udf2 = $data['udf2'] ?? null;
        $salt = Yii::$app->params['payu']['salt']; // Replace with your actual salt

        // Calculate the hash using the correct formula
        // $calculatedHash = strtolower(hash('sha512', $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|' . $udf1 . '|' . $udf2 . '|||||||||||' . $salt));
        $is_verify = $this->verifyPayuPayment($data, $salt);

        // Compare the calculated hash with the received hash
        if ($is_verify) {
            Yii::info('Payment verified successfully.', 'transaction');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Payment verified successfully."]);
        } else {
            Yii::error('Hash mismatch. Payment verification failed.', 'transaction');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Payment verification failed due to hash mismatch."]);
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


    public function actionPayuResponse()
    {
        // Verify payment response from PayU
        $data = Yii::$app->request->post();
        $salt = Yii::$app->params['payu']['salt'];
        $is_verify = $this->verifyPayuPayment($data, $salt);

        // Compare the calculated hash with the received hash
        if ($is_verify) {
            Yii::info('Payment verified successfully.', 'transaction');
            $this->transactionupdate();
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Payment verified successfully."]);
        } else {
            Yii::error('Hash mismatch. Payment verification failed.', 'transaction');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Payment verification failed due to hash mismatch."]);
        }
    }

    private function transactionupdate()
    {
        $data = Yii::$app->request->post();
        $transaction = \common\models\transaction\Transaction::find()->where(['reference_id' => $data['udf1']])->one();
        if ($transaction) {
            if (strtolower($data['status']) == 'success') {
                $transaction->status = \common\models\transaction\Transaction::STATUS_SUCCESS;
            } elseif (strtolower($data['status']) == 'failure') {
                $transaction->status = \common\models\transaction\Transaction::STATUS_FAILED;
            } elseif (strtolower($data['status']) == 'pending') {
                $transaction->status = \common\models\transaction\Transaction::STATUS_HOLD;
            }
            $transaction->transaction_datetime = date('Y-m-d H:i:s');
            $transaction->payment_gateway = \common\models\transaction\Transaction::PAYMENT_GATEWAY_PAYU;
            $transaction->save(false);
            Yii::info('Transaction updated successfully.', 'transaction');
        } else {
            Yii::error('Transaction not found for txnid: ' . $data['txnid'], 'transaction');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Transaction not found."]);
        }
    }
}
