<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_follower".
 *
 * @property int $id
 * @property int $user_id
 * @property int $follow_user_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class BlockedModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blocked_user';
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
            [['blocked_user_id', 'user_id'], 'required'],
            [['blocked_user_id', 'user_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['blocked_user_id', 'user_id'], 'unique', 'targetAttribute' => ['blocked_user_id', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blocked_user_id' => 'Blocked User Id',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'blocked_user_id']);
    }
}
