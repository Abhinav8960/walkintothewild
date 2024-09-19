<?php

namespace api\models\master\country;

use Yii;


class MasterCountry extends \common\models\master\country\MasterCountry
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
