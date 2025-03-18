<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "offensive".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $nazi
 * @property float|null $asian_swastika
 * @property float|null $confederate
 * @property float|null $supremacist
 * @property float|null $terrorist
 * @property float|null $middle_finger
 */
class Offensive extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offensive';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'nazi', 'asian_swastika', 'confederate', 'supremacist', 'terrorist', 'middle_finger'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['nazi', 'asian_swastika', 'confederate', 'supremacist', 'terrorist', 'middle_finger'], 'number'],
            [['info_id'], 'string', 'max' => 512],
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
            'info_id' => 'Info ID',
            'info_position' => 'Info Position',
            'nazi' => 'Nazi',
            'asian_swastika' => 'Asian Swastika',
            'confederate' => 'Confederate',
            'supremacist' => 'Supremacist',
            'terrorist' => 'Terrorist',
            'middle_finger' => 'Middle Finger',
        ];
    }


    public function offensivestore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->nazi = $frame['offensive']['nazi'] ?? 0;
            $model->asian_swastika = $frame['offensive']['asian_swastika'] ?? 0;
            $model->confederate = $frame['offensive']['confederate'] ?? 0;
            $model->supremacist = $frame['offensive']['supremacist'] ?? 0;
            $model->terrorist = $frame['offensive']['terrorist'] ?? 0;
            $model->middle_finger = $frame['offensive']['middle_finger'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}
