<?php

namespace console\controllers;

use common\models\operator\SafariOperator;
use common\models\package\Package;
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

    public function actionInactivePackage()
    {
        $safari_operators = SafariOperator::find()->where(['status' => SafariOperator::STATUS_SUSPEND])->all();
        foreach ($safari_operators as $operator) {
            $packages = Package::find()->where(['owned_by_id' => $operator->id])->all();
            foreach ($packages as $pack) {
                $pack->status = Package::STATUS_SUSPEND;
                $pack->save(false);
            }
        }
        echo "Done";
    }

    public function actionCallLog()
    {
        $url = \Yii::$app->params['airphone_api_host_url'] . '/api/pull-data';

        $model = \common\models\CallLog::find()
            ->where(['status' => \common\models\CallLog::STATUS_SUCCESS])
            ->andWhere(['is_detail_fetched' => 0])
            ->all();

        foreach ($model as $log) {

            $options = [
                'vnm' => \Yii::$app->params['airphone_api_vnm'],
                'unique_id' => $log->unique_id,
                'token' => \Yii::$app->params['airphone_api_token'],
            ];
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

            $json_contents = $response->content;

            $arr_contents = json_decode($json_contents, true);

            $data = $arr_contents['data'] ?? [];
            if (is_array($data) && !empty($data)) {
                $log->is_detail_fetched = true;
                $log->caller_id = $data['caller_id'] ?? '';
                $log->received_id = $data['received_id'] ?? '';
                $log->ivr_number = $data['ivr_number'] ?? '';
                $log->dial_status = $data['dial_status'] ?? '';
                $log->call_type = $data['call_type'] ?? '';
                $log->call_status = $data['call_status'] ?? '';
                $log->duration = $data['duration'] ?? '';
                $log->rec_duration = $data['Rec_duration'] ?? '';
                $log->recording_url = $data['recording_url'] ?? '';
                $log->datetime = $data['datetime'] ?? '';
                $log->save(false);
            }
        }
        echo date("Y-m-d h:i A")." done \n";
        die();
    }

    public function actionCallRecordingUploadToS3()
    {
        $models = \common\models\CallLog::find()
            ->where(['file_path' => NULL])
            ->all();
        foreach ($models as $model) {
            if (empty($model->file_path) && !empty($model->recording_url)) {
                try {
                    $content = file_get_contents($model->recording_url);
                    if ($content === false) {
                        throw new \Exception('Failed to fetch recording content from URL: ' . $model->recording_url);
                    }

                    // Determine the MIME type of the content
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_buffer($finfo, $content);
                    finfo_close($finfo);

                    // Map MIME type to file extension
                    $extension = $this->getFileExtensionFromMimeType($mimeType);
                    if (!$extension) {
                        throw new \Exception('Unsupported MIME type: ' . $mimeType);
                    }

                    // Create a temporary file to store the recording content
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'recording_');
                    file_put_contents($tempFilePath, $content);

                    // Prepare the UploadedFile instance
                    $uploadedFile = new \yii\web\UploadedFile([
                        'name' => $model->reference_id . '.' . $extension,
                        'tempName' => $tempFilePath,
                        'type' => $mimeType,
                        'size' => filesize($tempFilePath),
                        'error' => UPLOAD_ERR_OK,
                    ]);

                    $fileName = $model->reference_id . '.' . $extension;
                    $filePath = 'call_log/' . date('ym') . '/' . $fileName;

                    // Save the file using the existing helper method
                    $checksum = \common\Helper\FsHelper::saveUploadedFile($uploadedFile, $filePath, $fileName);

                    // Clean up the temporary file
                    unlink($tempFilePath);

                    if (!$checksum) {
                        throw new \Exception('Failed to upload file to S3.');
                    }

                    // Update the file path in the database
                    $model->file_path = $filePath;
                    $model->save(false);
                } catch (\Exception $e) {
                    \Yii::error('Error in uploadfiletoS3: ' . $e->getMessage(), __METHOD__);
                    throw $e; // Re-throw the exception for further handling
                }
            }
        }
    }

    private function getFileExtensionFromMimeType($mimeType)
    {
        $mimeMap = [
            'audio/mpeg' => 'mp3',
            'audio/wav' => 'wav',
            'audio/x-wav' => 'wav',
            'audio/ogg' => 'ogg',
            // Add more MIME types and extensions as needed
        ];

        return $mimeMap[$mimeType] ?? null;
    }

 
}
