<?php

namespace api\models\chat;

use api\models\leads\LeadPartnerQuotes;
use Yii;
use api\models\User;
use common\models\chat\ChatMessageHistory;
use common\models\GeneralModel;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGalleryVersion;

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
            'message' => function () {
                if ($this->chat->chat_type == 2) {
                    return GeneralModel::maskContactInfoInString($this->message);
                }
                return $this->message;
            },
            'is_edited' => function () {
                return (bool) $this->is_edited;
            },
            'is_deleted' => function () {
                return (bool) $this->status == 0 ? true : false;
            },
            'is_system_generated' => function () {
                return (bool) $this->is_system_generated;
            },

            'message_datetime' => function () {
                return strtotime($this->message_datetime);
            },
            'is_message_sent_by_you' => function () {
                return $this->created_by == $this->getActiveUserId() ? true : false;
            },
        ];

        if (isset($this->chat->chat_type) && $this->chat->chat_type == 2) {
            if ($this->is_quotation_message == true) {
                // Remove 'message' from the fields array
                unset($fields['message']);
                // $fields['message'] = function () {
                //     return "Please see below quotation";
                // };

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
        if ($this->gallery != null) {
            unset($fields['message']);

            $fields['gallery'] = function () {
                // return json_decode($this->gallery, true);
                return isset($this->partnerGalleryVersion) ? json_decode($this->partnerGalleryVersion->live_images, true) : null;
            };
            // $fields['thumbnail_url'] = function () {
            //     return $this->getGalleryThumbnail();
            // };
        }
        if ($this->is_call_message == true && !empty($this->call_id)) {
            unset($fields['message']);

            $fields['call'] = function () {
                return $this->call;
            };
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
            [['is_quotation_message', 'is_quotation_active', 'quotation_id', 'chat_id', 'is_call_message', 'call_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['gallery'], 'string', 'max' => 512],
            [['message'], 'string'],
            [['gallery', 'is_system_generated', 'transaction_id'], 'safe'],
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

        $history = new ChatMessageHistory();
        $history->chat_message_id = $this->id;
        $history->chat_id = $this->chat_id;
        $history->message = $this->message;
        $history->is_quotation_message = $this->is_quotation_message == 1 ? 1 : 0;
        $history->quotation_id = $this->quotation_id;
        $history->is_quotation_active = $this->is_quotation_active == 1 ? 1 : 0;
        $history->is_call_message = $this->is_call_message == 1 ? 1 : 0;
        $history->call_id = $this->call_id;
        $history->is_call_request = $this->is_call_request == 1 ? 1 : 0;
        $history->data = $this->data;
        $history->gallery = $this->gallery;
        $history->partner_gallery_version_id = $this->partner_gallery_version_id;
        $history->transaction_id = $this->transaction_id;
        $history->created_at = $this->created_at;
        $history->created_by = $this->created_by;
        $history->updated_at = $this->updated_at;
        $history->updated_by = $this->updated_by;
        $history->save(false);
        if ($insert) {
            if ($this->chat->chat_type == Chat::CHAT_TYPE_QUOTE) {
                $senderId = $this->createduser->id;
                return  new \common\events\chat\NewQuotationChatMessage($this->reciverId,$senderId, \common\models\GeneralModel::strMaxWord($this->message), $this->chat->chat_hash, $this->chat);
            }
            if ($this->is_call_message != true || $this->status != 0) {
                $sender = $this->createduser->name;
                // if($this->chat->chat_type ==  Chat::CHAT_TYPE_QUOTE && $this->created_by == $this->chat->recipient_user_id){
                //     $sender = $this->chat->operator->business_name;
                // }
                return  new \common\events\chat\NewChatMessageSend([$this->reciverId], $sender, $this->createduser->user_handle, \common\models\GeneralModel::strMaxWord($this->message), $this->chat->chat_hash, $this->chat);
            }
        }
        return true;



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
            return $this->chat->user_id == $this->sender_id ? $this->chat->recipient_user_id : $this->chat->user_id;
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
            return $this->hasOne(\api\models\leads\LeadPartnerQuoteInstallments::className(), ['lead_partner_quote_id' => 'quotation_id'])->where(['IS NOT', 'payment_link', null])->orderBy(['id' => SORT_DESC]);
        }
    }

    public function getCall()
    {
        return $this->hasOne(\api\models\CallLog::className(), ['id' => 'call_id']);
    }

    // public function getGalleryThumbnail()
    // {
    //     if (!empty($this->gallery)) {
    //         $thumbnail_url = explode('/', $this->gallery);
    //         $slug = end($thumbnail_url);
    //         $gallery = PartnerGallery::find()
    //             ->where(['slug' => $slug])
    //             ->andWhere(['status' => 1])
    //             ->one();
    //         if ($gallery) {
    //             return $gallery->thumbnail;
    //         }
    //         return NULL;
    //     }
    // }

    public function getRecordingUrl()
    {
        if ($call = $this->call) {
            return $call->recording_url;
        }
        return '';
    }

    public function getPartnerGalleryVersion()
    {
        return $this->hasOne(PartnerGalleryVersion::class, ['id' => 'partner_gallery_version_id']);
    }
}
