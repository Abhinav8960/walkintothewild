<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_colors_other".
 *
 * @property int $id
 * @property int $color_id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $r
 * @property float|null $g
 * @property float|null $b
 * @property string|null $hex
 */
class ImageColorsOther extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_colors_other';
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
            [['media_id', 'r', 'g', 'b', 'hex'], 'default', 'value' => null],
            [['color_id', 'moderation_id'], 'required'],
            [['color_id', 'moderation_id'], 'integer'],
            [['r', 'g', 'b'], 'number'],
            [['media_id'], 'string', 'max' => 512],
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
            'media_id' => 'Media ID',
            'r' => 'R',
            'g' => 'G',
            'b' => 'B',
            'hex' => 'Hex',
        ];
    }

}
