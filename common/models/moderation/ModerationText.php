<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "moderation_text".
 *
 * @property int $id
 * @property string $moderation_id
 * @property float $sexual
 * @property float $discriminatory
 * @property float $insulting
 * @property float $violent
 * @property float $toxic
 * @property float $self_harm
 * @property int $personal
 * @property int $link
 */
class ModerationText extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moderation_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['self_harm'], 'default', 'value' => 0.000],
            [['link'], 'default', 'value' => 0],
            [['moderation_id'], 'required'],
            [['sexual', 'discriminatory', 'insulting', 'violent', 'toxic', 'self_harm'], 'number'],
            [['personal', 'link'], 'integer'],
            [['moderation_id'], 'string', 'max' => 255],
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
            'sexual' => 'Sexual',
            'discriminatory' => 'Discriminatory',
            'insulting' => 'Insulting',
            'violent' => 'Violent',
            'toxic' => 'Toxic',
            'self_harm' => 'Self Harm',
            'personal' => 'Personal',
            'link' => 'Link',
        ];
    }
}
