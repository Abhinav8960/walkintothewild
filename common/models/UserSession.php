<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_session".
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
class UserSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'required'],
            [['firebase_token','user_platform_version','application_version'], 'safe'],
            [['token'], 'safe'],
            [['is_firebase_token_active'], 'integer'],
        ];
    }

    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User Id',
            'follow_user_id' => 'Follow User Id',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'firebase_token' => 'Firebase Token',
            'user_platform_version' => 'User Platform Version',
            'application_version' => 'Application Version'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
}
