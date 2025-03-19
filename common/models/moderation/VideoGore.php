<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "gore".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $prob
 * @property float|null $very_bloody
 * @property float|null $slightly_bloody
 * @property float|null $body_organ
 * @property float|null $serious_injury
 * @property float|null $superficial_injury
 * @property float|null $corpse
 * @property float|null $skull
 * @property float|null $unconscious
 * @property float|null $body_waste
 * @property float|null $other
 * @property float|null $animated
 * @property float|null $fake
 * @property float|null $real
 */
class VideoGore extends ActiveRecord
{
    public static $accessible_attributes = [ 'prob', 'very_bloody', 'slightly_bloody', 'body_organ', 'serious_injury', 'superficial_injury', 'corpse', 'skull', 'unconscious', 'body_waste', 'other', 'animated', 'fake', 'real'];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_gore';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'prob', 'very_bloody', 'slightly_bloody', 'body_organ', 'serious_injury', 'superficial_injury', 'corpse', 'skull', 'unconscious', 'body_waste', 'other', 'animated', 'fake', 'real'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['prob', 'very_bloody', 'slightly_bloody', 'body_organ', 'serious_injury', 'superficial_injury', 'corpse', 'skull', 'unconscious', 'body_waste', 'other', 'animated', 'fake', 'real'], 'number'],
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
            'very_bloody' => 'Very Bloody',
            'slightly_bloody' => 'Slightly Bloody',
            'body_organ' => 'Body Organ',
            'serious_injury' => 'Serious Injury',
            'superficial_injury' => 'Superficial Injury',
            'corpse' => 'Corpse',
            'skull' => 'Skull',
            'unconscious' => 'Unconscious',
            'body_waste' => 'Body Waste',
            'other' => 'Other',
            'animated' => 'Animated',
            'fake' => 'Fake',
            'real' => 'Real',
        ];
    }

    public static function gorestore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->prob = $frame['gore']['prob'] ?? 0;
            $model->very_bloody = $frame['prob']['classes']['very_bloody'] ?? 0;
            $model->slightly_bloody = $frame['prob']['classes']['slightly_bloody'] ?? 0;
            $model->body_organ = $frame['prob']['classes']['body_organ'] ?? 0;
            $model->serious_injury = $frame['prob']['classes']['serious_injury'] ?? 0;
            $model->superficial_injury = $frame['prob']['classes']['superficial_injury'] ?? 0;
            $model->corpse = $frame['prob']['classes']['corpse'] ?? 0;
            $model->skull = $frame['prob']['classes']['skull'] ?? 0;
            $model->unconscious = $frame['prob']['classes']['unconscious'] ?? 0;
            $model->body_waste = $frame['prob']['classes']['body_waste'] ?? 0;
            $model->other = $frame['prob']['classes']['other'] ?? 0;
            $model->animated = $frame['prob']['type']['animated'] ?? 0;
            $model->fake = $frame['prob']['type']['fake'] ?? 0;
            $model->real = $frame['prob']['type']['real'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}
