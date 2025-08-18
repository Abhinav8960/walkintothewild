<?php

namespace common\models\chat;

use Yii;

/**
 * This is the model class for table "chat_message_history".
 *
 * @property int $id
 * @property int $chat_message_id
 * @property int $chat_id
 * @property string|null $message
 * @property int $is_quotation_message
 * @property int|null $quotation_id
 * @property int $is_quotation_active
 * @property int $is_call_message
 * @property int|null $call_id
 * @property int $is_call_request
 * @property string|null $data
 * @property string|null $gallery
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class ChatMessageHistory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_message_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'quotation_id', 'call_id', 'data', 'gallery', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['is_call_request'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['id', 'chat_message_id', 'chat_id'], 'required'],
            [['id', 'chat_message_id', 'chat_id', 'is_quotation_message', 'quotation_id', 'is_quotation_active', 'is_call_message', 'call_id', 'is_call_request', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['message', 'data', 'gallery'], 'string'],
            [['id'], 'unique'],
            [['transaction_id'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_message_id' => 'Chat Message ID',
            'chat_id' => 'Chat ID',
            'message' => 'Message',
            'is_quotation_message' => 'Is Quotation Message',
            'quotation_id' => 'Quotation ID',
            'is_quotation_active' => 'Is Quotation Active',
            'is_call_message' => 'Is Call Message',
            'call_id' => 'Call ID',
            'is_call_request' => 'Is Call Request',
            'data' => 'Data',
            'gallery' => 'Gallery',
            'transaction_id' => 'Transaction ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
