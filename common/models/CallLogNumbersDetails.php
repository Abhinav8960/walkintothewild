<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call_log_numbers_details".
 *
 * @property int $id
 * @property int $call_log_id
 * @property string $ctc
 * @property string $status
 * @property string $ping
 * @property string $number
 * @property int $visit_id
 * @property string $node_id
 * @property int $total_ring_duration
 * @property int $total_hold_duration
 * @property int|null $talk_duration
 * @property string|null $talk_s_time
 * @property string|null $talk_e_time
 * @property int|null $answer_s_time
 * @property int|null $answer_e_time
 * @property int|null $answer_duration
 * @property string $cli
 * @property int $retry
 * @property string|null $recording_url
 * @property int $created_at
 * @property int $created_updated
 */
class CallLogNumbersDetails extends \common\models\trierror\ActiveLogRecord implements \common\interfaces\NewStatusInterface
{

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
        return 'call_log_numbers_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talk_duration', 'talk_s_time', 'talk_e_time', 'answer_s_time', 'answer_e_time', 'answer_duration', 'recording_url'], 'default', 'value' => null],
            [['call_log_id', 'ctc', 'status', 'ping', 'number', 'visit_id', 'node_id', 'total_ring_duration', 'total_hold_duration', 'cli', 'retry', 'created_at', 'created_updated'], 'required'],
            [['call_log_id', 'visit_id', 'total_ring_duration', 'total_hold_duration', 'talk_duration', 'answer_s_time', 'answer_e_time', 'answer_duration', 'retry', 'created_at', 'created_updated'], 'integer'],
            [['talk_s_time', 'talk_e_time'], 'safe'],
            [['ctc', 'status', 'ping', 'number', 'node_id', 'cli', 'recording_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'call_log_id' => 'Call Log ID',
            'ctc' => 'Ctc',
            'status' => 'Status',
            'ping' => 'Ping',
            'number' => 'Number',
            'visit_id' => 'Visit ID',
            'node_id' => 'Node ID',
            'total_ring_duration' => 'Total Ring Duration',
            'total_hold_duration' => 'Total Hold Duration',
            'talk_duration' => 'Talk Duration',
            'talk_s_time' => 'Talk S Time',
            'talk_e_time' => 'Talk E Time',
            'answer_s_time' => 'Answer S Time',
            'answer_e_time' => 'Answer E Time',
            'answer_duration' => 'Answer Duration',
            'cli' => 'Cli',
            'retry' => 'Retry',
            'recording_url' => 'Recording Url',
            'created_at' => 'Created At',
            'created_updated' => 'Created Updated',
        ];
    }
}
