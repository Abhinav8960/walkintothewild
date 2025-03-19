<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_type".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $illustration
 * @property float|null $photo
 */
class VideoType extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'illustration', 'photo','ai_generated','deepfake'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['illustration', 'photo','deepfake','ai_generated'], 'number'],
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
            'ai_generated' => 'Ai Generated',
            'illustration' => 'Illustration',
            'deepfake' => 'Deepfake',
            'photo' => 'Photo',
        ];
    }

    public static function typestore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->illustration = $frame['type']['illustration'] ?? 0;
            $model->photo = $frame['type']['photo'] ?? 0;
            $model->ai_generated = $frame['type']['ai_generated'] ?? 0;
            $model->deepfake = $frame['type']['deepfake'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}