<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_verification".
 *
 * @property int $id
 * @property int|null $source_type 
 * @property int|null $otp
 * @property int|null $otp_by_user
 * @property string $exp_datetime
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class SourceVerification extends \yii\db\ActiveRecord
{


    const SOURCE_TYPE_SMS =1 ;
    const SOURCE_TYPE_EMAIL = 2;
    const SOURCE_TYPE_WHATSAPP = 3;


    public function behaviors()
    {
        return [
            // [
            //     'class' => \yii\behaviors\BlameableBehavior::className(),
            //     'createdByAttribute' => 'created_by',
            //     'updatedByAttribute' => 'updated_by',
            //     'value' => function () {
            //         return Yii::$app->user->id ?? '';
            //     },
            // ],
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
        return 'source_verification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source','source_type', 'otp','created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['is_expired'], 'default', 'value' => 0],
            [['source_type', 'otp', 'is_expired', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['exp_datetime'], 'required'],
            [['exp_datetime'], 'safe'],
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
            'source_type' => 'Source Type',
            'email' => 'Email',
            'otp' => 'Otp',
            'exp_datetime' => 'Exp Datetime',
            'is_expired' => 'Is Expired',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

}
