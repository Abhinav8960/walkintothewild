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
        $fields[] = 'isLiked';
        $fields[] = 'likedCount';
        $hold_fields = ['user_posts_id', 'user_id', 'parent_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
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

    public function getIsLiked()
    {
        $is_liked = UserPostCommentLike::find()->where(['user_post_comment_id' => $this->id, 'user_id' => \Yii::$app->params['active_user_id'], 'user_post_comment_like.status' => 1])->limit(1)->one();
        if ($is_liked) {
            return true;
        }
        return false;
    }

    public function getLike()
    {
        return $this->hasMany(UserPostCommentLike::class, ['user_post_comment_id' => 'id'])->andWhere(['user_post_comment_like.status' => 1]);
    }

    public function getLikedCount()
    {
        return $this->getLike()->count();
    }

}
