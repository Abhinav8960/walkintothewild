<?php

namespace common\models\park;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "safari_park_follower".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property int $user_id
 * @property int|null $follow_datetime
 * @property int|null $unfollow_datetime
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class SafariParkFollower extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_park_follower';
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
            [['follow_datetime', 'unfollow_datetime', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['safari_park_id', 'user_id'], 'required'],
            [['safari_park_id', 'user_id', 'follow_datetime', 'unfollow_datetime', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['safari_park_id', 'user_id'], 'unique', 'targetAttribute' => ['safari_park_id', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park ID',
            'user_id' => 'User ID',
            'follow_datetime' => 'Follow Datetime',
            'unfollow_datetime' => 'Unfollow Datetime',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
