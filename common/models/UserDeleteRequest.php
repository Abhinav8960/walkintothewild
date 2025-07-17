<?php

namespace common\models;

use common\events\user\UserAccountDeleteRequest;
use Yii;

/**
 * This is the model class for table "user_delete_request".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $email
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserDeleteRequest extends \yii\db\ActiveRecord
{


    const OBJECTIVE = "user_delete_request";


    public function behaviors()
    {
        return [
            [
                'class' => \common\behaviors\FootprintsBehavior::class,
                'objective' => self::OBJECTIVE,
                'collection' => \common\models\trackings\Footprints::MODEL_USER_DELETE_REQUEST,
            ],
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
    public static function tableName()
    {
        return 'user_delete_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['user_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['email'], 'required'],
            [['email'], 'string', 'max' => 512],
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
            'email' => 'Email',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            new UserAccountDeleteRequest($this->user_id, $this->email);            
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
