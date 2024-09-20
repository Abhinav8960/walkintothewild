<?php

namespace api\models\park;

use api\models\master\animal\MasterAnimal;
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
class SafariParkAnimal extends \common\models\park\SafariParkAnimal
{


    public function getSafaripark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'safari_park_id']);
    }

    public function getSafariparkanimalinfo()
    {
        return $this->hasOne(MasterAnimal::className(), ['id' => 'master_animal_id']);
    }
}
