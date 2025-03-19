<?php

namespace common\models\moderation;

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
class ImageOffensive extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_offensive';
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

}
