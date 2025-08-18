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
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property WhatsappConversations[] $whatsappConversations
 * @property WhatsappMessages[] $whatsappMessages
 */
class WhatsappContacts extends \yii\db\ActiveRecord
{


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
            [['user_id', 'partner_id', 'status'], 'integer'],
            [['name', 'phone_number'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'profile_pic_url'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 20],
            [['phone_number'], 'unique'],
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[WhatsappConversations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWhatsappConversations()
    {
        return $this->hasMany(WhatsappConversations::class, ['contact_id' => 'id']);
    }

    /**
     * Gets query for [[WhatsappMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWhatsappMessages()
    {
        return $this->hasMany(WhatsappMessages::class, ['contact_id' => 'id']);
    }

}