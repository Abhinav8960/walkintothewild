<?php

namespace common\models\park;

use Yii;

/**
 * This is the model class for table "safari_park_accomodation".
 *
 * @property int $id
 * @property int|null $safari_park_id
 * @property int|null $master_accomodation_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SafariParkAccomodation extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_park_accomodation';
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
            [['safari_park_id', 'meta_stay_category_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            // 'master_accomodation_id' => 'Master Accomodation ID',
            'meta_stay_category_id' => 'Meta Stay Category ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
