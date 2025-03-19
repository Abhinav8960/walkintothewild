<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "selfharm".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $prob
 * @property float|null $real
 * @property float|null $fake
 * @property float|null $animated
 */
class VideoSelfharm extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_selfharm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'prob', 'real', 'fake', 'animated'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['prob', 'real', 'fake', 'animated'], 'number'],
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
            'real' => 'Real',
            'fake' => 'Fake',
            'animated' => 'Animated',
        ];
    }

    public static function selfharmstore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->prob = $frame['self-harm']['prob'] ?? 0;;
            $model->real = $frame['self-harm']['type']['real'] ?? 0;;
            $model->fake = $frame['self-harm']['type']['fake'] ?? 0;;
            $model->animated = $frame['self-harm']['type']['animated'] ?? 0;;

            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}
