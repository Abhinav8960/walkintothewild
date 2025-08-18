<?php

namespace common\models\whatsapp;

use Yii;

/**
 * This is the model class for table "whatsapp_messages".
 *
 * @property int $id
 * @property string $wamid WhatsApp Message ID
 * @property int $contact_id
 * @property string $direction
 * @property string $message_type
 * @property string|null $content
 * @property string|null $media_url
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property WhatsappContacts $contact
 */
class WhatsappMessages extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const DIRECTION_INBOUND = 'inbound';
    const DIRECTION_OUTBOUND = 'outbound';
    const MESSAGE_TYPE_TEXT = 'text';
    const MESSAGE_TYPE_IMAGE = 'image';
    const MESSAGE_TYPE_VIDEO = 'video';
    const MESSAGE_TYPE_DOCUMENT = 'document';
    const MESSAGE_TYPE_AUDIO = 'audio';
    const MESSAGE_TYPE_LOCATION = 'location';
    const MESSAGE_TYPE_TEMPLATE = 'template';
    const STATUS_SENT = 'sent';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_READ = 'read';
    const STATUS_FAILED = 'failed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'whatsapp_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'media_url'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'sent'],
            [['conversation_id', 'contact_id'], 'integer'],
            [['wamid', 'conversation_id', 'contact_id', 'direction', 'message_type'], 'required'],
            [['direction', 'message_type', 'content', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['wamid'], 'string', 'max' => 100],
            [['media_url'], 'string', 'max' => 255],
            ['direction', 'in', 'range' => array_keys(self::optsDirection())],
            ['message_type', 'in', 'range' => array_keys(self::optsMessageType())],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['wamid'], 'unique'],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => WhatsappContacts::class, 'targetAttribute' => ['contact_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wamid' => 'Wamid',
            'conversation_id' => 'Conversation ID',
            'contact_id' => 'Contact ID',
            'direction' => 'Direction',
            'message_type' => 'Message Type',
            'content' => 'Content',
            'media_url' => 'Media Url',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Contact]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(WhatsappContacts::class, ['id' => 'contact_id']);
    }


    /**
     * column direction ENUM value labels
     * @return string[]
     */
    public static function optsDirection()
    {
        return [
            self::DIRECTION_INBOUND => 'inbound',
            self::DIRECTION_OUTBOUND => 'outbound',
        ];
    }

    /**
     * column message_type ENUM value labels
     * @return string[]
     */
    public static function optsMessageType()
    {
        return [
            self::MESSAGE_TYPE_TEXT => 'text',
            self::MESSAGE_TYPE_IMAGE => 'image',
            self::MESSAGE_TYPE_VIDEO => 'video',
            self::MESSAGE_TYPE_DOCUMENT => 'document',
            self::MESSAGE_TYPE_AUDIO => 'audio',
            self::MESSAGE_TYPE_LOCATION => 'location',
            self::MESSAGE_TYPE_TEMPLATE => 'template',
        ];
    }

    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_SENT => 'sent',
            self::STATUS_DELIVERED => 'delivered',
            self::STATUS_READ => 'read',
            self::STATUS_FAILED => 'failed',
        ];
    }

    /**
     * @return string
     */
    public function displayDirection()
    {
        return self::optsDirection()[$this->direction];
    }

    /**
     * @return bool
     */
    public function isDirectionInbound()
    {
        return $this->direction === self::DIRECTION_INBOUND;
    }

    public function setDirectionToInbound()
    {
        $this->direction = self::DIRECTION_INBOUND;
    }

    /**
     * @return bool
     */
    public function isDirectionOutbound()
    {
        return $this->direction === self::DIRECTION_OUTBOUND;
    }

    public function setDirectionToOutbound()
    {
        $this->direction = self::DIRECTION_OUTBOUND;
    }

    /**
     * @return string
     */
    public function displayMessageType()
    {
        return self::optsMessageType()[$this->message_type];
    }

    /**
     * @return bool
     */
    public function isMessageTypeText()
    {
        return $this->message_type === self::MESSAGE_TYPE_TEXT;
    }

    public function setMessageTypeToText()
    {
        $this->message_type = self::MESSAGE_TYPE_TEXT;
    }

    /**
     * @return bool
     */
    public function isMessageTypeImage()
    {
        return $this->message_type === self::MESSAGE_TYPE_IMAGE;
    }

    public function setMessageTypeToImage()
    {
        $this->message_type = self::MESSAGE_TYPE_IMAGE;
    }

    /**
     * @return bool
     */
    public function isMessageTypeVideo()
    {
        return $this->message_type === self::MESSAGE_TYPE_VIDEO;
    }

    public function setMessageTypeToVideo()
    {
        $this->message_type = self::MESSAGE_TYPE_VIDEO;
    }

    /**
     * @return bool
     */
    public function isMessageTypeDocument()
    {
        return $this->message_type === self::MESSAGE_TYPE_DOCUMENT;
    }

    public function setMessageTypeToDocument()
    {
        $this->message_type = self::MESSAGE_TYPE_DOCUMENT;
    }

    /**
     * @return bool
     */
    public function isMessageTypeAudio()
    {
        return $this->message_type === self::MESSAGE_TYPE_AUDIO;
    }

    public function setMessageTypeToAudio()
    {
        $this->message_type = self::MESSAGE_TYPE_AUDIO;
    }

    /**
     * @return bool
     */
    public function isMessageTypeLocation()
    {
        return $this->message_type === self::MESSAGE_TYPE_LOCATION;
    }

    public function setMessageTypeToLocation()
    {
        $this->message_type = self::MESSAGE_TYPE_LOCATION;
    }

    /**
     * @return bool
     */
    public function isMessageTypeTemplate()
    {
        return $this->message_type === self::MESSAGE_TYPE_TEMPLATE;
    }

    public function setMessageTypeToTemplate()
    {
        $this->message_type = self::MESSAGE_TYPE_TEMPLATE;
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusSent()
    {
        return $this->status === self::STATUS_SENT;
    }

    public function setStatusToSent()
    {
        $this->status = self::STATUS_SENT;
    }

    /**
     * @return bool
     */
    public function isStatusDelivered()
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function setStatusToDelivered()
    {
        $this->status = self::STATUS_DELIVERED;
    }

    /**
     * @return bool
     */
    public function isStatusRead()
    {
        return $this->status === self::STATUS_READ;
    }

    public function setStatusToRead()
    {
        $this->status = self::STATUS_READ;
    }

    /**
     * @return bool
     */
    public function isStatusFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function setStatusToFailed()
    {
        $this->status = self::STATUS_FAILED;
    }
}