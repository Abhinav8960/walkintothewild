<?php

namespace common\models\leads;

use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\operator\SafariOperator;
use Yii;

/**
 * This is the model class for table "lead_partner_quotes".
 *
 * @property int $id
 * @property int $lead_partner_id
 * @property int $lead_id
 * @property int $partner_id
 * @property string|null $reminder_note
 * @property int|null $lead_category
 * @property int|null $status
 * @property int|null $created_by
 */
class LeadPartnerReminders extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
   

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false, // disable updated_at
            ],
            [
                'class' => \yii\behaviors\BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false, // disable updated_by
            ],
        ];
    }
    

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_partner_reminders';
    }

    public function rules()
    {
        return [
            [['reminder_note', 'reminder_datetime', 'created_at', 'created_by'], 'default', 'value' => null],
            [['lead_partner_id'], 'required'],
            [['lead_partner_id', 'created_at', 'created_by'], 'integer'],
            [['reminder_note'], 'string'],
            [['reminder_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_partner_id' => 'Lead Partner ID',
            'reminder_note' => 'Note',
            'reminder_datetime' => 'Reminder Datetime',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
