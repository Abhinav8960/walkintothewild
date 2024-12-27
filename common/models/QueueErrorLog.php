<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "queue_error_log".
 *
 * @property int $id
 * @property string $channel
 * @property resource $job
 * @property int $pushed_at
 * @property int $ttr
 * @property int $delay
 * @property int $priority
 * @property int|null $reserved_at
 * @property int|null $attempt
 * @property int|null $done_at
 */
class QueueErrorLog extends \yii\db\ActiveRecord
{
     /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue_error_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_id', 'error_message','stack_trace'], 'required'],
            [['job_id'], 'integer'],
            [['error_message','stack_trace'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'error_message' => 'Error Message',
            'stack_trace' => 'Stack Trace',
        ];
    }
}
