<?php

namespace common\models\sharesafari;

use Yii;
use common\models\User;
use common\models\park\SafariPark;

/**
 * This is the model class for table "share_safari_comment".
 *
 * @property int $id
 * @property int|null $share_safari_id
 * @property int|null $park_id
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property string|null $comment
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_browser
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ShareSafariComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_comment';
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
            [['share_safari_id', 'park_id', 'parent_id', 'user_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['comment', 'user_agent'], 'string', 'max' => 512],
            [['user_device', 'user_platform', 'user_browser'], 'string', 'max' => 50],
            [['user_ip_address'], 'string', 'max' => 20],
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
            'parent_id' => 'Parent ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_browser' => 'User Browser',
            'user_ip_address' => 'User Ip Address',
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


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }


    public function getReports()
    {
        return $this->hasMany(ShareSafariCommentReport::className(), ['share_safari_comment_id' => 'id']);
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }
}
