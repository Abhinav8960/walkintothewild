<?php

namespace api\models\master\railwaystation;

use api\models\master\city\MasterCity;
use api\models\master\country\MasterCountry;
use api\models\master\state\MasterState;
use api\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_railway_station".
 *
 * @property int $id
 * @property string|null $title
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterRailwayStation extends  \common\models\master\railwaystation\MasterRailwayStation
{

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'city';
        $fields[] = 'state';
        $fields[] = 'country';
        $hold_fields = ['status', 'city_id', 'state_id', 'country_id', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'city_id']);
    }
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'state_id']);
    }
    public function getCountry()
    {
        return $this->hasOne(MasterCountry::className(), ['id' => 'country_id']);
    }
}
