<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_destruction".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
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
class ImageDestruction extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_destruction';
    }

    /**
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_moderation');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['moderation_id', 'media_id', 'building_major_damage', 'building_minor_damage', 'building_on_fire', 'building_burned', 'vehicle_major_damage', 'vehicle_minor_damage', 'vehicle_on_fire', 'vehicle_burned', 'wildfire', 'unsafe_fire', 'violent_protest'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['building_major_damage', 'building_minor_damage', 'building_on_fire', 'building_burned', 'vehicle_major_damage', 'vehicle_minor_damage', 'vehicle_on_fire', 'vehicle_burned', 'wildfire', 'unsafe_fire', 'violent_protest'], 'number'],
            [['media_id'], 'string', 'max' => 255],
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
            'media_id' => 'Media ID',
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

    public static function destructionStore($feedback, $moderationId)
    {
        if (!isset($feedback['destruction']) || !is_array($feedback['destruction'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->prob = $feedback['destruction']['prob'] ?? 0;
        $model->building_major_damage = $feedback['destruction']['classes']['building_major_damage'] ?? 0;
        $model->building_minor_damage = $feedback['destruction']['classes']['building_minor_damage'] ?? 0;
        $model->building_on_fire = $feedback['destruction']['classes']['building_on_fire'] ?? 0;
        $model->building_burned = $feedback['destruction']['classes']['building_burned'] ?? 0;
        $model->vehicle_major_damage = $feedback['destruction']['classes']['vehicle_major_damage'] ?? 0;
        $model->vehicle_minor_damage = $feedback['destruction']['classes']['vehicle_minor_damage'] ?? 0;
        $model->vehicle_on_fire = $feedback['destruction']['classes']['vehicle_on_fire'] ?? 0;
        $model->vehicle_burned = $feedback['destruction']['classes']['vehicle_burned'] ?? 0;
        $model->wildfire = $feedback['destruction']['classes']['wildfire'] ?? 0;
        $model->unsafe_fire = $feedback['destruction']['classes']['unsafe_fire'] ?? 0;
        $model->violent_protest = $feedback['destruction']['classes']['violent_protest'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
