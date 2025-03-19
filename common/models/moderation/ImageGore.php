<?php

namespace common\models\moderation;

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
class ImageGore extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_gore';
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

}
