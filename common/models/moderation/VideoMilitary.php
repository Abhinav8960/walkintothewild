<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_military".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $prob
 * @property float|null $military_equipment
 * @property float|null $military_personnel
 * @property float|null $military_profile_photo
 */
class VideoMilitary extends ActiveRecord
{
    public static $accessible_attributes = [ 'prob', 'military_equipment', 'military_personnel', 'military_profile_photo'];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_military';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
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
            [['info_id', 'info_position', 'prob', 'military_equipment', 'military_personnel', 'military_profile_photo'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['prob', 'military_equipment', 'military_personnel', 'military_profile_photo'], 'number'],
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
            'military_equipment' => 'Military Equipment',
            'military_personnel' => 'Military Personnel',
            'military_profile_photo' => 'Military Profile Photo',
        ];
    }

    public static function militarystore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->prob = $frame['military']['prob'] ?? 0;
            $model->military_equipment = $frame['military']['classes']['military_equipment'] ?? 0;
            $model->military_personnel = $frame['military']['classes']['military_personnel'] ?? 0;
            $model->military_profile_photo = $frame['military']['classes']['military_profile_photo'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}