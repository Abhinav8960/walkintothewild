<?php

namespace common\models\park;

use common\models\User;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "safari_park_rating".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $safari_park_id
 * @property float|null $rating
 * @property string|null $review
 * @property int|null $flaged
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
class SafariParkRating extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_park_rating';
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
            [['user_id'], 'required'],
            [['user_id', 'safari_park_id', 'flaged', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['rating'], 'number'],
            [['review', 'user_agent'], 'string', 'max' => 512],
            [['user_device', 'user_platform', 'user_platform_version', 'user_browser'], 'string', 'max' => 50],
            [['user_browser_version', 'user_ip_address'], 'string', 'max' => 20],
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
            'safari_park_id' => 'Safari Park ID',
            'rating' => 'Rating',
            'review' => 'Review',
            'flaged' => 'Flaged',
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

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'safari_park_id']);
    }
}
