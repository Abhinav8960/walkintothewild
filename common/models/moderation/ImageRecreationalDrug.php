<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_recreational_drug".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property float|null $prob
 * @property float|null $cannabis
 * @property float|null $cannabis_logo_only
 * @property float|null $cannabis_plant
 * @property float|null $cannabis_drug
 * @property float|null $recreational_drugs_not_cannabis
 */
class ImageRecreationalDrug extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_recreational_drug';
    }

    /**
     * @return Connection the database connection used by this AR class.
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
            [['media_id', 'prob', 'cannabis', 'cannabis_logo_only', 'cannabis_plant', 'cannabis_drug', 'recreational_drugs_not_cannabis'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['prob', 'cannabis', 'cannabis_logo_only', 'cannabis_plant', 'cannabis_drug', 'recreational_drugs_not_cannabis'], 'number'],
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
            'cannabis' => 'Cannabis',
            'cannabis_logo_only' => 'Cannabis Logo Only',
            'cannabis_plant' => 'Cannabis Plant',
            'cannabis_drug' => 'Cannabis Drug',
            'recreational_drugs_not_cannabis' => 'Recreational Drugs Not Cannabis',
        ];
    }

    public static function recreationalDrugStore($feedback, $moderationId)
    {
        if (!isset($feedback['$recreational_drug']) || !is_array($feedback['$recreational_drug'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->prob = $feedback['recreational_drug']['prob'] ?? 0;
        $model->cannabis = $feedback['recreational_drug']['classes']['cannabis'] ?? 0;
        $model->cannabis_logo_only = $feedback['recreational_drug']['classes']['cannabis_logo_only'] ?? 0;
        $model->cannabis_plant = $feedback['recreational_drug']['classes']['cannabis_plant'] ?? 0;
        $model->cannabis_drug = $feedback['recreational_drug']['classes']['cannabis_drug'] ?? 0;
        $model->recreational_drugs_not_cannabis = $feedback['recreational_drug']['classes']['recreational_drugs_not_cannabis'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
