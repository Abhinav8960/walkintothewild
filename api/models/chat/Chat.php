<?php

namespace api\models\chat;

use api\models\leads\Lead;
use api\models\leads\LeadPartnerQuotes;
use Yii;
use api\models\User;
use api\models\operator\SafariOperator;
use api\models\park\SafariPark;

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
class Chat extends \common\models\chat\Chat
{

    public function fields()
    {




        $fields = [
            'id',
            'chat_hash',
            'last_message',
            'last_message_datetime'  => function () {
                return strtotime($this->last_message_datetime);
            },
            // 'chat_type',
            // 'park_id',
            // 'package_id',
            // 'quote_id',

            // 'is_quote_accept',
            // 'quote_price',
            // 'quote_price_max',
            // 'quote_more_detail',
            'is_seen' => function () {
                // return (bool) $this->is_seen;
                if ($this->activeUserId != $this->sender_id) {
                    return (bool) $this->is_seen;
                }
                return true;
            },
            'contact',
            // 'status' => function () {
            //     return (bool)$this->status;
            // },
            // 'lead',

            // 'sender',
            // 'recipient',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by'
        ];
        if ($this->chat_type == 2) {
            $fields[] = 'lead';
            if ($this->quote_id > 0) {
                $fields['quote'] = function () {
                    return $this->quote;
                };
                $fields['payment_details'] = function () {
                    return $this->payment_details;
                };
            }
            $fields['is_call_request'] = function () {
                return (bool) $this->is_call_request;
            };
            $fields['call'] = function () {
                return $this->call;
            };
            $fields['can_call'] = function () {
                return (bool) $this->callpossible();
            };
            // if ($this->call_id > 0) {


            // }
        }
        return $fields;
    }
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
            [['quote_id', 'user_id', 'recipient_user_id', 'status', 'chat_type', 'last_message_at', 'is_seen', 'call_id', 'is_quote_accept', 'is_call_request', 'sender_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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

    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_user_id']);
    }

    public function getParkoperator()
    {
        return $this->hasOne(SafariOperator::className(), ['user_id' => 'recipient_user_id']);
    }

    public function getPackageoperator()
    {
        return $this->hasOne(SafariOperator::className(), ['user_id' => 'recipient_user_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['user_id' => 'recipient_user_id']);
    }

    public function getContact()
    {
        if ($this->user_id == \Yii::$app->params['active_user_id']) {
            return $this->hasOne(User::className(), ['id' => 'recipient_user_id']);
        }
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLast_message_datetime()
    {
        if ($this->last_message_at) {
            return date('Y-m-d H:i:s', $this->last_message_at);
        }
        return null;
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getLead()
    {
        return $this->hasOne(Lead::className(), ['id' => 'lead_id']);
    }

    public function getQuote()
    {
        return $this->hasOne(LeadPartnerQuotes::className(), ['id' => 'quote_id']);
    }

    public function getPayment_details()
    {
        if (!empty($this->quote)) {
            return $this->hasOne(\api\models\leads\LeadPartnerQuoteInstallments::className(), ['lead_partner_quote_id' => 'quote_id'])->where(['IS NOT', 'payment_link', NULL])->orderBy(['id' => SORT_DESC]);
        }
    }

    public function getCall()
    {
        return $this->hasOne(\api\models\CallLog::className(), ['id' => 'call_id']);
    }

    public static function MarkChatSeen($chat_id)
    {
        $chat = self::findOne($chat_id);
        if ($chat) {
            $chat->is_seen = 1;
            return $chat->save();
        }
        return false;
    }

    protected function getActiveUserId()
    {
        return \Yii::$app->user->identity->id ?? \Yii::$app->params['active_user_id'];
    }

    private function callpossible()
    {
        if ($this->chat_type == 2) {

            if (!empty($this->user->mobile_no) && $this->user->is_mobile_no_verified == true && $this->operator->is_phone_no_verified == true && !empty($this->operator->phone_no)) {
                return true;
            }
        }
        return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Check if the 'call' attribute is not set and set it to null
            if ($insert && empty($this->call_id)) {
                $this->call_id = null;
            }
            if ($insert && empty($this->is_call_request)) {
                $this->is_call_request = null;
            }
           
            return true;
        }
        return false;
    }
}
