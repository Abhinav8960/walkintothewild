<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "colors_accent".
 *
 * @property int $id
 * @property int $color_id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $r
 * @property float|null $g
 * @property float|null $b
 * @property string|null $hex
 */
class VideoColorsAccent extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_colors_accent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'r', 'g', 'b', 'hex'], 'default', 'value' => null],
            [['color_id', 'moderation_id'], 'required'],
            [['color_id', 'moderation_id', 'info_position'], 'integer'],
            [['r', 'g', 'b'], 'number'],
            [['info_id'], 'string', 'max' => 512],
            [['hex'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_id' => 'Color ID',
            'moderation_id' => 'Moderation ID',
            'info_id' => 'Info ID',
            'info_position' => 'Info Position',
            'r' => 'R',
            'g' => 'G',
            'b' => 'B',
            'hex' => 'Hex',
        ];
    }

}