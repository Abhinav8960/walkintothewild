<?php

namespace common\models\chat;

use api\models\leads\LeadPartnerQuotes;
use Yii;
use common\models\User;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int $chat_id
 * @property string|null $message
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    public $sender_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_message';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => function () {
                    return $this->getActiveUserId();
                },
            ],
        ];
    }

    /**
     * Get the active user ID from application parameters.
     *
     * @return int|null
     */
    protected function getActiveUserId()
    {
        if (!empty($this->sender_id)) {
            return $this->sender_id;
        }
        return \Yii::$app->user->id ?? \Yii::$app->params['active_user_id'];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['chat_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'is_call_request'], 'integer'],
            [['gallery'], 'string', 'max' => 512],
            [['message'], 'string'],
            [['sender_id','transaction_id'], 'safe'],
            [['transaction_id'], 'safe'],
            [['gallery'], 'safe'],
            [['is_call_message', 'is_quotation_message', 'is_quotation_active', 'is_edited', 'is_system_generated'], 'boolean'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'message' => 'Message',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }


    public function getCreateduser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    // public function afterSave($insert, $changedAttributes)
    // {
    //     parent::afterSave($insert, $changedAttributes);
    //     if ($insert) {
    //         if ($this->is_call_message == false || $this->is_call_request == false) {
    //             return  new \common\events\chat\NewChatMessageSend([$this->reciverId], $this->createduser->name, $this->createduser->user_handle, \common\models\GeneralModel::strMaxWord($this->message), $this->chat->chat_hash, $this->chat);
    //         }
    //     }

    //     // anurag's testing line
    //     // return  new \common\events\chat\NewChatMessageSend([748], $this->createduser->name, $this->message, $this->chat->chat_hash, $this->data);
    // }

    public function prepareData()
    {
        $fields = [];
        $fields['chat_hash'] = $this->chat->chat_hash;
        // if (isset($this->chat->chat_type) && $this->chat->chat_type == 2) {
        //     if ($this->is_quotation_message == true) {
        //         $fields['quote'] = function () {
        //             return $this->quote;
        //         };
        //     }

        //     if ($this->is_quotation_active == true) {
        //         $fields['payment_details'] = function () {
        //             return $this->payment_details;
        //         };
        //     }
        // }
        return  $fields;
    }

    public function getReciverId()
    {
        if (!empty($this->sender_id)) {
            return $this->chat->user_id == $this->sender_id ? $this->chat->user_id : $this->sender_id;
        }
        return $this->chat->user_id == $this->created_by ? $this->chat->recipient_user_id : $this->chat->user_id;
    }


    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    public function getMessage_datetime()
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }

    public function getQuote()
    {
        return $this->hasOne(LeadPartnerQuotes::className(), ['id' => 'quotation_id'])->asArray();
    }

    public function getPayment_details()
    {
        if (!empty($this->quote)) {
            return $this->hasOne(\api\models\leads\LeadPartnerQuoteInstallments::className(), ['lead_partner_quote_id' => 'quotation_id'])->where(['IS NOT', 'payment_link', NULL])->asArray()->orderBy(['id' => SORT_DESC]);
        }
    }

    public function chatType()
    {
        if ($this->chat->chat_type == Chat::CHAT_TYPE_DIRECT) {
            return Chat::OBJECTIVE_DIRECT;
        }
        if ($this->chat->chat_type == Chat::CHAT_TYPE_QUOTE) {
            return Chat::OBJECTIVE_QUOTE;
        }
    }
}
