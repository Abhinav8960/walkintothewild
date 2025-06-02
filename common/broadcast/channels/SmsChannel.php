<?php

namespace common\broadcast\channels;

use common\models\master\smstemplate\MasterSmsTemplate;
use yii\httpclient\Client;

class SmsChannel
{
    const CHANNEL_NAME = 'sms';

    public function send($event, $log)
    {
        $phone_no = $log->phone_no;
        $route = $log->route;
        // $message = $log->message;
        // $message = "DearXXXX, your OTP for mobile number verification with Walk Into The Wild is XXXX. Please enter this code to complete your verification. - Mediarc Technology";
        $message = $this->generateMessage($log->template_id, !empty($log->params) ? json_decode($log->params, true) : []);
        $template_id = $log->template_id;
        $url = "http://sms.trilineinfotech.com/api/smsapi?key=" . \Yii::$app->params['sms_api_key'] . "&route=" . $route . "&sender=" . \Yii::$app->params['sms_sender_id'] . "&number=" . $phone_no . "&sms=" . urlencode($message) . "&templateid=" . $template_id;
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();
        \yii::info('SMS Response: ' . date('Y-m-d H:i:s') . ' ' . json_encode($response), __METHOD__);
        if ($response->isOk) {
            // Extract the last line from the response content
            $responseContent = $response->content;
            // Split the content into lines and get the last line
            $lines = explode("\n", $responseContent);
            $lastLinecode = trim(end($lines)); // Get the last line and trim any whitespace

            \yii::info('Extracted Last Line: ' . $responseContent, __METHOD__);
            if ($response) {
                $log->is_ok = 1;
                $log->status = 1;
                $log->response_code = $lastLinecode; // Save the extracted code if needed
                $log->sms_send_time = time(); // Save the extracted code if needed
                $log->save(false);
            } else {
                $log->status = 0;
                $log->sms_send_time = time(); // Save the extracted code if needed
                $log->save(false);
            }
        } else {
            $log->status = 0;
            $log->save(false);
        }
    }

    private function generateMessage($template_id, $params = [])
    {
        $template = MasterSmsTemplate::find()
            ->where(['template_id' => $template_id])
            ->one();
        if ($template === null) {
            return null; // Handle the case where the template is not found
        }
        $message = $this->rendermessage($template->message, $params);

        return $message;
    }

    private function rendermessage($message, $params)
    {
        return \Yii::$app->engine->render($message, $params);
    }
}
