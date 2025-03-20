<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_sharpness".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $sharpness
 */
class ImageSharpness extends ActiveRecord
{

    public static $accessible_attributes = ['sharpness'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_sharpness';
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
            [['media_id', 'sharpness'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['sharpness'], 'number'],
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
            'sharpness' => 'Sharpness',
        ];
    }

    public static function sharpnessStore($feedback, $moderationId)
    {
        if (!isset($feedback['sharpness'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->sharpness = $feedback['sharpness'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
