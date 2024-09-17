<?php

namespace common\models\park;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "safari_park_zone".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property int $master_zone_type_id
 * @property int $master_zone_type_name
 * @property string $zone_name
 * @property string $entry_gate_name
 * @property string|null $entry_gate_latitude
 * @property string|null $entry_gate_longitude
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariParkZone extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_park_zone';
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
            [['safari_park_id', 'master_zone_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['zone_name', 'entry_gate_name'], 'string', 'max' => 255],
            [['entry_gate_latitude', 'entry_gate_longitude'], 'string', 'max' => 50],
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
            'master_zone_type_id' => 'Master Zone Type ID',
            'master_zone_type_name' => 'Master Zone Type Name',
            'zone_name' => 'Zone Name',
            'entry_gate_name' => 'Entry Gate Name',
            'entry_gate_latitude' => 'Entry Gate Latitude',
            'entry_gate_longitude' => 'Entry Gate Longitude',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
