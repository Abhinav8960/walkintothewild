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
            [['id', 'share_safari_id', 'park_id', 'user_id', 'share_safari_comment_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['request_token'], 'string', 'max' => 40],
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
            'user_id' => 'User ID',
            'share_safari_comment_id' => 'Share Safari Request Comment ID',
            'request_token' => 'Request Token',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
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
