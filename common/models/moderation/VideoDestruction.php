<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_destruction".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $prob
 * @property float|null $building_major_damage
 * @property float|null $building_minor_damage
 * @property float|null $building_on_fire
 * @property float|null $building_burned
 * @property float|null $vehicle_major_damage
 * @property float|null $vehicle_minor_damage
 * @property float|null $vehicle_on_fire
 * @property float|null $vehicle_burned
 * @property float|null $wildfire
 * @property float|null $unsafe_fire
 * @property float|null $violent_protest
 */
class VideoDestruction extends ActiveRecord
{
    public static $accessible_attributes = ['prob', 'building_major_damage', 'building_minor_damage', 'building_on_fire', 'building_burned', 'vehicle_major_damage', 'vehicle_minor_damage', 'vehicle_on_fire', 'vehicle_burned', 'wildfire', 'unsafe_fire', 'violent_protest'];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_destruction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'prob', 'building_major_damage', 'building_minor_damage', 'building_on_fire', 'building_burned', 'vehicle_major_damage', 'vehicle_minor_damage', 'vehicle_on_fire', 'vehicle_burned', 'wildfire', 'unsafe_fire', 'violent_protest'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['prob', 'building_major_damage', 'building_minor_damage', 'building_on_fire', 'building_burned', 'vehicle_major_damage', 'vehicle_minor_damage', 'vehicle_on_fire', 'vehicle_burned', 'wildfire', 'unsafe_fire', 'violent_protest'], 'number'],
            [['info_id'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moderation_id' => 'Moderation ID',
            'info_id' => 'Info ID',
            'info_position' => 'Info Position',
            'prob' => 'Prob',
            'building_major_damage' => 'Building Major Damage',
            'building_minor_damage' => 'Building Minor Damage',
            'building_on_fire' => 'Building On Fire',
            'building_burned' => 'Building Burned',
            'vehicle_major_damage' => 'Vehicle Major Damage',
            'vehicle_minor_damage' => 'Vehicle Minor Damage',
            'vehicle_on_fire' => 'Vehicle On Fire',
            'vehicle_burned' => 'Vehicle Burned',
            'wildfire' => 'Wildfire',
            'unsafe_fire' => 'Unsafe Fire',
            'violent_protest' => 'Violent Protest',
        ];
    }

    public static function destructionstore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->prob = $frame['destruction']['prob'] ?? 0;
            $model->building_major_damage = $frame['destruction']['classes']['building_major_damage'] ?? 0;
            $model->building_minor_damage = $frame['destruction']['classes']['building_minor_damage'] ?? 0;
            $model->building_on_fire = $frame['destruction']['classes']['building_on_fire'] ?? 0;
            $model->vehicle_major_damage = $frame['destruction']['classes']['vehicle_major_damage'] ?? 0;
            $model->vehicle_minor_damage = $frame['destruction']['classes']['vehicle_minor_damage'] ?? 0;
            $model->vehicle_on_fire = $frame['destruction']['classes']['vehicle_on_fire'] ?? 0;
            $model->vehicle_burned = $frame['destruction']['classes']['vehicle_burned'] ?? 0;
            $model->wildfire = $frame['destruction']['classes']['wildfire'] ?? 0;
            $model->unsafe_fire = $frame['destruction']['classes']['unsafe_fire'] ?? 0;
            $model->violent_protest = $frame['destruction']['classes']['violent_protest'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }

}