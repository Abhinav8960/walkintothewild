<?php

namespace api\models\posts;

use Yii;

class UserPostLike extends \common\models\postscomment\UserPostLike
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
