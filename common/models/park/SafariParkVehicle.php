<?php

namespace common\models\park;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "parks_vehicle".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property int $vehicle_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariParkVehicle extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_parks_vehicle';
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
            [['safari_park_id', 'vehicle_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['safari_park_id', 'vehicle_id'], 'unique', 'targetAttribute' => ['safari_park_id', 'vehicle_id']],
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
            'vehicle_id' => 'Vehicle ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
