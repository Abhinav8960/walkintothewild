<?php

namespace common\models\firebasenotification;

use common\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "firebase_notification_log".
 *
 * @property int $id
 * @property string $type
 * @property string|null $title
 * @property string|null $message
 * @property string|null $sent_data
 * @property string|null $image_url
 * @property string $firebase_token
 * @property string|null $response
 * @property string $action
 * @property int $status
 * @property int|null $created_by
 * @property int $created_at
 */
class FirebaseNotificationLog extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'firebase_notification_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'master_notification_template_id'], 'required'],
            [['message', 'action'], 'string'],
            [['sent_data','send_datetime'], 'safe'],
            [['status', 'is_send', 'created_by', 'created_at', 'is_cron_run'], 'integer'],
            [['image_url', 'action'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'message' => 'Message',
            'sent_data' => 'Sent Data',
            'image_url' => 'Image Url',
            'action' => 'Action',
            'is_cron_run' => 'Cron Run',
            'status' => 'Status',
            'send_datetime' => 'Send Date Time',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ],
            ],

        ];
    }

    public static function setActivity($master_notification_template_id, $title = NULL, $message = NULL, $user_ids = [], $sent_data = NULL, $image_url = NULL, $action = NULL)
    {

        foreach ($user_ids as $user_id) {
            $model = new self();
            $model->master_notification_template_id = $master_notification_template_id;
            $model->title = ($title !== null) ? $title :  NULL;
            $model->message = ($message !== null) ? trim($message) : NULL;
            $model->sent_data = ($sent_data !== null) ? $sent_data :  NULL;
            $model->image_url = ($image_url !== null) ? $image_url :  NULL;
            $model->action = ($action !== null) ? $action : NULL;
            $model->user_id = $user_id;
            $model->is_send = 0;
            $model->is_cron_run = 0;
            $model->status = 1;
            $model->created_by = (int)self::getUserID();
            $model->save(false);
        }
        return true;
    }
    /**
     * Get user ID
     *
     * @return int|null user id or null (0) if user guest
     */
    public static function getUserID()
    {
        if (!Yii::$app->request->isConsoleRequest) {
            $user = Yii::$app->user->identity;
            return $user && !(Yii::$app->user->isGuest) ? intval($user->id) : null;
        } else {
            return 0;
        }
    }


    /**
     * @return object of \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        if (class_exists('\common\models\Users')) {
            return $this->hasOne(\common\models\User::class, ['id' => 'created_by']);
        } else {
            return $this->created_by;
        }
    }


    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }


    public function getUser()
    {
        return $this->hasOne(User::classname(), ['id' => 'created_by']);
    }
}
