<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_medical".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $prob
 * @property float|null $pills
 * @property float|null $paraphernalia
 */
class ImageMedical extends ActiveRecord
{

    public static $accessible_attributes = ['prob', 'pills', 'paraphernalia'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_medical';
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
            [['media_id', 'prob', 'pills', 'paraphernalia'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['prob', 'pills', 'paraphernalia'], 'number'],
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
            'prob' => 'Prob',
            'pills' => 'Pills',
            'paraphernalia' => 'Paraphernalia',
        ];
    }

    public static function medicalStore($feedback, $moderationId)
    {
        if (!isset($feedback['medical']) || !is_array($feedback['medical'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->prob = $feedback['medical']['prob'] ?? 0;
        $model->pills = $feedback['medical']['classes']['pills'] ?? 0;
        $model->paraphernalia = $feedback['medical']['classes']['paraphernalia'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
