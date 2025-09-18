<?php

namespace common\models\leads;

use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\operator\SafariOperator;
use Yii;


/**
 * This is the model class for table "lead_partners".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $partner_id safari_operator
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class LeadPartners extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    const NOT_IN_USE = 0;
    const HOT_LEAD = 1;
    const COLD_LEAD = -1;

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_partners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['transaction_datetime', 'payment_gateway'], 'safe'],
            [['lead_id', 'partner_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['lead_id', 'partner_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'is_payment_received', 'transaction_id'], 'integer'],
            [['lead_id', 'partner_id'], 'unique', 'targetAttribute' => ['lead_id', 'partner_id']],
            [['lead_category'],'integer'],
            [['reminder_note', 'reminder_datetime'], 'default', 'value' => null],
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
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'partner_id']);
    }

    // public function getReminders()
    // {
    //     return $this->hasMany(LeadPartnerReminders::class, ['lead_id' => 'id']);
    // }

    // public function getLatestReminder()
    // {
    //     return $this->hasOne(LeadPartnerReminders::class, ['lead_id' => 'lead_id'])
    //         ->orderBy(['id' => SORT_DESC]);
    // }

    public static function getLeadcategory($lead_id, $partner_id)
    {
        $lead_reminder = self::find()->where(['lead_id' => $lead_id, 'partner_id' => $partner_id])->orderBy(['id' => SORT_DESC])->one();
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

    public static function reminderHistory($model)
    {
        $reminder = new LeadPartnerReminders();
        $reminder->lead_partner_id = $model->id;
        $reminder->reminder_note = $model->reminder_note;
        $reminder->reminder_datetime = $model->reminder_datetime;
        $reminder->save(false);
    }

    public static function preparechatmessage($model,$id)
    {
        $chat_model = Chat::find()->Where(['lead_id' => $id])->andwhere(['or', ['user_id' => \Yii::$app->user->identity->id], ['recipient_user_id' => \Yii::$app->user->identity->id]])->andWhere(['chat_type' => 2])->one(); 
       
        if (!$chat_model) {
            return false;
        }
        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_model->id;
        $chat_message->reminder_note = $model->reminder_note;
        $chat_message->reminder_datetime = $model->reminder_datetime;
        $chat_message->status = 1;
        $chat_message->sender_id = $model->partner->user_id;
        $chat_message->is_reminder = 1;
        $chat_message->save(false);
        return false;
    }
    
}
