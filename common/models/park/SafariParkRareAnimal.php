<?php

namespace common\models\park;

use Yii;
use common\models\master\animal\MasterRareAnimal;

/**
 * This is the model class for table "safari_park_rare_animal".
 *
 * @property int $id
 * @property int|null $safari_park_id
 * @property int|null $master_rare_animal_id
 * @property string|null $animal_name
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class SafariParkRareAnimal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_park_rare_animal';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id', 'master_rare_animal_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['animal_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park ID',
            'master_rare_animal_id' => 'Master Rare Animal ID',
            'animal_name' => 'Animal Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }


    public function getRareanimal()
    {
        return $this->hasOne(MasterRareAnimal::className(), ['id' => 'master_rare_animal_id']);
    }

    public function getSafaripark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'safari_park_id']);
    }
}
