<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_tobacco".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property float|null $prob
 * @property float|null $regular_tobacco
 * @property float|null $ambiguous_tobacco
 */
class ImageTobacco extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_tobacco';
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
            [['moderation_id', 'media_id', 'prob', 'regular_tobacco', 'ambiguous_tobacco'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['prob', 'regular_tobacco', 'ambiguous_tobacco'], 'number'],
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
            'prob' => 'Prob',
            'regular_tobacco' => 'Regular Tobacco',
            'ambiguous_tobacco' => 'Ambiguous Tobacco',
        ];
    }

    public static function tobaccoStore($feedback, $moderationId)
    {
        // if (!isset($feedback['tobacco']) || !is_array($feedback['tobacco'])) {
        //     return false;
        // }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->prob = $feedback['tobacco']['prob'] ?? 0;
        $model->regular_tobacco = $feedback['tobacco']['classes']['regular_tobacco'] ?? 0;
        $model->ambiguous_tobacco = $feedback['tobacco']['classes']['ambiguous_tobacco'] ?? 0;

        if (!$model->save()) {
            return false;
        }

        return true;
    }
}
