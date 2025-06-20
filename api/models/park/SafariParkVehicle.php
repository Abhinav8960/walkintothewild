<?php

namespace api\models\park;

use api\models\master\vehicle\MasterVehicle;
use Yii;

/**
 * This is the model class for table "parks_vehicle".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property int $vehicle_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariParkVehicle extends \common\models\park\SafariParkVehicle
{
    public function getMastervehicle()
    {
        return $this->hasOne(MasterVehicle::className(), ['id' => 'vehicle_id']);
    }
}
