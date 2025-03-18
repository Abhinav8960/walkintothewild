<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "colors".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $dominant_r
 * @property float|null $dominant_g
 * @property float|null $dominant_b
 * @property string|null $dominant_hex
 */
class Colors extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'dominant_r', 'dominant_g', 'dominant_b', 'dominant_hex'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['dominant_r', 'dominant_g', 'dominant_b'], 'number'],
            [['info_id'], 'string', 'max' => 512],
            [['dominant_hex'], 'string', 'max' => 7],
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
            'dominant_r' => 'Dominant R',
            'dominant_g' => 'Dominant G',
            'dominant_b' => 'Dominant B',
            'dominant_hex' => 'Dominant Hex',
        ];
    }

    public static function colorstore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }
        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->dominant_r = $frame['colors']['dominant']['r'] ?? null;
            $model->dominant_g = $frame['colors']['dominant']['g'] ?? null;
            $model->dominant_b = $frame['colors']['dominant']['b'] ?? null;
            $model->dominant_hex = $frame['colors']['dominant']['hex'] ?? null;

            if (!$model->save()) {
                return false;
            }

            if (isset($frame['colors']['accent']) && is_array($frame['colors']['accent'])) {
                foreach ($frame['colors']['accent'] as $accent) {
                    $accent_model = new ColorsAccent();
                    $accent_model->moderation_id = $id;
                    $accent_model->color_id = $model->id;
                    $accent_model->info_id = $frame['info']['id'] ?? null;
                    $accent_model->info_position = $frame['info']['position'] ?? null;
                    $accent_model->r = $accent['r'] ?? null;
                    $accent_model->g = $accent['g'] ?? null;
                    $accent_model->b = $accent['b'] ?? null;
                    $accent_model->hex = $accent['hex'] ?? null;

                    if (!$accent_model->save()) {
                        return false;
                    }
                }
            }

            if (isset($frame['colors']['other']) && is_array($frame['colors']['other'])) {
                foreach ($frame['colors']['other'] as $other) {
                    $other_model = new ColorsOther();
                    $other_model->moderation_id = $id;
                    $other_model->color_id = $model->id;
                    $other_model->info_id = $frame['info']['id'] ?? null;
                    $other_model->info_position = $frame['info']['position'] ?? null;
                    $other_model->r = $other['r'] ?? null;
                    $other_model->g = $other['g'] ?? null;
                    $other_model->b = $other['b'] ?? null;
                    $other_model->hex = $other['hex'] ?? null;

                    if (!$other_model->save()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
