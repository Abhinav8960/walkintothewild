<?php

namespace common\calling\services;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use common\models\CallLog;

class CallingService
{

    public $reference_id;
    public $chat_id;
    public $lead_id;
    public $request_vnm;
    public $has_direct_call = false;
    public $request_caller_1_no;
    public $request_caller_1_user_id;
    // public $request_caller_2_no = "9650901148";
    // public $request_caller_2_user_id = "2015";
    public $request_caller_2_no;
    public $request_caller_2_user_id;
    public $caller_id;
    public $received_id;
    public $ivr_number;
    public $recording_url;
    public $rec_duration;
    public $call_type;
    public $call_status;
    public $datetime;
    public $duration;
    public $operator_user_id;
    public $call_initiated_user_id;
    public $call_initiated_partner_id;
    public $file_path;

    public $call_model;

    public function __construct($chat_id, $lead_id, $operator_user_id, $call_initiated_user_id, $call_initiated_partner_id, $request_caller_1_no, $request_caller_1_user_id, $request_caller_2_no, $request_caller_2_user_id, $has_direct_call = false)
    {
        $this->reference_id = \Yii::$app->security->generateRandomString(5) . '_' . time() . '_' . \Yii::$app->security->generateRandomString(5);
        $this->request_vnm = time() . rand(1, 1000);
        $this->has_direct_call = $has_direct_call;
        $this->chat_id = $chat_id;
        $this->lead_id = $lead_id;
        $this->request_caller_1_no = $request_caller_1_no;
        $this->request_caller_1_user_id = $request_caller_1_user_id;
        $this->operator_user_id = $operator_user_id;  // Default user ID if not provided
        $this->call_initiated_user_id = $call_initiated_user_id;  // Default user ID if not provided
        $this->call_initiated_partner_id = $call_initiated_partner_id;  // Default user ID if not provided
        $this->request_caller_2_no = $request_caller_2_no != null  ? $request_caller_2_no :  $this->request_caller_2_no; // Default number if not provided
        $this->request_caller_2_user_id = $request_caller_2_user_id != null  ? $request_caller_2_user_id :  $this->request_caller_2_user_id;  // Default user ID if not provided

    }

    /**
     * Handle sending based on the mode (immediate or queued).
     */
    public function callNow()
    {

        if (empty($this->chat_id) ||  empty($this->request_caller_1_no) || empty($this->request_caller_1_user_id)) {
            \Yii::error('Missing required parameters for call: ' . json_encode([
                'chat_id' => $this->chat_id,
                'lead_id' => $this->lead_id,
                'request_caller_1_no' => $this->request_caller_1_no,
                'request_caller_1_user_id' => $this->request_caller_1_user_id
            ]), __METHOD__);
            return false;
        }
        return $this->queue() && $this->callImmediately() && $this->preparechat();
    }

    /**
     * Queue the event for later processing.
     */

    private function queue()
    {
        $this->call_model  = new CallLog();
        $this->call_model->reference_id = $this->reference_id;
        $this->call_model->is_dedicated = $this->has_direct_call;
        $this->call_model->chat_id = $this->chat_id;
        $this->call_model->lead_id = $this->lead_id;
        $this->call_model->request_vnm = $this->request_vnm;
        $this->call_model->request_caller_1_no = $this->request_caller_1_no;
        $this->call_model->request_caller_1_user_id = $this->request_caller_1_user_id;
        $this->call_model->request_caller_2_no = $this->request_caller_2_no;
        $this->call_model->request_caller_2_user_id = $this->request_caller_2_user_id;
        $this->call_model->call_initiated_user_id = $this->call_initiated_user_id;
        $this->call_model->call_initiated_partner_id = $this->call_initiated_partner_id;
        $this->call_model->status = CallLog::STATUS_FAILED;
        return $this->call_model->save(false);
    }

    /**
     * Send the event immediately.
     */
    private function callImmediately()
    {

        $url = \Yii::$app->params['deepcall_api_host_url'];

        $options = [
            'user_id' => \Yii::$app->params['deepcall_api_user_id'],
            // 'agent' => $this->request_caller_2_no,
            // 'caller' => $this->request_caller_1_no,
            'from' => $this->request_caller_2_no, // This is the number from which the call is made
            'to' => $this->request_caller_1_no, // This is the number to be called
            'token' => \Yii::$app->params['deepcall_api_token'],
            'reqId' => $this->reference_id
        ];

        if ($this->has_direct_call == true) {
            $options = [
                'token' => \Yii::$app->params['deepcall_direct_api_token'],
                'user_id' => \Yii::$app->params['deepcall_direct_api_user_id'],
                'from' => $this->request_caller_2_no, // This is the number from which the call is made
                'fromType' => 'Number',
                'fromStrategy' => 'TO_ALL',
                'fromRingTime' => 30,
                'fromRetryCount' => 0,
                'fromWebLogin' => 'no',
                'fromCLI'   => sprintf('%011d', $this->request_caller_2_no),
                'to' => $this->request_caller_1_no, // This is the number to be called
                'toType' => 'Number',
                'toStrategy' => 'TO_ALL',
                'toRingTime' => 30,
                'toRetryCount' => 0,
                'toWebLogin' => 'no',
                'toCLI'   => sprintf('%011d', $this->request_caller_1_no),
                'reqId' => $this->reference_id
            ];
        }
        $client = new \yii\httpclient\Client();

        $response = $client->createRequest()
            ->setMethod('POST')
            ->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->setUrl($url)
            ->setData($options) // Use setData for form parameters
            ->send();
        if (!$response->isOk) {
            \Yii::error('Call failed: ' . $response->content, __METHOD__);
            return false;
        }

        \Yii::info('Informational call log', 'call-error');


        $json_contents = json_encode($response->content);
        $arr_contents = json_decode($response->content, true);
        \Yii::info('Informational call log: ' . $json_contents, 'call-error');


        // print_r([$response->content, $options]);
        // die();
        if (is_array($arr_contents) && !empty($arr_contents)) {
            if (isset($arr_contents['status']) && strtolower($arr_contents['status'])) {
                $this->call_model->unique_id = $arr_contents['unique_id'] ?? null;
                $this->call_model->status = CallLog::STATUS_SUCCESS;
            }
        }
        $this->call_model->call_request_status = $arr_contents['status'];
        $this->call_model->call_request_message = $arr_contents['message'] ?? null;
        $this->call_model->save(false);
        return $this->call_model->status;
    }



    private function preparechat()
    {
        $chat_model = Chat::find()
            ->andWhere(['id' => $this->call_model->chat_id])
            ->andWhere(['chat_type' => [Chat::CHAT_TYPE_QUOTE, Chat::CHAT_TYPE_SHARE_SAFARI]])
            ->one();

        if (!$chat_model) {
            return false;
        }

        $message = "Voice Call";

        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_model->id;
        $chat_message->call_id = $this->call_model->id;
        $chat_message->message = $message;
        $chat_message->is_call_message = true;
        $chat_message->status = 1;
        $chat_message->sender_id = $this->call_initiated_user_id;

        if ($chat_message->save(false)) {

            $chat = Chat::find()->where(['id' => $chat_model->id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxlength($message);
            $chat->last_message_at = time();
            $chat->call_id = $this->call_model->id;
            $chat->is_call_request = false;
            $chat->sender_id = $this->call_initiated_user_id;
            $chat->is_lead_chat_open_for_user = 1;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            return $chat->save(false);
        }

        return false;
    }
}
