<?php

namespace api\models\sighting;

use Yii;

class SightingLike extends \common\models\sighting\SightingLike
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
