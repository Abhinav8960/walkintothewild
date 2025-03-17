<?php

namespace api\models\posts;

use api\models\User;
use Yii;

class UserPosts extends \common\models\UserPosts
{
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'thumbnail';
        if (!in_array(\Yii::$app->controller->action->uniqueId,  ['posts/default/index'])) {
            $fields[] = 'imagepath';
            $fields[] = 'comments';
            $hold_fields = ['type_of_post', 'file', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        } else {
            $fields[] = 'imagepath';
            $fields[] = 'user';
            $hold_fields = ['type_of_post', 'file', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        }

        return array_diff($fields, $hold_fields);
        return $fields;
    }

    // public function getImagepath()
    // {
    //     if ($this->file != '') {
    //         return Yii::$app->params['frontend_url'] . 'storage/userpost/' . $this->user_id . '/' . $this->file;
    //     }
    // }


    public function getComments()
    {
        return $this->hasMany(UserPostComment::class, ['user_posts_id' => 'id']);
    }


    public function getImagepath()
    {
        // return \Yii::$app->fs->temporaryUrl('images/'.$this->id . '.' . strtolower($this->extension),  new \DateTimeImmutable('+1 Minutes'));

        // return $this->filepath;
        // return  \Yii::$app->get('fs')->publicUrl('watchpost/' . $this->user_id . '/media/' . $this->file);
        return  'https://d281t0xjcq032r.cloudfront.net/watchpost/' . $this->user_id . '/media/' . $this->file;
    }

    public function getThumbnail()
    {
        // return \Yii::$app->fs->temporaryUrl('images/'.$this->id . '.' . strtolower($this->extension),  new \DateTimeImmutable('+1 Minutes'));

        // return $this->filepath;
        // return  \Yii::$app->get('fs')->publicUrl('watchpost/' . $this->user_id . '/media/' . $this->file);
        return  'https://d281t0xjcq032r.cloudfront.net/watchpost/' . $this->user_id . '/media/' . $this->file;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
