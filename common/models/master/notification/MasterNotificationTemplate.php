<?php

namespace common\models\master\notification;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_notification_template".
 *
 * @property int $id
 * @property string $message
 * @property int $status
 */
class MasterNotificationTemplate extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;

    const NEW_USER_REGISTRATION_TEMPLATE = 1;
    const CHAT_MESSAGE_RECEIVED_REGISTRATION_TEMPLATE = 1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_notification_template';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
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
    public function rules()
    {
        return [
            [['id', 'message','title'], 'required'],
            [['id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['message'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_b' => 'Updated B',
        ];
    }
}