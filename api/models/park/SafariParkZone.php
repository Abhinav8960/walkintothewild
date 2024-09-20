<?php

namespace api\models\park;

use Yii;

/**
 * This is the model class for table "safari_park_zone".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property int $master_zone_type_id
 * @property int $master_zone_type_name
 * @property string $zone_name
 * @property string $entry_gate_name
 * @property string|null $entry_gate_latitude
 * @property string|null $entry_gate_longitude
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariParkZone extends \common\models\park\SafariParkZone
{
    public function fields()
    {
        $fields = parent::fields();
        


        $hold_fields = [
            'safari_park_id',
            'master_zone_type_id',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
