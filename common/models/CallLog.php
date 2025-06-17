<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call_log".
 *
 * @property int $id
 * @property string $reference_id
 * @property string|null $unique_id
 * @property int $chat_id
 * @property int|null $lead_id
 * @property string $request_vnm
 * @property string|null $request_caller_1_no
 * @property int|null $request_caller_1_user_id
 * @property string|null $request_caller_2_no
 * @property int|null $request_caller_2_user_id
 * @property string|null $caller_id
 * @property string|null $received_id
 * @property string|null $ivr_number
 * @property string|null $recording_url
 * @property string|null $rec_duration
 * @property string|null $call_type
 * @property string|null $call_status
 * @property string|null $datetime
 * @property string|null $duration
 * @property int|null $operator_user_id
 * @property string|null $file_path
 * @property int|null $call_initiated_user_id
 * @property string|null $call_request_status
 * @property string|null $call_request_message
 * @property int $status 0=>Failed,1=>Success
 * @property int $is_detail_fetched
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CallLog extends \common\models\trierror\ActiveLogRecord implements \common\interfaces\StatusInterface
{

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
            [['unique_id', 'lead_id', 'request_caller_1_no', 'request_caller_1_user_id', 'request_caller_2_no', 'request_caller_2_user_id', 'caller_id', 'received_id', 'ivr_number', 'recording_url', 'rec_duration', 'call_type', 'call_status', 'datetime', 'duration', 'operator_user_id', 'file_path', 'call_initiated_user_id', 'call_initiated_partner_id', 'call_request_status', 'call_request_message', 'created_at', 'updated_at', 'dial_status'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['reference_id', 'chat_id', 'request_vnm'], 'required'],
            [['chat_id', 'lead_id', 'request_caller_1_user_id', 'request_caller_2_user_id', 'operator_user_id', 'call_initiated_partner_id', 'call_initiated_user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['reference_id', 'caller_id', 'received_id', 'ivr_number', 'rec_duration'], 'string', 'max' => 50],
            [['unique_id', 'request_vnm', 'datetime', 'duration', 'dial_status'], 'string', 'max' => 100],
            [['request_caller_1_no', 'request_caller_2_no'], 'string', 'max' => 20],
            [['recording_url', 'call_type', 'call_status', 'file_path', 'call_request_status', 'call_request_message'], 'string', 'max' => 255],
            [['reference_id'], 'unique'],
            [['unique_id'], 'unique'],
            [['is_detail_fetched'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference_id' => 'Reference ID',
            'unique_id' => 'Unique ID',
            'chat_id' => 'Chat ID',
            'lead_id' => 'Lead ID',
            'request_vnm' => 'Request Vnm',
            'request_caller_1_no' => 'Request Caller 1 No',
            'request_caller_1_user_id' => 'Request Caller 1 User ID',
            'request_caller_2_no' => 'Request Caller 2 No',
            'request_caller_2_user_id' => 'Request Caller 2 User ID',
            'caller_id' => 'Caller ID',
            'received_id' => 'Received ID',
            'ivr_number' => 'Ivr Number',
            'recording_url' => 'Recording Url',
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
            'is_detail_fetched' => 'Is Detail Fetched',
            'status' => 'Status',
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
        return $this->hasOne(User::className(), ['id' => 'call_initiated_partner_id']);
    }
}
