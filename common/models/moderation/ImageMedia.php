<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_media".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property string|null $uri
 */
class ImageMedia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_media';
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
            [['moderation_id', 'media_id', 'uri'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['media_id'], 'string', 'max' => 255],
            [['uri'], 'string', 'max' => 512],
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
            'uri' => 'Uri',
        ];
    }

}
