<?php

namespace api\models\chat;

use api\models\leads\LeadPartnerQuotes;
use Yii;
use api\models\User;

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
class ChatMessage extends \common\models\chat\ChatMessage
{


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
        return \Yii::$app->user->identity->id ?? \Yii::$app->params['active_user_id'];
    }


    public function fields()
    {
        $fields = [
            'id',
            'message',
            'message_datetime' => function () {
                return strtotime($this->message_datetime);
            },
            'is_message_sent_by_you' => function () {
                return $this->created_by == $this->getActiveUserId() ? true : false;
            },
        ];
        if (isset($this->chat->chat_type) && $this->chat->chat_type == 2) {
            if ($this->is_quotation_message == true) {
                $fields['quote'] = function () {
                    return $this->quote;
                };
            }

            if ($this->is_quotation_active == true && $this->created_by != $this->getActiveUserId()) {
                $fields['payment_details'] = function () {
                    return $this->payment_details;
                };
            }
        }
        return $fields;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['is_quotation_message', 'is_quotation_active', 'quotation_id', 'chat_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['message'], 'string', 'max' => 512],
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

    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    public function getMessage_datetime()
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }

    // public function getSender()
    // {

    //     $data['name'] = $this->createduser->name;
    //     $data['user_handle'] = $this->createduser->user_handle;
    //     $data['profile_image'] = $this->createduser->profile_image;
    //     $data['is_safari_operator'] = $this->createduser->is_safari_operator == 1 ? true : false;
    //     $data['operator_slug'] = $this->createduser->operator->slug ?? NULL;
    //     $data['display_name'] = $this->createduser->display_name;
    //     return $data;
    // }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            return  new \common\events\chat\NewChatMessageSend([$this->reciverId], $this->createduser->name, $this->message, $this->chat->chat_hash, $this->prepareData());
        }

        // anurag's testing line
        // return  new \common\events\chat\NewChatMessageSend([748], $this->createduser->name, $this->message, $this->chat->chat_hash, $this->data);
    }

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


    public function getQuote()
    {
        return $this->hasOne(LeadPartnerQuotes::className(), ['id' => 'quotation_id']);
    }

    public function getPayment_details()
    {
        if (!empty($this->quote)) {
            return $this->hasOne(\api\models\leads\LeadPartnerQuoteInstallments::className(), ['lead_partner_quote_id' => 'quotation_id'])->where(['IS NOT', 'payment_link', NULL])->orderBy(['id' => SORT_DESC]);
        }
    }
}
