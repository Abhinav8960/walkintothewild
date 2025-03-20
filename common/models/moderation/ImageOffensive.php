<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_offensive".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $nazi
 * @property float|null $asian_swastika
 * @property float|null $confederate
 * @property float|null $supremacist
 * @property float|null $terrorist
 * @property float|null $middle_finger
 */
class ImageOffensive extends ActiveRecord
{

    public static $accessible_attributes = ['nazi', 'asian_swastika', 'confederate', 'supremacist', 'terrorist', 'middle_finger'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_offensive';
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
            [['media_id', 'nazi', 'asian_swastika', 'confederate', 'supremacist', 'terrorist', 'middle_finger'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['nazi', 'asian_swastika', 'confederate', 'supremacist', 'terrorist', 'middle_finger'], 'number'],
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
            'nazi' => 'Nazi',
            'asian_swastika' => 'Asian Swastika',
            'confederate' => 'Confederate',
            'supremacist' => 'Supremacist',
            'terrorist' => 'Terrorist',
            'middle_finger' => 'Middle Finger',
        ];
    }

    public static function offensiveStore($feedback, $moderationId)
    {
        if (!isset($feedback['offensive']) || !is_array($feedback['offensive'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->nazi = $feedback['offensive']['nazi'] ?? 0;
        $model->asian_swastika = $feedback['offensive']['asian_swastika'] ?? 0;
        $model->confederate = $feedback['offensive']['confederate'] ?? 0;
        $model->supremacist = $feedback['offensive']['supremacist'] ?? 0;
        $model->terrorist = $feedback['offensive']['terrorist'] ?? 0;
        $model->middle_finger = $feedback['offensive']['middle_finger'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
