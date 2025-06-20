<?php

namespace api\models\sighting;

class SightingReport extends \common\models\sighting\SightingReport
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
    }
}
