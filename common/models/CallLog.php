<?php

namespace common\models;

use common\models\chat\Chat;
use common\models\operator\SafariOperator;
use Yii;

/**
 * This is the model class for table "call_log".
 *
 * @property int $id
 * @property int $service 1=>Airphone,2=>deepcall
 * @property string $reference_id
 * @property string|null $unique_id
 * @property int $chat_id
 * @property int|null $lead_id
 * @property string|null $did
 * @property string|null $c_type
 * @property string|null $camp_id
 * @property string|null $exc_adm
 * @property string|null $ivr_s_time
 * @property string|null $ivr_e_time
 * @property int $ivr_duration
 * @property int $service_user_id
 * @property string|null $c_number
 * @property string|null $master_num_ctc
 * @property string|null $master_agent
 * @property string $master_agent_number
 * @property string $master_group_id
 * @property int|null $talk_duration
 * @property int|null $agent_on_call_duration
 * @property string|null $call_id
 * @property string|null $first_attended
 * @property string|null $first_answer_time
 * @property string|null $last_hangup_time
 * @property int $last_first_duration
 * @property string|null $cust_answer_s_time
 * @property string|null $cust_answer_e_time
 * @property int $cust_answer_duration
 * @property string|null $ivr_execute_flow
 * @property int $hangup_by_source_detected
 * @property int $forward
 * @property int $total_hold_duration
 * @property string|null $request_vnm
 * @property string|null $request_caller_1_no
 * @property int|null $request_caller_1_user_id
 * @property string|null $request_caller_2_no
 * @property int|null $request_caller_2_user_id
 * @property string|null $caller_id
 * @property string|null $received_id
 * @property string|null $ivr_number
 * @property string|null $recording_url
 * @property string|null $dial_status
 * @property string|null $rec_duration
 * @property string|null $call_type
 * @property string|null $call_status
 * @property string|null $datetime
 * @property string|null $duration
 * @property int|null $operator_user_id
 * @property string|null $file_path
 * @property int|null $call_initiated_user_id
 * @property int|null $call_initiated_partner_id
 * @property string|null $call_request_status
 * @property string|null $call_request_message
 * @property int $status 0=>Failed,1=>Success
 * @property int $is_detail_fetched
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CallLog extends \common\models\trierror\ActiveLogRecord implements \common\interfaces\NewStatusInterface
{
    public const SERVICE_AIR_PHONE = 1;
    public const SERVICE_DEEP_CALL = 2;
    const STATUS_FAILED = 0;
    const STATUS_SUCCESS = 1;

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unique_id', 'lead_id', 'did', 'c_type', 'camp_id', 'exc_adm', 'ivr_s_time', 'ivr_e_time', 'c_number', 'master_num_ctc', 'master_agent', 'talk_duration', 'agent_on_call_duration', 'call_id', 'first_attended', 'first_answer_time', 'last_hangup_time', 'cust_answer_s_time', 'cust_answer_e_time', 'ivr_execute_flow', 'request_vnm', 'request_caller_1_no', 'request_caller_1_user_id', 'request_caller_2_no', 'request_caller_2_user_id', 'caller_id', 'received_id', 'ivr_number', 'recording_url', 'dial_status', 'rec_duration', 'call_type', 'call_status', 'datetime', 'duration', 'operator_user_id', 'file_path', 'call_initiated_user_id', 'call_initiated_partner_id', 'call_request_status', 'call_request_message', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['service'], 'default', 'value' => 2],
            [['is_detail_fetched','is_dedicated'], 'default', 'value' => 0],
            [['service', 'chat_id', 'lead_id', 'ivr_duration', 'service_user_id', 'talk_duration', 'agent_on_call_duration', 'last_first_duration', 'cust_answer_duration', 'hangup_by_source_detected', 'total_hold_duration', 'request_caller_1_user_id', 'request_caller_2_user_id', 'operator_user_id', 'call_initiated_user_id', 'call_initiated_partner_id', 'status', 'is_detail_fetched', 'created_at', 'updated_at'], 'integer'],
            [['reference_id', 'chat_id', 'ivr_duration', 'service_user_id',  'master_group_id', 'last_first_duration', 'cust_answer_duration', 'hangup_by_source_detected', 'total_hold_duration'], 'required'],
            [['ivr_s_time', 'ivr_e_time', 'first_answer_time', 'last_hangup_time', 'cust_answer_s_time', 'cust_answer_e_time', 'forward', 'master_agent_number', 'camp_id', 'exc_adm', 'call_status', 'master_group_id'], 'safe'],
            [['reference_id', 'caller_id', 'received_id', 'ivr_number', 'rec_duration'], 'string', 'max' => 50],
            [['unique_id', 'request_vnm', 'datetime', 'duration'], 'string', 'max' => 100],
            [['did', 'c_type',   'c_number', 'master_num_ctc', 'master_agent', 'master_agent_number',  'call_id', 'first_attended', 'ivr_execute_flow', 'recording_url', 'dial_status', 'call_type',  'file_path', 'call_request_status', 'call_request_message'], 'string', 'max' => 255],
            [['request_caller_1_no', 'request_caller_2_no'], 'string', 'max' => 20],
            [['reference_id'], 'unique'],
            [['unique_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service' => 'Service',
            'reference_id' => 'Reference ID',
            'unique_id' => 'Unique ID',
            'chat_id' => 'Chat ID',
            'lead_id' => 'Lead ID',
            'did' => 'Did',
            'c_type' => 'C Type',
            'camp_id' => 'Camp ID',
            'exc_adm' => 'Exc Adm',
            'ivr_s_time' => 'Ivr S Time',
            'ivr_e_time' => 'Ivr E Time',
            'ivr_duration' => 'Ivr Duration',
            'service_user_id' => 'Service User ID',
            'c_number' => 'C Number',
            'master_num_ctc' => 'Master Num Ctc',
            'master_agent' => 'Master Agent',
            'master_agent_number' => 'Master Agent Number',
            'master_group_id' => 'Master Group ID',
            'talk_duration' => 'Talk Duration',
            'agent_on_call_duration' => 'Agent On Call Duration',
            'call_id' => 'Call ID',
            'first_attended' => 'First Attended',
            'first_answer_time' => 'First Answer Time',
            'last_hangup_time' => 'Last Hangup Time',
            'last_first_duration' => 'Last First Duration',
            'cust_answer_s_time' => 'Cust Answer S Time',
            'cust_answer_e_time' => 'Cust Answer E Time',
            'cust_answer_duration' => 'Cust Answer Duration',
            'ivr_execute_flow' => 'Ivr Execute Flow',
            'hangup_by_source_detected' => 'Hangup By Source Detected',
            'forward' => 'Forward',
            'total_hold_duration' => 'Total Hold Duration',
            'request_vnm' => 'Request Vnm',
            'request_caller_1_no' => 'Request Caller 1 No',
            'request_caller_1_user_id' => 'Request Caller 1 User ID',
            'request_caller_2_no' => 'Request Caller 2 No',
            'request_caller_2_user_id' => 'Request Caller 2 User ID',
            'caller_id' => 'Caller ID',
            'received_id' => 'Received ID',
            'ivr_number' => 'Ivr Number',
            'recording_url' => 'Recording Url',
            'dial_status' => 'Dial Status',
            'rec_duration' => 'Rec Duration',
            'call_type' => 'Call Type',
            'call_status' => 'Call Status',
            'datetime' => 'Datetime',
            'duration' => 'Duration',
            'operator_user_id' => 'Operator User ID',
            'file_path' => 'File Path',
            'call_initiated_user_id' => 'Call Initiated User ID',
            'call_initiated_partner_id' => 'Call Initiated Partner ID',
            'call_request_status' => 'Call Request Status',
            'call_request_message' => 'Call Request Message',
            'status' => 'Status',
            'is_detail_fetched' => 'Is Detail Fetched',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // public function afterSave($insert, $changedAttributes)
    // {
    //     parent::afterSave($insert, $changedAttributes);

    //     // If the call log is successfully saved, create a chat message
    //     if ($this->status == self::STATUS_SUCCESS && empty($this->file_path)) {
    //         $this->uploadfiletoS3();
    //     }
    // }

    // public function uploadfiletoS3()
    // {
    //     if (empty($this->file_path) && !empty($this->recording_url)) {
    //         try {
    //             $content = file_get_contents($this->recording_url);
    //             if ($content === false) {
    //                 throw new \Exception('Failed to fetch recording content from URL: ' . $this->recording_url);
    //             }

    //             // Determine the MIME type of the content
    //             $finfo = finfo_open(FILEINFO_MIME_TYPE);
    //             $mimeType = finfo_buffer($finfo, $content);
    //             finfo_close($finfo);

    //             // Map MIME type to file extension
    //             $extension = $this->getFileExtensionFromMimeType($mimeType);
    //             if (!$extension) {
    //                 throw new \Exception('Unsupported MIME type: ' . $mimeType);
    //             }

    //             // Create a temporary file to store the recording content
    //             $tempFilePath = tempnam(sys_get_temp_dir(), 'recording_');
    //             file_put_contents($tempFilePath, $content);

    //             // Prepare the UploadedFile instance
    //             $uploadedFile = new \yii\web\UploadedFile([
    //                 'name' => $this->reference_id . '.' . $extension,
    //                 'tempName' => $tempFilePath,
    //                 'type' => $mimeType,
    //                 'size' => filesize($tempFilePath),
    //                 'error' => UPLOAD_ERR_OK,
    //             ]);

    //             $fileName = $this->reference_id . '.' . $extension;
    //             $filePath = 'call_log/' . date('ym') . '/' . $fileName;

    //             // Save the file using the existing helper method
    //             $checksum = \common\Helper\FsHelper::saveUploadedFile($uploadedFile, $filePath, $fileName);

    //             // Clean up the temporary file
    //             unlink($tempFilePath);

    //             if (!$checksum) {
    //                 throw new \Exception('Failed to upload file to S3.');
    //             }

    //             // Update the file path in the database
    //             $this->file_path = $filePath;
    //             $this->save(false);
    //         } catch (\Exception $e) {
    //             Yii::error('Error in uploadfiletoS3: ' . $e->getMessage(), __METHOD__);
    //             throw $e; // Re-throw the exception for further handling
    //         }
    //     }
    // }

    public function getNumberDetails()
    {
        return $this->hasMany(CallLogNumbersDetails::className(), ['call_log_id' => 'id']);
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

    public function getCallerUser1()
    {
        return $this->hasOne(User::className(), ['id' => 'request_caller_1_user_id']);
    }

    public function getCallerUser2()
    {
        return $this->hasOne(User::className(), ['id' => 'request_caller_2_user_id']);
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'call_initiated_partner_id']);
    }

    public static function callStatusList()
    {

        return [
            3 => 'Both Answered', //Both Answered
            4 => 'Cust. Ans. - Agent Unans.',    //To Ans. - From Unans.
            5 => 'Cust. Ans',    //To Ans
            6 => 'Cust. Unans - Agent Ans.', //	To Unans - From Ans.
            7 => 'Agent Unanswered', //From Unanswered
            8 => 'Cust. Unans.', //	To Unans.
            9 => 'Both Unanswered', //	Both Unanswered
            10 => 'Agent Ans.', //	From Ans.
            11 => 'Rejected Call', //	Rejected Call
            12 => 'Skipped', //	Skipped
            13 => 'Agent Failed', //	From Failed
            14 => 'Cust. Failed - Agent Ans.', //	To Failed - From Ans.
            15 => 'Cust. Failed', //	To Failed
            16 => 'Cust. Ans - Agent Failed', //	To Ans - From Failed
            17 => 'Agent Busy', //	From Busy
            18 => 'Cust. Ans - Agent Not Found', //	To Ans. - From Not Found
            19 => 'Cust. Unans - Agent Busy', //	To Unans. - From Busy
            20 => 'Cust. Hangup in Queue', //	To Hangup in Queue
            21 => 'Cust. Hangup' //	To Hangup
        ];
    }

    public static function callStatusForChatList()
    {

        return [
            3 => 'Call Connetced', //Both Answered
            4 => 'Call not connected.',    //To Ans. - From Unans.
            5 => 'Cust. Ans',    //To Ans
            6 => 'Call not connected', //	To Unans - From Ans.
            7 => 'Call not connected', //From Unanswered
            8 => 'Call not connected', //	To Unans.
            9 => 'Call not connected', //	Both Unanswered
            10 => 'Call not connected', //	From Ans.
            11 => 'Call not connected', //	Rejected Call
            12 => 'Call not connected', //	Skipped
            13 => 'Call not connected', //	From Failed
            14 => 'Call not connected', //	To Failed - From Ans.
            15 => 'Call not connected', //	To Failed
            16 => 'Call not connected', //	To Ans - From Failed
            17 => 'Busy', //	From Busy
            18 => 'Call not connected', //	To Ans. - From Not Found
            19 => 'Call not connected', //	To Unans. - From Busy
            20 => 'Call not connected', //	To Hangup in Queue
            21 => 'Call not connected' //	To Hangup
        ];
    }

    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    public function getSource()
    {
        if (isset($this->chat->chat_type)) {

            if ($this->chat->chat_type == Chat::CHAT_TYPE_SHARE_SAFARI) {
                return 'FD';
            }
        }
        return null;
    }
}
