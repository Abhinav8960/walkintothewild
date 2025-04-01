<?php

namespace api\models\sighting;

use Yii;

class SightingCommentLike extends \common\models\sighting\SightingCommentLike
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }


    public function getSightingComment()
    {
        return $this->hasOne(SightingComment::class, ['id' => 'sighting_comment_id']);
    }
}
