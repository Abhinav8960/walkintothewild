<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mobile_verification".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $mobile_no
 * @property int|null $otp
 * @property int $exp_datetime
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class MobileVerification extends \yii\db\ActiveRecord
{

    const CALLING_NUMBER = 1;
    const WHATSAPP_NUMBER = 2;

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => function () {
                    return Yii::$app->user->id ?? '';
                },
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
        return 'mobile_verification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'mobile_no', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['mobile_no', 'otp_by_user', 'exp_datetime'], 'required'],
            [['mobile_no'], 'match', 'pattern' => '/^[6-9]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['otp', 'otp_by_user','source_type'], 'safe'],
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
            'mobile_no' => 'Mobile No',
            'otp' => 'Auto Generated Otp',
            'otp_by_user' => 'Enter OTP',
            'exp_datetime' => 'Exp Datetime',
            'status' => 'Status',
            'source_type'=>'Source Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

}
