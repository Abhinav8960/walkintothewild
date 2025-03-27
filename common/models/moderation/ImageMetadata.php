<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_metadata".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $size
 * @property string|null $height
 * @property string|null $width
 * @property string|null $extension
 * @property string|null $resolution
 * @property string|null $orientation
 * @property string|null $uploaded_at
 */
class ImageMetadata extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_metadata';
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
            [['moderation_id', 'size', 'height', 'width', 'extension', 'resolution', 'orientation', 'uploaded_at'], 'default', 'value' => null],
            [['moderation_id'], 'integer'],
            [['size', 'height', 'width', 'extension', 'resolution', 'orientation', 'uploaded_at'], 'string', 'max' => 255],
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
            'size' => 'Size',
            'height' => 'Height',
            'width' => 'Width',
            'extension' => 'Extension',
            'resolution' => 'Resolution',
            'orientation' => 'Orientation',
            'uploaded_at' => 'Uploaded At',
        ];
    }

    public function getMetaAttributes()
    {
        return [

            'Size' => $this->size,
            'Height' => $this->height,
            'Width' => $this->width,
            'Extension' => $this->extension,
            'Resolution' => $this->resolution,
            'Orientation' => $this->orientation,
            // 'Uploaded At' => $this->uploaded_at,
        ];
    }
}
