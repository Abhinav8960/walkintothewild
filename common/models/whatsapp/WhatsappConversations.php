<?php

namespace common\models\whatsapp;

use Yii;

/**
 * This is the model class for table "whatsapp_conversations".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $partner_id
 * @property int $contact_id
 * @property string $status
 * @property string|null $last_message_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property WhatsappContacts $contact
 */
class WhatsappConversations extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_ARCHIVED = 'archived';
    const STATUS_CLOSED = 'closed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'whatsapp_conversations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'partner_id', 'last_message_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'active'],
            [['user_id', 'partner_id', 'contact_id'], 'integer'],
            [['contact_id'], 'required'],
            [['status'], 'string'],
            [['last_message_at', 'created_at', 'updated_at'], 'safe'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
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
            'user_id' => 'User ID',
            'partner_id' => 'Partner ID',
            'contact_id' => 'Contact ID',
            'status' => 'Status',
            'last_message_at' => 'Last Message At',
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
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_ACTIVE => 'active',
            self::STATUS_ARCHIVED => 'archived',
            self::STATUS_CLOSED => 'closed',
        ];
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
    public function isStatusActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setStatusToActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isStatusArchived()
    {
        return $this->status === self::STATUS_ARCHIVED;
    }

    public function setStatusToArchived()
    {
        $this->status = self::STATUS_ARCHIVED;
    }

    /**
     * @return bool
     */
    public function isStatusClosed()
    {
        return $this->status === self::STATUS_CLOSED;
    }

    public function setStatusToClosed()
    {
        $this->status = self::STATUS_CLOSED;
    }
}