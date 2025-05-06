<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "social_login_verification".
 *
 * @property int $id
 * @property string $source
 * @property string $source_id
 * @property string $name
 * @property string $email
 * @property int $otp
 * @property int $expiry_datetime
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class SocialLoginVerification extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social_login_verification';
    }

    public function behaviors()
    {
        return [
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
            [['status'], 'default', 'value' => 0],
            [['source', 'source_id', 'otp', 'expiry_datetime', 'created_at', 'updated_at'], 'required'],
            [['otp', 'expiry_datetime', 'status', 'created_at', 'updated_at'], 'integer'],
            [['source', 'source_id', 'name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'source_id' => 'Source ID',
            'otp' => 'Otp',
            'expiry_datetime' => 'Expiry Datetime',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
