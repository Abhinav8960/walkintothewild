<?php

namespace api\models\master\vehicle;

use Yii;

/**
 * This is the model class for table "master_vehicle".
 *
 * @property int $id
 * @property string $vehicle_name
 * @property string|null $icon
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterVehicle extends \common\models\master\vehicle\MasterVehicle
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'image_path';
        $hold_fields = ['status', 'icon', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }


    public function getImage_path()
    {
        if ($this->icon != '') {
            return \Yii::$app->params['s3_endpoint'] . '/vehicle/' . $this->id . '/' . $this->icon;
        }
    }
}
