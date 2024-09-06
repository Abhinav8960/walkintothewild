<?php

namespace common\models\operator;

use common\models\cms\flagreason\Flagreason;
use Yii;
use common\models\User;
use common\models\park\SafariPark;

/**
 * This is the model class for table "safari_operator_rating_report".
 *
 * @property int $id
 * @property int|null $safari_operator_id
 * @property int|null $park_id
 * @property int|null $safari_operator_rating_id
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
class SafariOperatorRatingReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_operator_rating_report';
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
            [['user_id', 'safari_operator_id', 'park_id', 'safari_operator_rating_id', 'report_reason_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['report_detail', 'user_agent'], 'string', 'max' => 512],
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
            'safari_operator_id' => 'Safari Operator',
            'park_id' => 'Park',
            'safari_operator_rating_id' => 'Safari Operator Rating',
            'report_reason_id' => 'Report Reason',
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
            'parentname' => 'Operator',
            'commentname' => 'Review',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getRating()
    {
        return $this->hasOne(SafariOperatorRating::className(), ['id' => 'safari_operator_rating_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id']);
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }


    public function getReportreason()
    {
        return $this->hasOne(Flagreason::className(), ['id' => 'report_reason_id']);
    }

    public function getParentname()
    {
        return isset($this->operator) ? $this->operator->business_name : '';
    }


    public function getCommentname()
    {
        return isset($this->rating) ? $this->rating->review : '';
    }
}
