<?php

namespace common\models\sharesafari;

use common\models\cms\flagreason\Flagreason;
use Yii;
use common\models\User;
use common\models\park\SafariPark;

/**
 * This is the model class for table "share_safari_comment_report".
 *
 * @property int $id
 * @property int|null $share_safari_id
 * @property int|null $park_id
 * @property int|null $	share_safari_comment_id
 * @property int|null $report_reason_id
 * @property string|null $report_detail
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
class ShareSafariCommentReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_comment_report';
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
            [['share_safari_id', 'park_id', '	share_safari_comment_id', 'report_reason_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['report_detail'], 'string', 'max' => 512],
            // [['user_device', 'user_platform', 'user_browser'], 'string', 'max' => 50],
            // [['user_ip_address'], 'string', 'max' => 20],
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
            'share_safari_comment_id' => 'Share Safari Comment ID',
            'report_reason_id' => 'Report Reason ID',
            'report_detail' => 'Report Detail',
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



    public function getComment()
    {
        return $this->hasOne(ShareSafariComment::className(), ['id' => 'share_safari_comment_id']);
    }


    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getReportreason()
    {
        return $this->hasOne(Flagreason::className(), ['id' => 'report_reason_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParentname()
    {
        return isset($this->sharesafari) ? $this->sharesafari->share_safari_title : '';
    }

    public function getCommentname()
    {
        return isset($this->comment) ? $this->comment->comment : '';
    }
}
