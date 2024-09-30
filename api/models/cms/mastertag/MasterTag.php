<?php

namespace api\models\cms\mastertag;

use Yii;

class MasterTag extends  \common\models\cms\mastertag\MasterTag
{

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'title';
        $fields[] = 'slug';
        $hold_fields = ['sequence','view','total_view','status','created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
