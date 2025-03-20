<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "moderation_text".
 *
 * @property int $id
 * @property string $moderation_id
 * @property string|null $request_id
 * @property string|null $request_timestamp
 * @property string|null $moderation_type
 * @property float $sexual
 * @property float $discriminatory
 * @property float $insulting
 * @property float $violent
 * @property float $toxic
 * @property float $self_harm
 * @property int $personal
 * @property int $link
 */
class ModerationText extends \common\models\moderation\ActiveRecord
{
    public static $accessible_attributes = ['sexual', 'discriminatory', 'insulting', 'violent', 'toxic', 'self_harm'];

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
            [['moderation_id'], 'required'],
            [['request_id', 'request_timestamp', 'moderation_type'], 'string', 'max' => 255],
            [['sexual', 'discriminatory', 'insulting', 'violent', 'toxic', 'self_harm'], 'number'],
            [['personal', 'link'], 'integer'],
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
            'request_id' => 'Request ID',
            'request_timestamp' => 'Request Timestamp',
            'moderation_type' => 'Moderation Type',
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

    public function getModerationTextPersonal()
    {
        return $this->hasMany(ModerationTextPersonal::className(), ['moderation_text_id' => 'id']);
    }
}
