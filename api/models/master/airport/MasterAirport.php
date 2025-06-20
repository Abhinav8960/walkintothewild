<?php

namespace api\models\master\airport;

use api\models\master\city\MasterCity;
use api\models\master\country\MasterCountry;
use api\models\master\state\MasterState;
use Yii;

class MasterAirport extends \common\models\master\airport\MasterAirport
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'city';
        $fields[] = 'state';
        $fields[] = 'country';
        $hold_fields = ['status', 'country_id', 'state_id', 'city_id', 'created_by', 'updated_by', 'created_at', 'updated_at'];
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
