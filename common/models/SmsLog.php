<?php

namespace common\models;

use common\models\master\smstemplate\MasterSmsTemplate;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "sms_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $template_id
 * @property string|null $params
 * @property int $sms_send_time
 * @property int $service_id
 * @property int $is_cron_run
 * @property int $is_ok
 * @property int $is_deliver
 * @property string|null $report_status
 * @property string|null $report_status_datetime
 * @property int|null $response_code
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int|null $updated_by
 */
class SmsLog extends \common\models\trierror\ActiveLogRecord implements \common\interfaces\StatusInterface
{

    const STATUS_PENDING = 0;
    const STATUS_SENT = 1;
    const STATUS_DELIVERD = 2;
    const STATUS_FAILED = 3;
    use CommanRelationship;
     /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            // \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['params', 'updated_by', 'report_status', 'report_status_datetime', 'message_id', 'response_code'], 'default', 'value' => null],
            [['is_deliver'], 'default', 'value' => 0],
            [['user_id', 'template_id', 'sms_send_time', 'service_id', 'status'], 'required'],
            [['user_id', 'sms_send_time', 'service_id', 'is_cron_run', 'is_ok', 'is_deliver', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by','response_code'], 'integer'],
            [['params'], 'string'],
            [['template_id', 'message_id'], 'string', 'max' => 255],
            [['report_status'], 'string', 'max' => 100],

        ];
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'template_id' => 'Template ID',
            'params' => 'Params',
            'sms_send_time' => 'Sms Send Time',
            'service_id' => 'Service ID',
            'is_cron_run' => 'Is Cron Run',
            'is_ok' => 'Is Ok',
            'is_deliver' => 'Is Deliver',
            'message_id' => 'Message ID',
            'response_code' => 'Response Code',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getTemplate()
    {
        return $this->hasOne(MasterSmsTemplate::className(), ['template_id' => 'template_id']);
    }
}
