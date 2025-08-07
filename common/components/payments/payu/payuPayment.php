<?php

namespace common\components\payments\payu;

use Yii;
use common\models\leads\sharesafari\ShareSafariLeadInstallment;
use common\models\transaction\Transaction;

class payuPayment
{
    const PAYU_TEST_URL = 'https://test.payu.in/_payment';
    const PAYU_PROD_URL = 'https://secure.payu.in/_payment';

    private $merchantKey;
    private $merchantSalt;
    private $host_url;
    private $source = 'L';
    private $source_id = 1;

    public function __construct()
    {
        $this->merchantKey = Yii::$app->params['payu']['merchantKey'];
        $this->merchantSalt = Yii::$app->params['payu']['salt'];
        $this->host_url = Yii::$app->params['payu']['host_url'];
    }

    public function initiateShareSafariLeadPayment($share_safari_lead, $productinfo, $sourceId = 1)
    {
        if (!$share_safari_lead instanceof ShareSafariLeadInstallment) {
            return [
                'status' => 0,
                'message' => 'Invalid payment request'
            ];
        }
        $this->source_id = $sourceId;
        if ($this->source_id == Transaction::SOURCE_LEAD) {
            $this->source = 'L';
        } elseif ($this->source_id == Transaction::SOURCE_SHARE_SAFARI) {
            $this->source = 'FD';
        }
        // try {
        $txnid = Transaction::transactionId($share_safari_lead->shareSafariLead->id, $this->source);
        $udf1 = $reference_id = Transaction::referenceId($share_safari_lead->shareSafariLead->id, $this->source);
        $udf2 = $orderId = Transaction::orderId($share_safari_lead->shareSafariLead->id, $this->source);
       
        $amount = $share_safari_lead->amount;
        $productinfo = "Safari Booking Payment";
        $firstname = $share_safari_lead->shareSafariLead->name;
        $email = $share_safari_lead->shareSafariLead->email;
        $phone = $share_safari_lead->shareSafariLead->phone;
        // Additional params for transaction tracking
        return $this->initiate($share_safari_lead, $txnid, $amount, $productinfo, $firstname, $email, $phone, $udf1, $udf2);
        // } catch (\Exception $e) {
        //     Yii::error('PayU payment initiation failed: ' . $e->getMessage());
        //     return [
        //         'status' => 0,
        //         'message' => 'Payment initiation failed'
        //     ];
        // }
    }

