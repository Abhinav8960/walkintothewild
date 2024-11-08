<?php

namespace api\models\posts;

use Yii;

class UserPostCommentLike extends \common\models\postscomment\UserPostCommentLike
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }


    public function getUserPostComment()
    {
        return $this->hasOne(UserPostComment::class, ['id' => 'user_post_comment_id']);
    }

}
