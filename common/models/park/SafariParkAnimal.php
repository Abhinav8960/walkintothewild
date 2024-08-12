<?php

namespace common\models\park;

use common\traits\CommanRelationship;
use common\models\master\animal\MasterAnimal;
use Yii;

/**
 * This is the model class for table "safari_parks_animal".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property int $master_animal_id
 * @property string|null $animal_name
 * @property int $status
 */
class SafariParkAnimal extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_parks_animal';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id', 'master_animal_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
            'master_animal_id' => 'Master Animals ID',
            'animal_name' => 'Animal Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getSafaripark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'safari_park_id']);
    }

    public function getSafariparkanimalinfo()
    {
        return $this->hasOne(MasterAnimal::className(), ['id' => 'master_animal_id']);
    }
}
