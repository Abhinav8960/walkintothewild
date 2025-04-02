<?php

namespace api\models\posts;

use api\models\User;
use Yii;

class UserPosts extends \common\models\UserPosts
{
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'imagepath';
        $fields[] = 'comments';
        $fields[] = 'isLiked';
        $fields[] = 'likesCount';
        $fields[] = 'commentsCount';
        $fields[] = 'postuserdetail';
        $hold_fields = ['file', 'total_view', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];

        return array_diff($fields, $hold_fields);
    }



    public function getComments()
    {
        return $this->hasMany(UserPostComment::class, ['user_posts_id' => 'id'])->andWhere(['parent_id' => null]);
    }


    public function getImagepath()
    {
        // return \Yii::$app->fs->temporaryUrl('images/'.$this->id . '.' . strtolower($this->extension),  new \DateTimeImmutable('+1 Minutes'));

        // return $this->filepath;
        // return  \Yii::$app->get('fs')->publicUrl('watchpost/' . $this->user_id . '/media/' . $this->file);
        return  'https://d281t0xjcq032r.cloudfront.net/post/' . $this->user_id . '/media/' . $this->file;
    }

    // public function getThumbnail()
    // {
    //     // return \Yii::$app->fs->temporaryUrl('images/'.$this->id . '.' . strtolower($this->extension),  new \DateTimeImmutable('+1 Minutes'));

    //     // return $this->filepath;
    //     // return  \Yii::$app->get('fs')->publicUrl('watchpost/' . $this->user_id . '/media/' . $this->file);
    //     return  'https://d281t0xjcq032r.cloudfront.net/post/' . $this->user_id . '/media/' . $this->file;
    // }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPostuserdetail()
    {
        return [
            'name' => $this->user ? $this->user->name : '',
            'subtitle' => $this->user ? $this->user->user_handle : '',
            'image' => $this->user ? $this->user->profileimage : '',
        ];
    }


    public function getIsLiked()
    {
        $is_liked = UserPostLike::find()->where(['user_post_id' => $this->id, 'user_id' => \Yii::$app->params['active_user_id'], 'user_post_like.status' => 1])->limit(1)->one();
        if ($is_liked) {
            return true;
        }
        return false;
    }


    public function getLike()
    {
        return $this->hasMany(UserPostLike::class, ['user_post_id' => 'id']);
    }

    public function getLikesCount()
    {
        return $this->getLike()->count();
    }

    public function getCommentsCount()
    {
        return $this->getComments()->where(['user_post_comment.status' => 1])->count();
    }
}
