<?php

namespace common\models\whatsapp;

use Yii;

/**
 * This is the model class for table "whatsapp_contacts".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $partner_id
 * @property string $name
 * @property string $phone_number
 * @property string|null $profile_pic_url
 * @property string $chat_status
 * @property int|null $status
 * @property string|null $last_message_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property WhatsappMessages[] $whatsappMessages
 */
class WhatsappContacts extends \yii\db\ActiveRecord
{
    const CHAT_STATUS_ACTIVE = 'active';
    const CHAT_STATUS_ARCHIVED = 'archived';
    const CHAT_STATUS_CLOSED = 'closed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'whatsapp_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'partner_id', 'profile_pic_url'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['chat_status'], 'default', 'value' => self::CHAT_STATUS_ACTIVE],
            [['user_id', 'partner_id', 'status'], 'integer'],
            [['name', 'phone_number'], 'required'],
            [['created_at', 'updated_at', 'last_message_at'], 'safe'],
            [['name', 'profile_pic_url'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 20],
            [['phone_number'], 'unique'],
            ['chat_status', 'in', 'range' => [
                self::CHAT_STATUS_ACTIVE,
                self::CHAT_STATUS_ARCHIVED,
                self::CHAT_STATUS_CLOSED
            ]],
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
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'profile_pic_url' => 'Profile Pic Url',
            'chat_status' => 'Chat Status',
            'status' => 'Status',
            'last_message_at' => 'Last Message At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[WhatsappMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWhatsappMessages()
    {
        return $this->hasMany(WhatsappMessages::class, ['contact_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Gets the last message for this contact
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLastMessage()
    {
        return $this->hasOne(WhatsappMessages::class, ['contact_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Get chat status options
     *
     * @return array
     */
    public static function getChatStatusOptions()
    {
        return [
            self::CHAT_STATUS_ACTIVE => 'Active',
            self::CHAT_STATUS_ARCHIVED => 'Archived',
            self::CHAT_STATUS_CLOSED => 'Closed',
        ];
    }

}