<?php

namespace api\models;

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
class CallLog extends \common\models\CallLog
{

    public function fields()
    {




        $fields = [
            'id',
            // 'reference_id',
            // 'unique_id',
            // 'chat_id',
            // 'lead_id',
            // 'request_vnm',
            // 'request_caller_1_no',
            // 'request_caller_1_user_id',
            // 'request_caller_2_no',
            // 'request_caller_2_user_id',
            // 'caller_id',
            // 'received_id',
            // 'ivr_number',
            // 'recording_url',
            'rec_duration',
            'call_type',
            'call_status',
            'call_status_label' => function () {
                return $this->getCallstatuslabel();
            },
            'datetime' => function () {
                return strtotime($this->datetime);
            },
            'duration',
            // 'operator_user_id',
            // 'file_path',
            // 'call_initiated_user_id',
            'call_request_status',
            'call_request_message',
            'call_recording_url' => function () {
                return !empty($this->file_path) ? Yii::$app->params['s3_endpoint'] . '/' . $this->file_path : $this->recording_url;
            },
            // Status is an integer, but we can return it as a boolean if needed
            // 'status' => function () {
            //     return (bool)$this->status;
            // },
            // Is detail fetched is an integer, but we can return it as a boolean if needed
            // 'is_detail_fetched' => function () {
            //     return (bool)$this->is_detail_fetched;
            // },
        ];

        return $fields;
    }

    public function getCallstatuslabel()
    {
        $callStatusLabels = [
            'ANSWERED' => 'Call Connetced',
            'NOANSWER' => 'Call not connected',
            'BUSY' => 'Busy',
        ];
        if ($this->call_request_status == "success") {

            return isset($callStatusLabels[$this->dial_status]) ? $callStatusLabels[$this->dial_status] : 'Call Initiated';
        }
        return 'Call Initiated, But call not connected';
    }
}
