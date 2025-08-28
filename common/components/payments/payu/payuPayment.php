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

        try {
            $txnid = Transaction::transactionId($share_safari_lead->shareSafariLead->id, $this->source);
            $udf1 = $reference_id = Transaction::referenceId($share_safari_lead->shareSafariLead->id, $this->source);
            $udf2 = $orderId = Transaction::orderId($share_safari_lead->shareSafariLead->id, $this->source);

            $amount = $share_safari_lead->amount;
            $productinfo = "Safari Booking Payment";
            $firstname = $share_safari_lead->shareSafariLead->name;
            $email = $share_safari_lead->shareSafariLead->email;
            $phone = $share_safari_lead->shareSafariLead->phone;

            return $this->initiate($share_safari_lead, $txnid, $amount, $productinfo, $firstname, $email, $phone, $udf1, $udf2);
        } catch (\Exception $e) {
            Yii::error('PayU payment initiation failed: ' . $e->getMessage());
            return [
                'status' => 0,
                'message' => 'Payment initiation failed'
            ];
        }
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
            'udf2' => $udf2,
            'udf3' => '',
            'udf4' => '',
            'udf5' => '',
            'udf6' => '',
            'udf7' => '',
            'udf8' => '',
            'udf9' => '',
            'udf10' => ''
        ];

        // Generate payment hash
        $data['payu']['hash'] = $this->generatePayuHash($data);

        // Generate mobile SDK specific hashes
        $data['payu']['quickPayEvent'] = $this->generateMobileHash($data, 'quickPayEvent');
        $data['payu']['getSdkConfiguration'] = $this->generateMobileHash($data, 'getSdkConfiguration');
        $data['payu']['getCheckoutDetails'] = $this->generateMobileHash($data, 'getCheckoutDetails');
        $data['payu']['getAllOfferDetails'] = $this->generateMobileHash($data, 'getAllOfferDetails');

        $data['payu_transaction_url'] = Yii::$app->params['payu']['host_url'] . '/_payment';

        $utm_source = Yii::$app->request->get('utm_source', null);

        // Database transaction begin
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Store the transaction in the database
            $t = new Transaction();
            $t->source = $this->source_id;
            $t->utm_source = $utm_source;
            $t->share_safari_lead_id = $share_safari_lead->share_safari_lead_id;
            $t->share_safari_lead_installment_id = $share_safari_lead->id;
            $t->share_safari_id = $share_safari_lead->share_safari_id;
            $t->share_safari_version = $share_safari_lead->version;
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
            $t->currency = 'INR';
            $t->received_amount = $payuData['amount'];
            $t->payment_gateway = Transaction::PAYMENT_GATEWAY_PAYU;
            $t->name = $share_safari_lead->shareSafariLead->name;
            $t->email = $share_safari_lead->shareSafariLead->email;
            $t->phone = $share_safari_lead->shareSafariLead->phone;
            $t->start_date = $share_safari_lead->shareSafariLead->start_date;
            $t->end_date = $share_safari_lead->shareSafariLead->end_date;
            $t->validity_date = $share_safari_lead->shareSafari->cut_off_date != null ? $share_safari_lead->shareSafari->cut_off_date : date('Y-m-d H:i:s', strtotime('+1 day'));
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
            $t->user_id = $share_safari_lead->shareSafariLead->user_id;
            $t->param1 = $payuData['udf1'];
            $t->param2 = $payuData['udf2'];

            // Device and platform info
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
            $t->application_version = $application_version;

            $t->status = Transaction::STATUS_INITIATED;
            $t->created_at = time();
            $t->updated_at = time();
            $t->created_by = $share_safari_lead->shareSafariLead->user_id;
            $t->updated_by = $share_safari_lead->shareSafariLead->user_id;

            if (!$t->save()) {
                Yii::error('Transaction save failed: ' . json_encode($t->getErrors()), 'transaction');
                $transaction->rollBack();
                return [
                    'status' => 0,
                    'message' => 'Transaction save failed'
                ];
            }

            \common\models\transaction\TransactionEvents::store(\common\models\transaction\TransactionEvents::EVENT_PAYMENT_INITIATED, $share_safari_lead->shareSafariLead->id, null, $t->id);

            $data['status'] = 1;
            $transaction->commit();

            return $data;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Transaction creation failed: ' . $e->getMessage());
            return [
                'status' => 0,
                'message' => "Payment initiation failed. Please try again."
            ];
        }
    }

    /**
     * Generate standard PayU hash for web payments
     */
    private function generatePayuHash($data)
    {
        $salt = $this->merchantSalt;
        $hashPattern = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $fieldsOrder = explode('|', $hashPattern);

        $hashString = '';
        foreach ($fieldsOrder as $field) {
            $hashString .= isset($data['payu'][$field]) ? $data['payu'][$field] . '|' : '|';
        }
        $hashString .= $salt;

        return strtolower(hash('sha512', $hashString));
    }

    /**
     * Generate mobile SDK specific hashes
     */
    private function generateMobileHash($data, $hashType)
    {
        $salt = $this->merchantSalt;
        $payuData = $data['payu'];

        switch ($hashType) {
            case 'quickPayEvent':
                // Hash for quick pay event: key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5||||||salt
                $hashString = $payuData['key'] . '|' .
                    $payuData['txnid'] . '|' .
                    $payuData['amount'] . '|' .
                    $payuData['productinfo'] . '|' .
                    $payuData['firstname'] . '|' .
                    $payuData['email'] . '|' .
                    $payuData['udf1'] . '|' .
                    $payuData['udf2'] . '|' .
                    $payuData['udf3'] . '|' .
                    $payuData['udf4'] . '|' .
                    $payuData['udf5'] . '||||||' .
                    $salt;
                break;

            case 'getSdkConfiguration':
                // Hash for SDK configuration: key|command|var1|salt
                $hashString = $payuData['key'] . '|get_sdk_configuration|GET|' . $salt;
                break;



            case 'getCheckoutDetails':
                // Hash for checkout details: key|command|var1|salt

                //                 get_checkout_details = 3RYMv6|get_checkout_details|{"requestId":"t250828123921501756364962240","transactionDetails":{"amount":2000},"customerDetails":{"mobile":"7303767448"},"useCase":{"getAdditionalCharges":true,"getTaxSpecification":true,"checkDownStatus":true,"getExtendedPaymentDetails":true,"checkCustomerEligibility":true,
                // "getMerchantDetails":true,"getPaymentDetailsWithExtraFields":true,"getSdkDetails":true}}|



                $hashString = $payuData['key'] . '|get_checkout_details|{"requestId":"' . $payuData['txnid'] . '","transactionDetails":{"amount":' . $payuData['amount'] . '},"customerDetails":{"mobile":"'.$payuData['phone'].'"},"useCase":{"getAdditionalCharges":true,"getTaxSpecification":true,"checkDownStatus":true,"getExtendedPaymentDetails":true,"checkCustomerEligibility":true,"getMerchantDetails":true,"getPaymentDetailsWithExtraFields":true,"getSdkDetails":true}}|' . $salt;
                break;

            case 'getAllOfferDetails':
                // Hash for offer details: key|command|var1|salt
                $date = new \DateTime('now', new \DateTimeZone('GMT'));
                $hashString =  '{"amount":' . $payuData['amount'] . '}|' . $date->format('D, d M Y H:i:s') . ' GMT' . '|' . $salt;
                break;


            default:
                return '';
        }

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
                $installment->status = 1; //paid
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
