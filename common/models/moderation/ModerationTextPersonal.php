<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "moderation_text_personal".
 *
 * @property int $id
 * @property int $moderation_text_id
 * @property string $type
 * @property string|null $category
 * @property string|null $match
 * @property string|null $start
 * @property string|null $end
 * @property int $sequnce
 */
class ModerationTextPersonal extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moderation_text_personal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'match', 'start', 'end'], 'default', 'value' => null],
            [['sequnce'], 'default', 'value' => 1],
            [['moderation_text_id', 'type'], 'required'],
            [['moderation_text_id', 'sequnce'], 'integer'],
            [['type', 'category', 'match', 'start', 'end'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moderation_text_id' => 'Moderation ID',
            'type' => 'Type',
            'category' => 'Category',
            'match' => 'Match',
            'start' => 'Start',
            'end' => 'End',
            'sequnce' => 'Sequnce',
        ];
    }

}