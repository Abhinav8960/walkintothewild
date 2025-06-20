<?php

namespace api\models\cms\contentmanagement;

use Yii;

class ContentManagement extends \common\models\cms\contentmanagement\ContentManagement
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['type', 'remark', 'id', 'name', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);

        return $fields;
    }
}
