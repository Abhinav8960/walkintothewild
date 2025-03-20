<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_brightness".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $brightness
 */
class ImageBrightness extends ActiveRecord
{

    public static $accessible_attributes = ['brightness'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_brightness';
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
            [['media_id', 'brightness'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['brightness'], 'number'],
            [['media_id'], 'string', 'max' => 512],
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
            'brightness' => 'Brightness',
        ];
    }

    public static function brightnessStore($feedback, $moderationId)
    {
        // echo "<pre>";
        // print_r([$feedback['brightness'], $feedback]);
        // print_r($feedback);

        // die;

        if (!isset($feedback['brightness'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->brightness = $feedback['brightness'] ?? 0;


        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
