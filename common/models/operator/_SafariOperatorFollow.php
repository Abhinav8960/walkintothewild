<?php

namespace common\models\operator;

use Yii;
use common\models\User;

/**
 * This is the model class for table "safari_operator_follow".
 *
 * @property int $id
 * @property int $safari_operator_id
 * @property int $user_id
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_platform_version
 * @property string|null $user_browser
 * @property string|null $user_browser_version
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class SafariOperatorFollow extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_operator_follow';
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
            [['safari_operator_id', 'user_id'], 'required'],
            [['safari_operator_id', 'user_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['user_device', 'user_platform', 'user_browser'], 'string', 'max' => 50],
            [['user_agent'], 'string', 'max' => 512],
            [['user_browser_version', 'user_ip_address'], 'string', 'max' => 20],
            [['safari_operator_id', 'user_id'], 'unique', 'targetAttribute' => ['safari_operator_id', 'user_id']],
            [['follow_datetime', 'unfollow_datetime', 'user_platform_version'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_operator_id' => 'Safari Operator ID',
            'user_id' => 'User ID',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_platform_version' => 'User Platform Version',
            'user_browser' => 'User Browser',
            'user_browser_version' => 'User Browser Version',
            'user_ip_address' => 'User Ip Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id']);
    }
}
