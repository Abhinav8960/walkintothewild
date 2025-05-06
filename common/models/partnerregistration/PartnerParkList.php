<?php

namespace common\models\partnerregistration;

use api\models\park\SafariPark;
use Yii;

/**
 * This is the model class for table "partner_park_list".
 *
 * @property int $id
 * @property int|null $partner_registration_id
 * @property int|null $park_id
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $status
 */
class PartnerParkList extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_park_list';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => fn () => Yii::$app->user->id ?? null,
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => fn () => time(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_registration_id', 'park_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['partner_registration_id', 'park_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_registration_id' => 'Partner Registration ID',
            'park_id' => 'Park ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }


    // public function getUser()
    // {
    //     return $this->hasOne(User::className(), ['id' => 'user_id']);
    // }

    // public function getSharesafari()
    // {
    //     return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    // }


    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }
}
