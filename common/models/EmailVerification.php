<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_verification".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $source_type 1=>'legal_entity_mail',2=>'billing_mail',3=>'user_kyc_mail'
 * @property string|null $email
 * @property int|null $otp
 * @property int|null $otp_by_user
 * @property string $exp_datetime
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class EmailVerification extends \yii\db\ActiveRecord
{


    const BILLING_MAIL =1 ;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_verification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'source_type', 'email', 'otp', 'otp_by_user', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['user_id', 'source_type', 'otp', 'otp_by_user', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['exp_datetime'], 'required'],
            [['exp_datetime','email','otp_by_user'], 'safe'],
            [['email'], 'email'],
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
            'source_type' => 'Source Type',
            'email' => 'Email',
            'otp' => 'Otp',
            'otp_by_user' => 'Enter OTP',
            'exp_datetime' => 'Exp Datetime',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

}
