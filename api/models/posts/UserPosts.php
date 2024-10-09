<?php

namespace api\models\posts;

use Yii;

class UserPosts extends \common\models\UserPosts
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'imagepath';
        $hold_fields = ['file', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);

        return $fields;
    }

    public function getImagepath()
    {
        if ($this->file != '') {
            return Yii::$app->params['frontend_url'] . 'storage/userpost/' . $this->user_id . '/' . $this->file;
        }
    }
}
