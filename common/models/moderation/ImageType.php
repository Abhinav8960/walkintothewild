<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_type".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property float|null $photo
 * @property float|null $illustration
 * @property float|null $ai_generated
 */
class ImageType extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_type';
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
            [['moderation_id', 'media_id', 'photo', 'illustration', 'ai_generated'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['photo', 'illustration', 'ai_generated'], 'number'],
            [['media_id'], 'string', 'max' => 255],
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
            'photo' => 'Photo',
            'illustration' => 'Illustration',
            'ai_generated' => 'Ai Generated',
        ];
    }

    public static function typeStore($feedback, $moderationId)
    {
        // if (!isset($feedback['type']) || !is_array($feedback['type'])) {
        //     return false;
        // }

            $model = new self();
            $model->moderation_id = $moderationId;
            $model->media_id = $feedback['media']['id'] ?? null;
            $model->photo = $feedback['type']['photo'] ?? 0;
            $model->illustration = $feedback['type']['illustration'] ?? 0;
            $model->ai_generated = $feedback['type']['ai_generated'] ?? 0;
            // $model->deepfake = $feedback['type']['deepfake'] ?? 0;
            if (!$model->save(false)) {
                return false;
            }

        return true;
    }
}
