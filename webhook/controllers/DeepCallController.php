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
class DeepCallController extends Controller
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
                        'actions' => ['index', 'save-call-log'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST', 'GET'],
                    'save-call-log' => ['POST', 'GET']
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if (in_array($action->id, ['index'])) {
            // Disable CSRF validation for the payu-response action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $pushReport = Yii::$app->request->post('push_report');
        
        if(empty($pushReport)) {
            // echo "No push_report data received";
            // die();
            throw new \yii\web\BadRequestHttpException('No push_report data received');
        }
        \Yii::info('deep-call webhook: ' . date('Y-m-d H:i A') . '' . json_encode($pushReport), 'deep-call');
        // First remove escaped quotes and decode
        $jsonString = stripslashes($pushReport);

        // First decode the JSON string
        $data = json_decode($jsonString, true);



        if (json_last_error() !== JSON_ERROR_NONE) {
            Yii::error('JSON decode error: ' . json_last_error_msg(), 'deep-call');
            throw new \Exception('Invalid JSON format');
        }


        if (Yii::$app->request->isPost) {
            // Parse the nested data

            if (isset($data['api_para']['userId']) && isset($data['api_para']['reqId'])) {
                $userId = $data['api_para']['userId'];
                $reqId = $data['api_para']['reqId'];
                // Save the call log data
                $this->saveCallLog($data);
                \Yii::info("User ID: $userId, Request ID: $reqId", 'deep-call');
            } else {
                \Yii::error('Invalid data received', 'deep-call');
            }
        } else {
            \Yii::error('No POST data received', 'deep-call');
        }
        return "GODBLESSYOU";
    }

    

    // public function actionSaveCallLog()
    private function saveCallLog($data)
    {


        $callLog = \common\models\CallLog::find()->where(['reference_id' => $data['api_para']['reqId']])->one();
        if (!$callLog) {
            return false; // Return false if call log not found
        }
        $callLog->service = \common\models\CallLog::SERVICE_DEEP_CALL;
        $callLog->service_user_id = $data['api_para']['userId'] ?? null;
        // $callLog->from_type = $data['api_para']['fromType'] ?? null;
        // $callLog->from = $data['api_para']['from'] ?? null;
        // $callLog->to_type = $data['api_para']['toType'] ?? null;
        // $callLog->to = $data['api_para']['to'] ?? null;
        $callLog->reference_id = $data['api_para']['reqId'] ?? null;
        $callLog->did = $data['did'] ?? null;
        $callLog->c_type = $data['cType'] ?? null;
        $callLog->camp_id = $data['campId'] ?? null;
        $callLog->exc_adm = $data['excAdm'] ?? null;
        $callLog->ivr_s_time = $data['ivrSTime'] ?? null;
        $callLog->ivr_e_time = $data['ivrETime'] ?? null;
        $callLog->ivr_duration = $data['ivrDuration'] ?? null;
        $callLog->c_number = $data['cNumber'] ?? null;
        $callLog->master_num_ctc = $data['masterNumCTC'] ?? null;
        $callLog->master_agent = $data['masterAgent'] ?? null;
        $callLog->master_agent_number = $data['masterAgentNumber'] ?? null;
        $callLog->master_group_id = $data['masterGroupId'] ?? null;
        $callLog->talk_duration = $data['talkDuration'] ?? null;
        $callLog->agent_on_call_duration = $data['agentOnCallDuration'] ?? null;
        $callLog->call_id = $data['callId'] ?? null;
        $callLog->first_attended = $data['firstAttended'] ?? null;
        $callLog->first_answer_time = $data['firstAnswerTime'] ?? null;
        $callLog->last_hangup_time = $data['lastHangupTime'] ?? null;
        $callLog->last_first_duration = $data['lastFirstDuration'] ?? null;
        $callLog->cust_answer_s_time = $data['custAnswerSTime'] ?? null;
        $callLog->cust_answer_e_time = $data['custAnswerETime'] ?? null;
        $callLog->cust_answer_duration = $data['custAnswerDuration'] ?? null;
        $callLog->call_status = $data['callStatus'] ?? null;
        $callLog->ivr_execute_flow = $data['ivrExecuteFlow'] ?? null;
        $callLog->hangup_by_source_detected = $data['HangupBySourceDetected'] ?? null;
        $callLog->forward = $data['forward'] ?? null;
        $callLog->total_hold_duration = $data['totalHoldDuration'] ?? null;
        // $callLog->total_credits_used = json_encode($data['totalCreditsUsed']) ?? null;
        // $callLog->ivr_id_arr = json_encode($data['ivrIdArr']) ?? null;
        // $callLog->a_ans_h = json_encode($data['aAnsH']) ?? null;
        // $callLog->a_h = json_encode($data['aH']) ?? null;
        // $callLog->n_h = json_encode($data['nH']) ?? null;
        // $callLog->recordings = json_encode($data['recordings']) ?? null;
        // $callLog->voice_mail = json_encode($data['voiceMail']) ?? null;
        // $callLog->dtmf = json_encode($data['DTMF']) ?? null;
        // $callLog->cli_arr = json_encode($data['cliArr']) ?? null;
        // $callLog->a_h_detail = json_encode($data['aHDetail']) ?? null;
        // $callLog->n_h_detail = json_encode($data['nHDetail']) ?? null;
        // $callLog->modules = json_encode($data['modules']) ?? null;
        // $callLog->call_disposition = $data['callDisposition'] ?? null;
        // $callLog->call_back = $data['callBack'] ?? null;
        // $callLog->created_updated = time();
        $recording_url = isset($data['recordings'][0]['file']) ? 'https://s-ct3.sarv.com/v2/recording/direct/' . \Yii::$app->params['deepcall_api_user_id'] . '' . $data['recordings'][0]['file'] : null;

        if (!$callLog->save()) {
            echo "Failed to save call log: " . json_encode($callLog->getErrors());
            \Yii::error('Failed to save call log: ' . json_encode($callLog->getErrors()), 'deep-call');
            return false; // Return false if saving failed
        }

        $this->saveCallLogNumbersDetails($data, $callLog->id);
        $this->callRecordingUploadToS3($callLog->id, $recording_url); // Call the method to upload recordings to S3
        echo "Call log saved successfully with ID: " . $callLog->id;
        return true; // Return true if saved successfully
    }

    private function saveCallLogNumbersDetails($data, $callLogId)
    {
        if (isset($data['nHDetail']) && is_array($data['nHDetail'])) {
            foreach ($data['nHDetail'] as $detail) {
                $callLogDetail = new \common\models\CallLogNumbersDetails();
                $callLogDetail->call_log_id = $callLogId;
                $callLogDetail->ctc = $detail['CTC'] ?? null;
                $callLogDetail->status = $detail['status'] ?? null;
                $callLogDetail->ping = $detail['ping'] ?? null;
                $callLogDetail->number = $detail['number'] ?? null;
                $callLogDetail->visit_id = $detail['visitId'] ?? null;
                $callLogDetail->node_id = $detail['nodeId'] ?? null;
                $callLogDetail->total_ring_duration = $detail['totalRingDuration'] ?? 0;
                $callLogDetail->total_hold_duration = $detail['totalHoldDuration'] ?? 0;
                $callLogDetail->talk_duration = $detail['talkDuration'] ?? 0;
                $callLogDetail->talk_s_time = $detail['talkSTime'] ?? null;
                $callLogDetail->talk_e_time = $detail['talkETime'] ?? null;
                $callLogDetail->answer_s_time = isset($detail['answerSTime']) ? strtotime($detail['answerSTime']) : null;
                $callLogDetail->answer_e_time = isset($detail['answerETime']) ? strtotime($detail['answerETime']) : null;
                $callLogDetail->answer_duration = isset($detail['answerDuration']) ? (int)$detail['answerDuration'] : 0;
                $callLogDetail->cli = isset($detail['cli']) ? json_encode($detail['cli']) : null; // Assuming cli is an array
                $callLogDetail->retry = isset($detail['retry']) ? (int)$detail['retry'] : 0;
                $callLogDetail->recording_url = isset($detail['recordingUrl']) ? (string)$detail['recordingUrl'] : null;
                $callLogDetail->save(false);
            }
            // $this->callRecordingUploadToS3($callLogId, $recording_url); // Call the method to upload recordings to S3
            return true; // Return true if saved successfully
        } else {
            \Yii::error('No nHDetail data found in the request', 'deep-call');
            return false; // Return false if no nHDetail data found 
        }
    }

    private function callRecordingUploadToS3($callLogId, $recording_url)
    {

        if (empty($recording_url)) {
            \Yii::info('No recording URL provided for call log ID: ' . $callLogId, 'deep-call');
            return; // Exit if there's no recording URL
        }
        $model = \common\models\CallLog::find()->where(['id' => $callLogId])->one();
        if (!empty($model)) {
            $model->recording_url = $recording_url;
            $model->save(false);
        }
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
