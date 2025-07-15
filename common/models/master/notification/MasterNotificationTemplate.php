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
    const SAFARI_JOIN_TEMPLATE = 1;
    const SAFARI_NEW_COMMENT = 3;
    const FOLLOW_OPERATOR = 4;
    const CHAT_MESSAGE_RECEIVED_REGISTRATION_TEMPLATE = 8;
    const SAFARI_UNJOIN_TEMPLATE = 9;
    const UNFOLLOW_OPERATOR = 10;
    const PACKAGE_QUOTATION_RECEIVED = 11;
    const PARTNER_QUOTATION_RECEIVED = 12;
    const NEW_SAFARI_CREATED = 13;
    const SAFARI_UPDATED = 14;
    const FIXED_DEPARTURE_CREATED = 15;
    const FIXED_DEPARTURE_UPDATED = 16;
    const PACKAGE_CREATED = 17;
    const PACKAGE_UPDATED = 18;
    const NEW_POST = 19;
    const NEW_SIGHTING = 20;




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
            [['id', 'module_type', 'message', 'title'], 'required'],
            [['id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['message', 'module_type', 'type'], 'string'],
            [['type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_type' => 'Module Type',
            'title' => 'Title',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_b' => 'Updated B',
        ];
    }

    public static function prepareSendData($title, $body, $additional_data = [])
    {
        $arr =  [
            'title' => $title,
            'body' => $body,
        ];

        if (count($additional_data) > 0) {
            foreach ($additional_data as $key => $value) {
                $arr[$key] = $value;
            }
        }

        return $arr;
    }
}
