<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "recreational_drug".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $prob
 * @property float|null $cannabis
 * @property float|null $cannabis_logo_only
 * @property float|null $cannabis_plant
 * @property float|null $cannabis_drug
 * @property float|null $recreational_drugs_not_cannabis
 */
class RecreationalDrug extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recreational_drug';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'prob', 'cannabis', 'cannabis_logo_only', 'cannabis_plant', 'cannabis_drug', 'recreational_drugs_not_cannabis'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['prob', 'cannabis', 'cannabis_logo_only', 'cannabis_plant', 'cannabis_drug', 'recreational_drugs_not_cannabis'], 'number'],
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
            'cannabis' => 'Cannabis',
            'cannabis_logo_only' => 'Cannabis Logo Only',
            'cannabis_plant' => 'Cannabis Plant',
            'cannabis_drug' => 'Cannabis Drug',
            'recreational_drugs_not_cannabis' => 'Recreational Drugs Not Cannabis',
        ];
    }

    public static function recreationaldrugstore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->prob = $frame['recreational_drug']['prob'] ?? 0;
            $model->cannabis = $frame['recreational_drug']['classes']['cannabis'] ?? 0;
            $model->cannabis_logo_only = $frame['recreational_drug']['classes']['cannabis_logo_only'] ?? 0;
            $model->cannabis_plant = $frame['recreational_drug']['classes']['cannabis_plant'] ?? 0;
            $model->cannabis_drug = $frame['recreational_drug']['classes']['cannabis_drug'] ?? 0;
            $model->recreational_drugs_not_cannabis = $frame['recreational_drug']['classes']['recreational_drugs_not_cannabis'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }

}