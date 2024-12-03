<?php

namespace api\models\cms\flagreason;
use Yii;


class Flagreason extends \common\models\cms\flagreason\Flagreason
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = [ 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
