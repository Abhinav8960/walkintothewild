<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_military".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property string|null $prob
 * @property float|null $military_equipment
 * @property float|null $military_personnel
 * @property float|null $military_profile_photo
 */
class ImageMilitary extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_military';
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
            [['moderation_id', 'media_id', 'prob', 'military_equipment', 'military_personnel', 'military_profile_photo'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['military_equipment', 'military_personnel', 'military_profile_photo'], 'number'],
            [['media_id', 'prob'], 'string', 'max' => 255],
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
            'military_equipment' => 'Military Equipment',
            'military_personnel' => 'Military Personnel',
            'military_profile_photo' => 'Military Profile Photo',
        ];
    }

    public static function militaryStore($feedback, $moderationId)
    {
        if (!isset($feedback['military']) || !is_array($feedback['military'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->prob = $feedback['military']['prob'] ?? 0; 

        $model->military_equipment = $feedback['military']['classes']['military_equipment'] ?? 0;
        $model->military_personnel = $feedback['military']['classes']['military_personnel'] ?? 0;
        $model->military_profile_photo = $feedback['military']['classes']['military_profile_photo'] ?? 0;

        if (!$model->save()) {
            return false;
        }

        return true;
    }
}
