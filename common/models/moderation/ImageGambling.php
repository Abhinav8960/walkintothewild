<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_gambling".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $prob
 */
class ImageGambling extends ActiveRecord
{

    public static $accessible_attributes = ['prob'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_gambling';
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
            [['media_id', 'prob'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['prob'], 'number'],
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
        ];
    }

    public static function gamblingStore($feedback, $moderationId)
    {
        if (!isset($feedback['gambling']) || !is_array($feedback['gambling'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->prob = $feedback['gambling']['prob'] ?? 0; 

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