    private function initiate($share_safari_lead, $txnid, $amount, $productinfo, $firstname, $email, $phone, $udf1, $udf2, $lead_partner_quotes_id = null, $lead_partner_quote_installments_id = null, $lead_partner_id = null, $addional_notes = null)
    {

        $payuData = $data['payu'] = [
            'key' => $this->merchantKey,
            'txnid' => $txnid,
            'amount' => $amount,
            'productinfo' => $productinfo,
            'firstname' => $firstname,
            'email' => $email,
            'phone' => $phone,
            'surl' => Yii::$app->params['payu']['successUrl'],
            'furl' => Yii::$app->params['payu']['failureUrl'],
            'udf1' => $udf1,
            'udf2' => $udf2
        ];

        // Generate hash
        // Generate hash for PayU
        $data['payu']['hash'] = $this->generatePayuHash($data);
        $data['payu_transaction_url'] = Yii::$app->params['payu']['host_url'] . '/_payment';

        // Create transaction record
        // $t = new Transaction();
        // $t->payment_gateway = Transaction::PAYMENT_GATEWAY_PAYU;
        // $t->received_amount = $amount;
        // $t->source = $this->source;
        // $t->order_id = $txnid;
        // $t->status = Transaction::STATUS_INITIATED;
        // $t->user_id = $share_safari_lead->shareSafariLead->user_id;
        // // $t->source = Transaction::SOURCE_SHARE_SAFARI;
        // $t->order_id = $udf1;
        // $t->reference_id = $udf2;


        $utm_source = Yii::$app->request->get('utm_source', null);

        // db transaction begin
        $transaction = Yii::$app->db->beginTransaction();
        try {

            // Store the transaction in the database
            $t = new Transaction();
            $t->source = $this->source_id;

            $t->utm_source = $utm_source;
            $t->user_id = $share_safari_lead->shareSafariLead->user_id;
            $t->lead_partner_quotes_id = $lead_partner_quotes_id;

            $t->lead_partner_quote_installments_id = $lead_partner_quote_installments_id;
            $t->safaris = $share_safari_lead->shareSafari->no_of_safari ?? 1;
            $t->travelers = $share_safari_lead->shareSafariLead->quantity;
            $t->stay_category_id = $share_safari_lead->shareSafari->stay_category_id;
            $t->billing_name = $share_safari_lead->shareSafariLead->name;

            $t->lead_partner_id = $lead_partner_id;
            $t->lead_id = $share_safari_lead->shareSafariLead->id;
            $t->partner_id = $share_safari_lead->shareSafari->partner->id;
            $t->park_id = $share_safari_lead->shareSafari->park_id;
            $t->reference_id = $payuData['udf1'];
            $t->order_id = $payuData['udf2'];
            $t->currency = 'INR'; // Assuming INR
            $t->received_amount = $payuData['amount'];
            $t->payment_gateway = Transaction::PAYMENT_GATEWAY_PAYU;
            $t->name = $share_safari_lead->shareSafariLead->name;
            $t->email = $share_safari_lead->shareSafariLead->email;
            $t->phone = $share_safari_lead->shareSafariLead->phone;
            $t->start_date = $share_safari_lead->shareSafariLead->start_date;
            $t->end_date = $share_safari_lead->shareSafariLead->end_date;
            // $t->validity_date = date('Y-m-d H:i:s');
            // $t->permit_booking_date = date('Y-m-d H:i:s');
            $t->validity_date = $share_safari_lead->shareSafari->cut_off_date != null ? $share_safari_lead->shareSafari->cut_off_date :  date('Y-m-d H:i:s', strtotime('+1 day'));
            $t->permit_booking_date = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $t->partner_selling_price = $payuData['amount'];
            $t->plateform_partner_fees_percentage = 0;
            $t->plateform_partner_fees = 0;
            $t->partner_net_selling_price = $payuData['amount'];
            $t->plateform_customer_discount = 0;
            $t->net_payment_price = $payuData['amount'];
            $t->installment = $share_safari_lead->installment ?? 1;
            $t->addional_notes = $addional_notes;
            $t->addtional_data = json_encode($data);
            // $t->billing_name = $model->name;
            // $t->billing_address = $model->billing_address;
            // $t->billing_city = $model->billing_city;
            // $t->billing_state = $model->billing_state;
            // $t->billing_zip = $model->billing_zip;
            // $t->billing_country = $model->billing_country;
            // $t->billing_tel = $model->phone;
            // $t->billing_email = $model->email;
            $t->param1 = $payuData['udf1'];
            $t->param2 = $payuData['udf2'];
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
            $t->created_by = $share_safari_lead->shareSafariLead->user_id;
            $t->updated_by = $share_safari_lead->shareSafariLead->user_id;
            if (!$t->save()) {
                Yii::error('Transaction save failed: ' . json_encode($t->getErrors()), 'transaction');
                $transaction->rollBack();
                return false;
            }
            \common\models\transaction\TransactionEvents::store(\common\models\transaction\TransactionEvents::EVENT_PAYMENT_INITIATED, $share_safari_lead->shareSafariLead->id, null, $t->id);
            $data['status'] = 1;
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            $data['status'] = 0;
            $data['message'] = "Payment initiation failed: " . $e->getMessage();
        }
        return $data;






        // return [
        //     'status' => 1,
        //     'data' => [
        //         'payment_url' => $this->isTestMode ? self::PAYU_TEST_URL : self::PAYU_PROD_URL,
        //         'payment_data' => $payuData,
        //         'method' => 'POST'
        //     ]
        // ];
    }

    private function generatePayuHash($data)
    {

        $salt = $this->merchantSalt;
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

    public function verifyPayment($postData)
    {
        try {
            $txnid = $postData['txnid'] ?? null;
            $status = $postData['status'] ?? null;
            $amount = $postData['amount'] ?? null;
            $hash = $postData['hash'] ?? null;

            // Verify hash
            $hashString = $this->merchantSalt . '|' . $status . '|||||||' .
                $postData['udf2'] . '|' . $postData['udf1'] . '|' .
                $postData['email'] . '|' . $postData['firstname'] . '|' .
                $postData['productinfo'] . '|' . $amount . '|' . $txnid . '|' .
                $this->merchantKey;

            $calculatedHash = strtolower(hash('sha512', $hashString));

            if ($hash !== $calculatedHash) {
                throw new \Exception('Hash verification failed');
            }

            // Update transaction status
            $transaction = Transaction::findOne(['transaction_id' => $txnid]);
            if ($transaction) {
                $transaction->status = ($status === 'success') ?
                    Transaction::STATUS_SUCCESS : Transaction::STATUS_FAILED;
                $transaction->response_data = json_encode($postData);
                $transaction->save();
            }

            // Update installment status
            $installment = ShareSafariLeadInstallment::findOne($postData['udf1']);
            if ($installment && $status === 'success') {
                $installment->status = ShareSafariLeadInstallment::STATUS_PAID;
                $installment->transaction_datetime = date('Y-m-d H:i:s');
                $installment->payment_gateway = Transaction::PAYMENT_GATEWAY_PAYU;
                $installment->save();
            }

            return [
                'status' => ($status === 'success') ? 1 : 0,
                'message' => $postData['error_Message'] ?? $status,
                'transaction_id' => $txnid
            ];
        } catch (\Exception $e) {
            Yii::error('PayU payment verification failed: ' . $e->getMessage());
            return [
                'status' => 0,
                'message' => 'Payment verification failed'
            ];
        }
    }
}
