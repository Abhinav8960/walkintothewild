<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_text".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $has_artificial
 * @property float|null $has_natural
 * @property float|null $ignored_text
 */
class VideoText extends ActiveRecord
{
    public static $accessible_attributes = ['has_artificial', 'has_natural', 'ignored_text'];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'has_artificial', 'has_natural', 'ignored_text'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position', 'ignored_text'], 'integer'],
            [['has_artificial', 'has_natural'], 'number'],
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
            'has_artificial' => 'Has Artificial',
            'has_natural' => 'Has Natural',
            'ignored_text' => 'Ignored Text',
        ];
    }

    public static function textstore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->has_artificial = $frame['text']['has_artificial'] ?? 0;
            $model->has_natural = $frame['text']['has_natural'] ?? 0;
            $model->ignored_text = $frame['text']['ignored_text'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }

}