<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_gore".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $prob
 * @property float|null $very_bloody
 * @property float|null $slightly_bloody
 * @property float|null $body_organ
 * @property float|null $serious_injury
 * @property float|null $superficial_injury
 * @property float|null $corpse
 * @property float|null $skull
 * @property float|null $unconscious
 * @property float|null $body_waste
 * @property float|null $other
 * @property float|null $animated
 * @property float|null $fake
 * @property float|null $real
 */
class ImageGore extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_gore';
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
            [['media_id', 'prob', 'very_bloody', 'slightly_bloody', 'body_organ', 'serious_injury', 'superficial_injury', 'corpse', 'skull', 'unconscious', 'body_waste', 'other', 'animated', 'fake', 'real'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['prob', 'very_bloody', 'slightly_bloody', 'body_organ', 'serious_injury', 'superficial_injury', 'corpse', 'skull', 'unconscious', 'body_waste', 'other', 'animated', 'fake', 'real'], 'number'],
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
            'very_bloody' => 'Very Bloody',
            'slightly_bloody' => 'Slightly Bloody',
            'body_organ' => 'Body Organ',
            'serious_injury' => 'Serious Injury',
            'superficial_injury' => 'Superficial Injury',
            'corpse' => 'Corpse',
            'skull' => 'Skull',
            'unconscious' => 'Unconscious',
            'body_waste' => 'Body Waste',
            'other' => 'Other',
            'animated' => 'Animated',
            'fake' => 'Fake',
            'real' => 'Real',
        ];
    }

    public static function goreStore($feedback, $moderationId)
    {
        if (!isset($feedback['gore']) || !is_array($feedback['gore'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null; 
        $model->prob = $feedback['gore']['prob'] ?? 0;

        $model->very_bloody = $feedback['gore']['classes']['very_bloody'] ?? 0;
        $model->slightly_bloody = $feedback['gore']['classes']['slightly_bloody'] ?? 0;
        $model->body_organ = $feedback['gore']['classes']['body_organ'] ?? 0;
        $model->serious_injury = $feedback['gore']['classes']['serious_injury'] ?? 0;
        $model->superficial_injury = $feedback['gore']['classes']['superficial_injury'] ?? 0;
        $model->corpse = $feedback['gore']['classes']['corpse'] ?? 0;
        $model->skull = $feedback['gore']['classes']['skull'] ?? 0;
        $model->unconscious = $feedback['gore']['classes']['unconscious'] ?? 0;
        $model->body_waste = $feedback['gore']['classes']['body_waste'] ?? 0;
        $model->other = $feedback['gore']['classes']['other'] ?? 0;

        $model->animated = $feedback['gore']['type']['animated'] ?? 0;
        $model->fake = $feedback['gore']['type']['fake'] ?? 0;
        $model->real = $feedback['gore']['type']['real'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
