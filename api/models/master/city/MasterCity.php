<?php

namespace api\models\master\city;

use api\models\master\country\MasterCountry;
use api\models\master\state\MasterState;
use Yii;

class MasterCity extends \common\models\master\city\MasterCity
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'country_id', 'state_id', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
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
