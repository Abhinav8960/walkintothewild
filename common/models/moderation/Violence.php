<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "violence".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $prob
 * @property float|null $physical_violence
 * @property float|null $firearm_threat
 * @property float|null $combat_sport
 */
class Violence extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'violence';
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
            [['info_id', 'info_position', 'prob', 'physical_violence', 'firearm_threat', 'combat_sport'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['prob', 'physical_violence', 'firearm_threat', 'combat_sport'], 'number'],
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
            'prob' => 'Prob',
            'physical_violence' => 'Physical Violence',
            'firearm_threat' => 'Firearm Threat',
            'combat_sport' => 'Combat Sport',
        ];
    }

    public function voilencestore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->prob = $frame['violence']['prob'] ?? 0;;
            $model->physical_violence = $frame['violence']['classes']['physical_violence'] ?? 0;;
            $model->firearm_threat = $frame['violence']['classes']['firearm_threat'] ?? 0;;
            $model->combat_sport = $frame['violence']['classes']['combat_sport'] ?? 0;;

            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }

}