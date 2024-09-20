<?php

namespace api\models\master\state;

use api\models\master\country\MasterCountry;
use api\models\master\location\MasterLocation;
use api\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_state".
 *
 * @property int $id
 * @property string $state_name
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterState extends \common\models\master\state\MasterState
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'country_id', 'location_id',  'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getCountry()
    {
        return $this->hasOne(MasterCountry::className(), ['id' => 'country_id']);
    }

    public function getLocation()
    {
        return $this->hasOne(MasterLocation::className(), ['id' => 'location_id']);
    }
}
