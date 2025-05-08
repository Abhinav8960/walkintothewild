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
    public function fields()
    {
        $fields = [
            'id',
            'message',
            'message_datetime' => function () {
                return strtotime($this->message_datetime);
            },
            // 'recipient_user_id',           
            'sender',
            'additional_data ' => function () {
                return json_decode($this->data);
            },
        ];
        return $fields;
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

    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    public function getMessage_datetime()
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }

    public function getSender()
    {

        $data['name'] = $this->createduser->name;
        $data['user_handle'] = $this->createduser->user_handle;
        $data['profile_image'] = $this->createduser->profile_image;
        $data['is_safari_operator'] = $this->createduser->is_safari_operator;
        $data['display_name'] = $this->createduser->display_name;
        return $data;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // return  new \common\events\chat\NewChatMessageSend([$this->reciverId], $this->createduser->name, $this->message, $this->chat->chat_hash, $this->data);
        return  new \common\events\chat\NewChatMessageSend([748], $this->createduser->name, $this->message, $this->chat->chat_hash, $this->data);
    }

    public function getReciverId()
    {
        return $this->chat->user_id == $this->created_by ? $this->recipient_user_id : $this->created_by;
    }
}
