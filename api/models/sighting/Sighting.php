<?php

namespace api\models\sighting;

use api\models\User;
use Yii;


class Sighting extends \common\models\sighting\Sighting
{
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'thumbnail';
        $fields[] = 'filepath';
        // $fields[] = 'user';
        $fields[] = 'comments';
        $fields[] = 'isLiked';
        $fields[] = 'likesCount';
        $fields[] = 'commentsCount';
        $hold_fields = ['like_count', 'file', 'total_view', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];


        return array_diff($fields, $hold_fields);
    }



    public function getComments()
    {
        return $this->hasMany(SightingComment::class, ['sighting_id' => 'id'])->andWhere(['parent_id' => null]);
    }


    public function getFilepath()
    {
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


    public function getIsLiked()
    {
        $is_liked = SightingLike::find()->where(['sighting_id' => $this->id, 'user_id' => \Yii::$app->params['active_user_id'], 'sighting_like.status' => 1])->limit(1)->one();
        if ($is_liked) {
            return true;
        }
        return false;
    }


    public function getLike()
    {
        return $this->hasMany(SightingLike::class, ['sighting_id' => 'id']);
    }

    public function getLikesCount()
    {
        return $this->getLike()->count();
    }

    public function getCommentsCount()
    {
        return $this->getComments()->where(['sighting_comment.status' => 1])->count();
    }
}
