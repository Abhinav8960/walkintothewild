<?php

namespace api\models\cms\faqs;

use Yii;

class Faqs extends \common\models\cms\faqs\Faqs
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'question';
        $fields[] = 'answer';
        $hold_fields = ['category_id','sequence', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);

        return $fields;
    }
}
