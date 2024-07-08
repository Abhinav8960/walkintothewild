<?php

namespace common\models\sharesafari;

use Yii;
use common\models\User;
use common\models\park\SafariPark;

/**
 * This is the model class for table "share_safari_request_contact".
 *
 * @property int|null $id
 * @property int|null $share_safari_id
 * @property int|null $park_id
 * @property int|null $user_id
 * @property int|null $share_safari_comment_id
 * @property string|null $request_token
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ShareSafariRequestContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_request_contact';
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
            [['share_safari_id', 'park_id', 'host_user_id', 'user_id', 'share_safari_comment_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['request_token'], 'string', 'max' => 40],
            [['name', 'user_device', 'user_agent', 'user_platform', 'user_browser', 'user_ip_address'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'park_id' => 'Park ID',
            'request_token' => 'Request Token',
            'share_safari_comment_id' => 'Share Safari Comment ID',
            'user_id' => 'User ID',
            'email' => 'Email',
            'name' => 'Name',
            'phone_no' => 'Phone No',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_browser' => 'User Browser',
            'user_ip_address' => 'User Ip Address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }



    public function getSharesafari()
    {
        return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    }


    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }


    public function getComment()
    {
        return $this->hasOne(ShareSafariComment::className(), ['id' => 'share_safari_comment_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }
}
