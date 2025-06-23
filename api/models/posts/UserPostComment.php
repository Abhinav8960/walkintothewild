<?php

namespace api\models\posts;

use Yii;
use api\models\User;
use common\models\GeneralModel;

class UserPostComment extends \common\models\postscomment\UserPostComment
{
    public function fields()
    {
        // $fields = parent::fields();
        // $fields[] = 'user';
        // $fields[] = 'replies';
        // $fields[] = 'is_liked';
        // $fields[] = 'liked_count';
        // $hold_fields = ['user_posts_id', 'user_id', 'parent_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        // return array_diff($fields, $hold_fields);
        // return $fields;
        $fields = ['id', 'safari_operator_id', 'comment' => function ($model) {
            return GeneralModel::apicommentConversion($model->comment);
        }, 'dateTime', 'flaged' => function () {
            return (bool) $this->flaged;
        }, 'user', 'replies', 'is_liked', 'liked_count', 'date_time'];

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
        return $this->hasMany(self::class, ['parent_id' => 'id'])->andWhere(['user_post_comment.status' => 1]);
    }

    public function getIs_liked()
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

    public function getLiked_count()
    {
        return $this->getLike()->count();
    }

    public function getDate_time()
    {
        return strtotime($this->dateTime);
    }
}
