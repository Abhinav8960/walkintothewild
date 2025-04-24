<?php

namespace api\models\sighting;

use api\models\park\SafariPark;
use api\models\User;
use Yii;


class Sighting extends \common\models\sighting\Sighting
{
    public function fields()
    {
        $fields = parent::fields();

        // $fields[] = 'thumbnail';
        $fields[] = 'locationname';
        $fields[] = 'fullfilepath';
        $fields[] = 'comments';
        $fields[] = 'isLiked';
        $fields[] = 'likesCount';
        $fields[] = 'commentsCount';
        $fields[] = 'sightinguserdetail';
        $fields[] = 'resourceuri';
        $fields[] = 'thumbnail';
        $hold_fields = ['location', 'filepath', 'like_count', 'file', 'total_view', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'video_thumbnail', 'video_thumbnail_path', 'video_thumbnail_etag'];


        return array_diff($fields, $hold_fields);
    }



    public function getComments()
    {
        return $this->hasMany(SightingComment::class, ['sighting_id' => 'id'])->andWhere(['parent_id' => null]);
    }


    public function getFullfilepath()
    {
        if ($this->file) {
            return  'https://d281t0xjcq032r.cloudfront.net/watchpost/' . $this->user_id . '/media/' . $this->file;
        }
        return null;
    }

    // public function getThumbnail()
    // {
    //     // return \Yii::$app->fs->temporaryUrl('images/'.$this->id . '.' . strtolower($this->extension),  new \DateTimeImmutable('+1 Minutes'));

    //     // return $this->filepath;
    //     // return  \Yii::$app->get('fs')->publicUrl('watchpost/' . $this->user_id . '/media/' . $this->file);
    //     return  'https://d281t0xjcq032r.cloudfront.net/watchpost/' . $this->user_id . '/media/' . $this->file;
    // }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getSightinguserdetail()
    {
        return [
            'name' => $this->user ? $this->user->safarioperatorname : '',
            'subtitle' => $this->user ? $this->user->user_handle : '',
            'image' => $this->user ? $this->user->profile_display_image : '',
            'is_followed' => $this->user ? $this->user->is_followed : '',
            'is_safari_operator' => $this->user->operator ? true : false,
            'operator_slug' => $this->user->operator ? $this->user->operator->slug : '',
        ];
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
        return $this->getComments()->andWhere(['sighting_comment.status' => 1])->count();
    }

    public function getSafaripark()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'location']);
    }

    public function getLocationname()
    {
        if ($this->safaripark) {
            return $this->safaripark->title;
        }
        return '';
    }

    public function getResourceuri()
    {
        return Yii::$app->params['frontend_url'] . '/sighting/' . base64_encode($this->id);
    }

    public function getThumbnail()
    {
        return 'https://d26fop8cp5dhfy.cloudfront.net/thumbnail/' . $this->filepath . '.jpg';
    }
}
