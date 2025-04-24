<?php

namespace api\models\chat;

use Yii;
use api\models\User;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int $chat_id
 * @property string|null $message
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ChatMessage extends \common\models\chat\ChatMessage
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_message';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['chat_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['message'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'message' => 'Message',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }


    public function getCreateduser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
