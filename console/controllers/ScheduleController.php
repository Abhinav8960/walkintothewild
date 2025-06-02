<?php

namespace console\controllers;

use common\models\SmsLog;
use yii\console\Controller;
use yii\httpclient\Client;



/**
 * DataCopy controller
 */
class ScheduleController extends Controller
{

    public function actionSmsReport()
    {
        // This action can be used to generate SMS reports
        // You can implement the logic to fetch SMS data and generate a report
        // For example, you might want to fetch SMS logs and send them via email or save them to a file

        // $model = SmsLog::find()
        //     ->where(['status1' => SmsLog::STATUS_SENT])->andWhere(['IS NOT', 'response_code', NULL])->andWhere(['and', ['report_status' => NULL], ['report_error_code' => 0]])
        //     ->all();
        $model = SmsLog::find()
            ->where(['status' => SmsLog::STATUS_SENT])
            ->all();
        foreach ($model as $log) {
            // Process each SMS log entry
            // You can implement your logic here, such as sending an email report or saving to a file
            $url = "http://sms.trilineinfotech.com/api/dlrapi?key=" . \Yii::$app->params['sms_api_key'] . "&messageid=" . $log->response_code;
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setHeaders(['content-type' => 'application/json'])
                ->setUrl($url)
                ->send();

            // $response =    [
            //     [
            //         "9650901148",
            //         "Delivered",
            //         "2025-06-02 15:16:40"
            //     ]
            // ];
            // echo "SMS sms_api_key: " . \Yii::$app->params['sms_api_key'] . "\n";
            // echo "SMS id: " . $log->id . "\n";
            // echo "SMS response_code: " . $log->response_code . "\n";
            // echo "SMS Report Response: " . date('Y-m-d H:i:s') . ' ' . json_encode($response->content) . "\n";
            // echo "\n";
            // echo "\n";
            $json_contents = json_encode($response->content);
            $arr_contents = json_decode($response->content, true);
            if (is_array($arr_contents) && !empty($arr_contents)) {
                $responseContent = $arr_contents ?? [];

                foreach ($responseContent as $res) {

                    $log->report_status = strtolower($res[1]);
                    $log->is_deliver = strtolower($res[1]) == 'delivered' ? SmsLog::STATUS_DELIVERD : 0;
                    $log->status = $log->is_deliver ? SmsLog::STATUS_DELIVERD : SmsLog::STATUS_FAILED;
                    $log->report_status_datetime = $res[2];
                    // Save the log entry with the updated report status

                }
            } else {
                $log->report_error_code = $response->content;
                $log->status = SmsLog::STATUS_FAILED;

                // Handle the case where the response is not in the expected format
                // \yii::error('Unexpected response format: ' . json_encode($response->content), __METHOD__);
            }
            $log->save(false);
        }
    }

    // Add more actions as needed for scheduling tasks
}
