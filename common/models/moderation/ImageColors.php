<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_colors".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $dominant_r
 * @property float|null $dominant_g
 * @property float|null $dominant_b
 * @property string|null $dominant_hex
 */
class ImageColors extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_colors';
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
            [['media_id', 'dominant_r', 'dominant_g', 'dominant_b', 'dominant_hex'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['dominant_r', 'dominant_g', 'dominant_b'], 'number'],
            [['media_id'], 'string', 'max' => 512],
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
            'media_id' => 'Media ID',
            'dominant_r' => 'Dominant R',
            'dominant_g' => 'Dominant G',
            'dominant_b' => 'Dominant B',
            'dominant_hex' => 'Dominant Hex',
        ];
    }

    public static function colorstore($feedback, $id)
    {
        // if (!isset($feedback['data']['frames']) || !is_array($feedback['data']['frames'])) {
        //     return false;
        // }
        foreach ($feedback['data']['frames'] as $image) {
            $model = new self();
            $model->moderation_id = $id;
            $model->media_id = $image['media']['id'] ?? null;
            $model->dominant_r = $image['colors']['dominant']['r'] ?? null;
            $model->dominant_g = $image['colors']['dominant']['g'] ?? null;
            $model->dominant_b = $image['colors']['dominant']['b'] ?? null;
            $model->dominant_hex = $image['colors']['dominant']['hex'] ?? null;

            if (!$model->save()) {
                return false;
            }

            if (isset($image['colors']['other']) && is_array($image['colors']['other'])) {
                foreach ($image['colors']['other'] as $other) {
                    $other_model = new VideoColorsOther();
                    $other_model->moderation_id = $id;
                    $other_model->color_id = $model->id;
                    $model->media_id = $image['media']['id'] ?? null;
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
