<?php

namespace api\models\sharesafari;

use Yii;

class ShareSafariFaq extends \common\models\sharesafari\ShareSafariFaq
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['share_safari_id','faq_id','position','status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
   
}
