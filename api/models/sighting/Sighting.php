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
        $fields[] = 'location_name';
        $fields[] = 'full_file_path';
        $fields[] = 'comments';
        $fields[] = 'is_liked';
        $fields[] = 'likes_count';
        $fields[] = 'comments_count';
        $fields[] = 'sighting_user_detail';
        $fields[] = 'resource_uri';
        $fields[] = 'thumbnail';
        $fields[] = 'thumbnails';
        $hold_fields = [
            'height',
            'width',
            'latitude',
            'longitude',
            'v_size',
            'v_duration',
            'etag',
            'location',
            'filepath',
            'like_count',
            'file',
            'total_view',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'video_thumbnail',
            'video_thumbnail_path',
            'video_thumbnail_etag'
        ];


        return array_diff($fields, $hold_fields);
    }



    public function getComments()
    {
        return $this->hasMany(SightingComment::class, ['sighting_id' => 'id'])->andWhere(['parent_id' => null]);
    }


    public function getFull_file_path()
    {
        if ($this->file) {
            return  Yii::$app->params['s3_endpoint'] . '/watchpost/' . $this->user_id . '/media/' . $this->file;
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

    public function getSighting_user_detail()
    {
        return [
            'name' => $this->user ? $this->user->partnername : '',
            'subtitle' => $this->user ? $this->user->user_handle : '',
            'image' => $this->user ? $this->user->profile_display_image : '',
            'is_followed' => $this->user ? $this->user->is_followed : '',
            'is_safari_operator' => $this->user->operator ? true : false,
            'operator_slug' => $this->user->operator ? $this->user->operator->slug : '',
        ];
    }

    public function getIs_liked()
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

    public function getLikes_count()
    {
        return $this->getLike()->count();
    }

    public function getComments_count()
    {
        return $this->getComments()->andWhere(['sighting_comment.status' => 1])->count();
    }

    public function getSafaripark()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'location']);
    }

    public function getLocation_name()
    {
        if ($this->safaripark) {
            return $this->safaripark->title;
        }
        return '';
    }

    public function getResource_uri()
    {
        return Yii::$app->params['frontend_url'] . '/sighting/' . base64_encode($this->id);
    }

    // public function getThumbnail()
    // {
    //     return 'https://d26fop8cp5dhfy.cloudfront.net/thumbnail/' . $this->filepath . '.jpg';
    // }
    public function getThumbnail()
    {
        $this->filepath = \common\models\GeneralModel::extentionRemove($this->filepath);
        return Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/high/' . $this->filepath . '.jpg';
    }

    public function getThumbnails()
    {
        $this->filepath = \common\models\GeneralModel::extentionRemove($this->filepath);
        return $arr = [
            'high' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/high/' . $this->filepath . '.jpg',
            'standard' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/standard/' . $this->filepath . '.jpg',
            'medium' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/medium/' . $this->filepath . '.jpg',
            'low' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/low/' . $this->filepath . '.jpg',
        ];
    }
}
