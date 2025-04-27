<?php

namespace console\models\package;

use common\models\cms\flagreason\Flagreason;
use common\models\User;
use Yii;

/**
 * This is the model class for table "package_comment_report".
 *
 * @property int $id
 * @property int|null $package_id
 * @property int|null $user_id
 * @property int|null $package_comment_id
 * @property string|null $reason
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
class PackageCommentReport extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package_comment_report';
    }

     /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_package');
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'user_id', 'package_comment_id', 'report_reason_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['reason', 'report_detail'], 'string', 'max' => 512],
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
            'package_id' => 'Package ID',
            'user_id' => 'User ID',
            'package_comment_id' => 'Package Comment ID',
            'reason' => 'Reason',
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
            'parentname' => 'Package Name',
        ];
    }



    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }



    public function getComment()
    {
        return $this->hasOne(PackageComment::className(), ['id' => 'package_comment_id']);
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
        return isset($this->package) ? $this->package->package_name : '';
    }

    public function getCommentname()
    {
        return isset($this->comment) ? $this->comment->comment : '';
    }
}
