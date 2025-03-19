<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "smoking".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $prob
 * @property float|null $regular_tobacco
 * @property float|null $ambiguous_tobacco
 */
class VideoSmoking extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_smoking';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'prob', 'regular_tobacco', 'ambiguous_tobacco'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['prob', 'regular_tobacco', 'ambiguous_tobacco'], 'number'],
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
            'regular_tobacco' => 'Regular Tobacco',
            'ambiguous_tobacco' => 'Ambiguous Tobacco',
        ];
    }

    public static function smokingstore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->prob = $frame['tobacco']['prob'] ?? 0;
            $model->regular_tobacco = $frame['tobacco']['classes']['regular_tobacco'] ?? null;
            $model->ambiguous_tobacco = $frame['tobacco']['classes']['ambiguous_tobacco'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}