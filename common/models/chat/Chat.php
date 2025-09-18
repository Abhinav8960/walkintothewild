<?php

namespace common\models\chat;

use common\models\leads\Lead;
use common\models\leads\LeadPartners;
use Yii;
use common\models\User;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $user_id
 * @property int $recipient_user_id
 * @property int|null $status
 * @property int|null $chat_type
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class Chat extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    const CHAT_TYPE_DIRECT = 1;
    const CHAT_TYPE_QUOTE = 2;
    const CHAT_TYPE_SHARE_SAFARI = 3;

    const OBJECTIVE_DIRECT = "direct_chat";
    const OBJECTIVE_QUOTE = "quote_chat";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

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
    public function rules()
    {
        return [
            [['user_id', 'recipient_user_id'], 'required'],
            [['user_id', 'lead_id', 'recipient_user_id', 'status', 'chat_type', 'last_message_at', 'is_seen', 'is_quote_accept', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_call_request', 'sender_id', 'is_lead_chat_open_for_user', 'is_closed','share_safari_id'], 'integer'],
            [['share_safari_id'],'safe'],
            ['last_message', 'string', 'max' => 500],
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
            'recipient_user_id' => 'Recipient User ID',
            'status' => 'Status',
            'chat_type' => 'Chat Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function generateChatHash()
    {
        $this->chat_hash = Yii::$app->security->generateRandomString(6) . time() . Yii::$app->security->generateRandomString(5);
    }

    public function getChatmessages()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_user_id']);
    }

    public function getParkoperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'recipient_user_id']);
    }

    public function getPackageoperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'recipient_user_id']);
    }

    public static function markChatStarted($chat_model, $partner_id)
    {
        if ($chat_model) {
            $lead_partner_model = LeadPartners::find()->where(['lead_id' => $chat_model->lead_id, 'partner_id' => $partner_id, 'is_chat_started' => 0])->limit(1)->one();
            if ($lead_partner_model) {
                $lead_partner_model->is_chat_started = 1;
                $lead_partner_model->save(false);
            }
            $lead_model = Lead::find()->where(['id' => $chat_model->lead_id, 'is_chat_started' => 0])->limit(1)->one();
            if ($lead_model) {
                $lead_model->is_chat_started = 1;
                $lead_model->save(false);
            }
        }
        return true;
    }

    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         // Check if the 'call' attribute is not set and set it to null
    //         if ($insert && empty($this->call_id)) {
    //             $this->call_id = null;
    //         }
    //         if ($insert && empty($this->is_call_request)) {
    //             $this->is_call_request = null;
    //         }

    //         return true;
    //     }
    //     return false;
    // }

    public function callpossible()
    {
        if ($this->chat_type == 2) {

            if (!empty($this->user->mobile_no) && $this->user->is_mobile_no_verified == true && $this->operator->is_phone_no_verified == true && !empty($this->operator->phone_no)) {
                return true;
            }
        }
        return false;
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['user_id' => 'recipient_user_id']);
    }

    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    public function getDisplayLabelUser()
    {
        $user = User::find()->where(['id'=>$this->user_id])->one();
        $userName = $user ? $user->name : '';
        $userOperator = SafariOperator::find()->where(['user_id' => $user->id])->one();
        if ($userOperator) {
            $userName = $userOperator->business_name .' | (Operator)';
        }
        return $userName ;
    }

    public function getDisplayLabelRecipient()
    {
        $recipient = User::find()->where(['id'=>$this->recipient_user_id])->one();
        $recipientName = $recipient ? $recipient->name : '';
        $recipientOperator = SafariOperator::find()->where(['user_id' =>$recipient->id])->one();
        if ($recipientOperator) {
            $recipientName = $recipientOperator->business_name .' | (Operator)';
        }
        return $recipientName ;
    }

    public function getFixedDeparture()
    {
        return $this->hasOne(ShareSafari::class, ['id' => 'share_safari_id']);
    }

    public function getLead()
    {
        return $this->hasOne(Lead::class, ['id' => 'lead_id']);
    }
}
