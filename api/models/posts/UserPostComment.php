<?php

namespace api\models\posts;

use Yii;
use api\models\User;


class UserPostComment extends \common\models\postscomment\UserPostComment
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'user';
        $fields[] = 'replies';
        $hold_fields = ['id','user_posts_id', 'user_id', 'parent_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }


    public function getUserPost()
    {
        return $this->hasOne(UserPosts::className(), ['id' => 'user_posts_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

}
