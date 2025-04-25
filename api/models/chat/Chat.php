<?php

namespace api\models\chat;

use Yii;
use api\models\User;
use api\models\operator\SafariOperator;
use api\models\park\SafariPark;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $user_id
 * @property int $recipient_user_id
 * @property int|null $status
 * @property int|null $chat_type
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class Chat extends \common\models\chat\Chat
{

    public function fields()
    {




        $fields = [
            'id',
            'chat_hash',
            // 'recipient_user_id',
            'last_message',
            'last_message_datetime',
            // 'chat_type',
            // 'park_id',
            // 'package_id',
            // 'quote_id',

            // 'is_quote_accept',
            // 'quote_price',
            // 'quote_price_max',
            // 'quote_more_detail',
            'is_seen' => function () {
                return (bool)$this->is_seen;
            },
            'contact',
            'status' => function () {
                return (bool)$this->status;
            },
            // 'sender',
            // 'recipient',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by'
        ];
        return $fields;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
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
            [['user_id', 'recipient_user_id'], 'required'],
            [['user_id', 'recipient_user_id', 'status', 'chat_type', 'last_message_at', 'is_seen', 'is_quote_accept', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            ['last_message', 'string', 'max' => 500],
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
            'recipient_user_id' => 'Recipient User ID',
            'status' => 'Status',
            'chat_type' => 'Chat Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function generateChatHash()
    {
        $this->chat_hash = Yii::$app->security->generateRandomString(6) . time() . Yii::$app->security->generateRandomString(5);
    }

    public function getChatmessages()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_id' => 'id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_user_id']);
    }

    public function getParkoperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'recipient_user_id']);
    }

    public function getPackageoperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'recipient_user_id']);
    }

    public function getContact()
    {
        if ($this->user_id == \Yii::$app->params['active_user_id']) {
            return $this->hasOne(User::className(), ['id' => 'recipient_user_id']);
        }
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLast_message_datetime()
    {
        if ($this->last_message_at) {
            return date('Y-m-d H:i:s', $this->last_message_at);
        }
        return null;
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }
}
