<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_image_quality_detection".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $score
 */
class VideoImageQualityDetection extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_image_quality_detection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'score'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['score'], 'number'],
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
            'score' => 'Score',
        ];
    }

    public static function imagequalitystore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->score = $frame['quality']['score'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }

}