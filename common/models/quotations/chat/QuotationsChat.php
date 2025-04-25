<?php

namespace common\models\quotations\chat;

use Yii;

/**
 * This is the model class for table "quotations_chat".
 *
 * @property int $id
 * @property int $quotations_id
 * @property string $message
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $sent_at
 * @property string $read_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $attachment
 * @property int $status
 */
class QuotationsChat extends \yii\db\ActiveRecord
{

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
    public static function tableName()
    {
        return 'quotations_chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attachment'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['quotations_id', 'message', 'sender_id', 'receiver_id', 'sent_at'], 'required'],
            [['quotations_id', 'sender_id', 'receiver_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['message'], 'string'],
            [['sent_at', 'read_at','created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['attachment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotations_id' => 'Quotations ID',
            'message' => 'Message',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'sent_at' => 'Sent At',
            'read_at' => 'Read At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'attachment' => 'Attachment',
            'status' => 'Status',
        ];
    }

}