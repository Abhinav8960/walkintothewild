<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_violence".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property float|null $prob
 * @property float|null $physical_violence
 * @property float|null $firearm_threat
 * @property float|null $combat_sport
 */
class ImageViolence extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_violence';
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
            [['moderation_id', 'media_id', 'prob', 'physical_violence', 'firearm_threat', 'combat_sport'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['prob', 'physical_violence', 'firearm_threat', 'combat_sport'], 'number'],
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
            'physical_violence' => 'Physical Violence',
            'firearm_threat' => 'Firearm Threat',
            'combat_sport' => 'Combat Sport',
        ];
    }

}
