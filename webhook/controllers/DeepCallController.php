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
                        'actions' => ['index'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST', 'GET']
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
        $data = Yii::$app->request->post();
        \Yii::info('deep-call webhook: ' . date('Y-m-d H:i A') . '' . json_encode($data), 'deep-call');

        if (Yii::$app->request->isPost) {
            $json = json_encode($data);
            $arr = json_decode($json, true);
            if (isset($arr['api_para']['userId']) && isset($arr['api_para']['reqId'])) {
                $userId = $arr['api_para']['userId'];
                $reqId = $arr['api_para']['reqId'];
                // Save the call log data
                $this->saveCallLog($arr);
                \Yii::info("User ID: $userId, Request ID: $reqId", 'deep-call');
            } else {
                \Yii::error('Invalid data received', 'deep-call');
            }
        } else {
            \Yii::error('No POST data received', 'deep-call');
        }
        return "GODBLESSYOU";
    }

    // private function saveCallLog($data)
    public function actionSaveCallLog()
    {
        $data = json_decode('{\"api_para\":{\"userId\":\"99985561\",\"fromType\":\"number\",\"from\":\"9650901148\",\"toType\":\"number\",\"to\":\"9315723354\",\"reqId\":\"rIhwk_1754661511_W_jMI\"},\"contactListData\":{},\"did\":null,\"cType\":\"CTC\",\"campId\":0,\"excAdm\":75,\"ivrSTime\":\"2025-08-08 19:28:32\",\"ivrETime\":\"2025-08-08 19:28:51\",\"ivrDuration\":19,\"userId\":\"99985561\",\"cNumber\":\"919315723354\",\"masterNumCTC\":\"919650901148\",\"masterAgent\":\"\",\"masterAgentNumber\":\"\",\"masterGroupId\":0,\"talkDuration\":8,\"agentOnCallDuration\":0,\"callId\":\"2me2nb2r2175466151149712937\",\"firstAttended\":\"from\",\"firstAnswerTime\":\"2025-08-08 19:28:35\",\"lastHangupTime\":\"2025-08-08 19:28:51\",\"lastFirstDuration\":16,\"custAnswerSTime\":\"2025-08-08 19:28:43\",\"custAnswerETime\":\"2025-08-08 19:28:51\",\"custAnswerDuration\":48,\"callStatus\":3,\"ivrExecuteFlow\":null,\"HangupBySourceDetected\":0,\"forward\":\"false\",\"totalHoldDuration\":0,\"totalCreditsUsed\":{\"freeHit\":2,\"paidHit\":0,\"amount\":0},\"ivrIdArr\":[],\"aAnsH\":[],\"aH\":[],\"nH\":[\"919315723354\",\"919650901148\"],\"recordings\":[{\"nodeid\":\"to\",\"visitId\":\"1754661514686\",\"file\":\"/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\",\"time\":\"2025-08-08 19:28:43\"}],\"voiceMail\":[],\"DTMF\":[],\"cliArr\":{\"9650901148\":[\"917557180901\"],\"9315723354\":[\"917557180901\"]},\"aHDetail\":[],\"nHDetail\":[{\"CTC\":\"to\",\"status\":\"answered\",\"recording\":\"/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\",\"ping\":\"direct\",\"number\":\"919315723354\",\"visitId\":\"1754661514686\",\"nodeId\":\"#1\",\"totalRingDuration\":8,\"totalHoldDuration\":0,\"talkDuration\":8,\"talkSTime\":\"2025-08-08 19:28:43\",\"talkETime\":\"2025-08-08 19:28:51\",\"answerSTime\":\"2025-08-08 19:28:43\",\"answerETime\":\"2025-08-08 19:28:51\",\"answerDuration\":8,\"cli\":\"917557180901\",\"retry\":0,\"recordingUrl\":\"https://s-ct3.sarv.com/v2/recording/direct/99985561/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\"},{\"CTC\":\"from\",\"status\":\"answered\",\"recording\":\"/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\",\"ping\":\"direct\",\"number\":\"919650901148\",\"visitId\":\"1754661511518\",\"nodeId\":\"#1\",\"totalRingDuration\":3,\"totalHoldDuration\":0,\"talkDuration\":8,\"talkSTime\":\"2025-08-08 19:28:43\",\"talkETime\":\"2025-08-08 19:28:51\",\"answerSTime\":\"2025-08-08 19:28:35\",\"answerETime\":\"2025-08-08 19:28:51\",\"answerDuration\":16,\"cli\":\"917557180901\",\"retry\":0,\"recordingUrl\":\"https://s-ct3.sarv.com/v2/recording/direct/99985561/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\"}],\"modules\":[],\"callDisposition\":\"[]\",\"callBack\":\"\"}', true);

        $callLog = \common\models\CallLog::find()->where(['reference_id' => $data['api_para']['reqId']])->one();
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
        $callLog->total_credits_used = json_encode($data['totalCreditsUsed']) ?? null;
        $callLog->ivr_id_arr = json_encode($data['ivrIdArr']) ?? null;
        $callLog->a_ans_h = json_encode($data['aAnsH']) ?? null;
        $callLog->a_h = json_encode($data['aH']) ?? null;
        $callLog->n_h = json_encode($data['nH']) ?? null;
        $callLog->recordings = json_encode($data['recordings']) ?? null;
        $callLog->voice_mail = json_encode($data['voiceMail']) ?? null;
        $callLog->dtmf = json_encode($data['DTMF']) ?? null;
        $callLog->cli_arr = json_encode($data['cliArr']) ?? null;
        $callLog->a_h_detail = json_encode($data['aHDetail']) ?? null;
        $callLog->n_h_detail = json_encode($data['nHDetail']) ?? null;
        $callLog->modules = json_encode($data['modules']) ?? null;
        $callLog->call_disposition = $data['callDisposition'] ?? null;
        $callLog->call_back = $data['callBack'] ?? null;
        $callLog->created_updated = time();
        if (!$callLog->save()) {
            \Yii::error('Failed to save call log: ' . json_encode($callLog->getErrors()), 'deep-call');
            return false; // Return false if saving failed
        }
        $this->saveCallLogNumbersDetails($data, $callLog->id);
        return true; // Return true if saved successfully
    }

    private function saveCallLogNumbersDetails($data, $callLogId)
    {
        $recording_url = null;
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
                $recording_url = $callLogDetail->recording_url = isset($detail['recordingUrl']) ? (string)$detail['recordingUrl'] : null;
                $callLogDetail->save(false);
            }
            $this->callRecordingUploadToS3($callLogId, $recording_url); // Call the method to upload recordings to S3
            return true; // Return true if saved successfully
        } else {
            \Yii::error('No nHDetail data found in the request', 'deep-call');
            return false; // Return false if no nHDetail data found 
        }
    }

    private function callRecordingUploadToS3($callLogId, $recording_url)
    {
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
