<?php

namespace api\models\posts;

use api\models\User;
use Yii;

class UserPosts extends \common\models\UserPosts
{
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'id';
        $fields[] = 'full_image_path';
        $fields[] = 'comments';
        $fields[] = 'is_liked';
        $fields[] = 'likes_count';
        $fields[] = 'comments_count';
        $fields[] = 'post_user_detail';
        $fields[] = 'resource_uri';
        $fields[] = 'thumbnails';
        
        $hold_fields = ['etag', 'size', 'height', 'width', 'filepath', 'file', 'total_view', 'status', 'created_by', 'updated_by','comment_count','like_count'];

        return array_diff($fields, $hold_fields);
    }



    public function getComments()
    {
        return $this->hasMany(UserPostComment::class, ['user_posts_id' => 'id'])->andWhere(['parent_id' => null])->andWhere(['user_post_comment.status' => 1]);
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

    public function getPost_user_detail()
    {
        return [
            'name' => $this->user ? $this->user->name : '',
            'subtitle' => $this->user ? $this->user->user_handle : '',
            'image' => $this->user ? $this->user->profile_display_image : '',
            'is_followed' => $this->user ? $this->user->is_followed : '',
            'is_safari_operator' => $this->user->operator ? true : false,
            'operator_slug' => $this->user->operator ? $this->user->operator->slug : '',
        ];
    }


    public function getIs_liked()
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

    public function getLikes_count()
    {
        // return $this->getLike()->count();
        return $this->like_count;
    }

    public function getComments_count()
    {
        // return $this->getComments()->count();
        return $this->comment_count;
    }

    public function getResource_uri()
    {
        return Yii::$app->params['frontend_url'] . '/posts/' . base64_encode($this->id);
    }

    public function getFull_image_path()
    {
        // return \Yii::$app->fs->temporaryUrl('images/'.$this->id . '.' . strtolower($this->extension),  new \DateTimeImmutable('+1 Minutes'));

        // return $this->filepath;
        // return  \Yii::$app->get('fs')->publicUrl('watchpost/' . $this->user_id . '/media/' . $this->file);
        if ($this->file) {
            return  Yii::$app->params['s3_endpoint'] . '/' . $this->filepath;
        }
        return null;
    }

    public function getThumbnails()
    {
        if(!empty($this->filepath)){
            return $arr = [
                'high' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/high/' . $this->filepath,
                'standard' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/standard/' . $this->filepath,
                'medium' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/medium/' . $this->filepath,
                'low' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/low/' . $this->filepath,
            ];
        }
        return NULL;
    }
}
