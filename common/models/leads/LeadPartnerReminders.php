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
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class LeadPartnerReminders extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    const NOT_IN_USE = 0;
    const HOT_LEAD = 1;
    const COLD_LEAD = -1;

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
    public static function tableName()
    {
        return 'lead_partner_reminders';
    }

    public function rules()
    {
        return [
            [['reminder_note', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['lead_category'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['lead_partner_id', 'lead_id', 'partner_id'], 'required'],
            [['lead_partner_id', 'lead_id', 'partner_id', 'lead_category', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['reminder_note'], 'string', 'max' => 500],
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
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'reminder_note' => 'Note',
            'lead_category' => 'Lead Category',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getLead()
    {
        return $this->hasOne(Lead::className(), ['id' => 'lead_id']);
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'partner_id']);
    }

    public static function getLeadcategory($lead_id, $partner_id)
    {
        $lead_reminder = self::find()
            ->where(['lead_id' => $lead_id, 'partner_id' => $partner_id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if ($lead_reminder) {
            if ($lead_reminder->lead_category == self::HOT_LEAD) {
                return '<span style="color: #ff0000; font-size: 22px; text-shadow: 0 0 8px #ff4d4d, 0 0 12px #ff1a1a;">●</span>';
            } elseif ($lead_reminder->lead_category == self::COLD_LEAD) {
                return '<span style="color: green; font-size: 22px; text-shadow: 0 0 8px rgb(14, 146, 64), 0 0 12px rgb(15, 116, 37);">●</span>';
            } else {
                return '<span style="color: grey; font-size: 22px; text-shadow: 0 0 8px rgb(102, 105, 103), 0 0 12px rgb(11, 12, 12);">●</span>';
            }
        }
        return '';
    }


    public function afterSave($insert, $changedAttributes)
    {
        $chat_model = Chat::find()->andWhere(['lead_id' => $this->lead_id])->andWhere(['chat_type' => 2])->one();

        if (!$chat_model) {
            return false;
        }

        ChatMessage::updateAll(['is_quotation_active' => 0], ['chat_id' => $chat_model->id]);
        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_model->id;
        $chat_message->message = $this->reminder_note;
        $chat_message->status = 1;
        $chat_message->sender_id = $this->partner->user_id;
        $chat_message->is_reminder = 1;
        $message = "Reminder is Set";
        if ($chat_message->save(false)) {
            $chat = Chat::find()->where(['id' => $chat_model->id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxlength($message);
            $chat->last_message_at = time();
            $chat->sender_id = $this->partner->user_id;
            $chat->is_lead_chat_open_for_user = 0;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            return $chat->save(false);
        }
        return false;
    }
}
