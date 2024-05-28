<?php

namespace common\models\park;

use Yii;

/**
 * This is the model class for table "birding_parks_vehicle".
 *
 * @property int $id
 * @property int $birding_park_id
 * @property int $vehicle_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class BirdingParkVehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'birding_parks_vehicle';
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
            [['birding_park_id', 'vehicle_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['birding_park_id', 'vehicle_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['birding_park_id', 'vehicle_id'], 'unique', 'targetAttribute' => ['birding_park_id', 'vehicle_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'birding_park_id' => 'Birding Park ID',
            'vehicle_id' => 'Vehicle ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
