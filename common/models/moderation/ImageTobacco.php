<?php

namespace common\models\moderation;

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
class ImageTobacco extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_tobacco';
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

}
