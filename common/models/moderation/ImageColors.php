<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
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
class ImageColors extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_colors';
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

    public static function colorStore($feedback, $moderationId)
    {
        // if (!isset($feedback['colors']) || !is_array($feedback['colors'])) {
        //     return false;
        // }

        // if (!isset($feedback['colors']['dominant']) || !is_array($feedback['colors']['dominant'])) {
        //     return false;
        // }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->dominant_r = $feedback['colors']['dominant']['r'] ?? null;
        $model->dominant_g = $feedback['colors']['dominant']['g'] ?? null;
        $model->dominant_b = $feedback['colors']['dominant']['b'] ?? null;
        $model->dominant_hex = $feedback['colors']['dominant']['hex'] ?? null;

        if (!$model->save()) {
            return false;
        }

        // if (isset($feedback['colors']['accent']) && is_array($feedback['colors']['accent'])) {
        //     foreach ($feedback['colors']['accent'] as $accent) {
        //         $accent_model = new ImageColorsAccent();
        //         $accent_model->moderation_id = $moderationId;
        //         $accent_model->color_id = $model->id;
        //         $accent_model->r = $accent['r'] ?? null;
        //         $accent_model->g = $accent['g'] ?? null;
        //         $accent_model->b = $accent['b'] ?? null;
        //         $accent_model->hex = $accent['hex'] ?? null;

        //         if (!$accent_model->save()) {
        //             return false;
        //         }
        //     }
        // }

        // if (isset($feedback['colors']['other']) && is_array($feedback['colors']['other'])) {
            foreach ($feedback['colors']['other'] as $other) {
                $other_model = new ImageColorsOther();
                $other_model->moderation_id = $moderationId;
                $other_model->color_id = $model->id;
                $other_model->r = $other['r'] ?? null;
                $other_model->g = $other['g'] ?? null;
                $other_model->b = $other['b'] ?? null;
                $other_model->hex = $other['hex'] ?? null;

                if (!$other_model->save()) {
                    return false;
                }
            }
        // }

        return true;
    }
}
