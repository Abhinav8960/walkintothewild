<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_self_harm".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property float|null $prob
 * @property float|null $real
 * @property float|null $fake
 * @property float|null $animated
 */
class ImageSelfHarm extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_self_harm';
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
            [['moderation_id', 'media_id', 'prob', 'real', 'fake', 'animated'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['prob', 'real', 'fake', 'animated'], 'number'],
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
            'real' => 'Real',
            'fake' => 'Fake',
            'animated' => 'Animated',
        ];
    }

}
