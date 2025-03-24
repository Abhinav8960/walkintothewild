<?php

namespace frontend\models\profile;

use common\Helper\FsHelper;
use Yii;
use yii\base\Model;
use common\models\UserPosts;
use getID3;
use yii\imagine\Image;

/**
 * UserPostsForm form
 */
class UserPostsVideoForm extends Model
{
    public $id;

    public $file;
    public $caption;
    public $description;
    public $user_id;
    public $like_count;
    public $v_size;
    public $v_duration;

    public $user_photo_model;
    public $action_url;
    public $action_validate_url;
    public $status;
    public $location;
    public $video_thumbnail;
    public $type_of_post;


    public function __construct(UserPosts $user_photo_model = null)
    {
        $this->user_photo_model = Yii::createObject([
            'class' => UserPosts::className()
        ]);
        if ($user_photo_model != null) {
            $this->user_photo_model = $user_photo_model;

            $this->caption = $this->user_photo_model->caption;
            $this->description = $this->user_photo_model->description;
            $this->user_id = $this->user_photo_model->user_id;
            $this->like_count = $this->user_photo_model->like_count;
            $this->v_size = $this->user_photo_model->v_size;
            $this->v_duration = $this->user_photo_model->v_duration;
            $this->video_thumbnail = $this->user_photo_model->video_thumbnail;
            $this->location = $this->user_photo_model->location;
            $this->type_of_post = $this->user_photo_model->type_of_post;

            $this->status = $this->user_photo_model->status;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'file'], 'required'],
            [
                ['file'],
                'file',
                'extensions' => ['mp4', 'avi', 'mkv', 'webm'],
            ],
            [
                ['video_thumbnail'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                // 'maxSize' => 10 * 1024,
            ],
            [['user_id', 'like_count', 'status','type_of_post'], 'integer'],
            [['caption', 'description', 'location'], 'string'],
            [['v_size', 'v_duration'], 'integer']
        ];
    }


    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'caption' => 'Caption',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {

        $this->user_photo_model->caption = $this->caption;
        $this->user_photo_model->description = $this->description;
        $this->user_photo_model->user_id = $this->user_id;
        $this->user_photo_model->like_count = $this->like_count;
        $this->user_photo_model->v_size = $this->v_size;
        $this->user_photo_model->v_duration = $this->v_duration;
        $this->user_photo_model->video_thumbnail = $this->video_thumbnail;
        $this->user_photo_model->location = $this->location;
        $this->user_photo_model->type_of_post = $this->type_of_post;
        $this->user_photo_model->status = $this->status;
    }



    public function uploadFile()
    {

        if ($this->file) {
            $storagePath = 'watchpost';
            $userPath = $storagePath . '/' . $this->user_photo_model->user_id . '/media';

            $fileName = $this->user_photo_model->user_id . '_media_' . time() . '.' . $this->file->extension;
            $filePath = $userPath . '/' . $fileName;

            $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                // try {
                if ($etag =  FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
                    $this->user_photo_model->file = $fileName;
                    $this->user_photo_model->filepath = $filePath;
                    $this->user_photo_model->etag = $etag;

                    $this->user_photo_model->save(false);
                }
            }
        }

        if ($this->video_thumbnail) {
            $storagePath = 'watchpost';
            $userPath = $storagePath . '/' . $this->user_photo_model->user_id . '/thumbnail';

            $fileName = $this->user_photo_model->user_id . '_thumbnail_' . time() . '.' . $this->video_thumbnail->extension;
            $filePath = $userPath . '/' . $fileName;

            $fileName = FsHelper::UserPostUploadFile($this->video_thumbnail, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                // try {
                if ($video_thumbnail_etag =  FsHelper::saveUploadedFile($this->video_thumbnail, $filePath, $fileName, true)) {
                    $this->user_photo_model->video_thumbnail = $fileName;
                    $this->user_photo_model->video_thumbnail_path = $filePath;
                    $this->user_photo_model->video_thumbnail_etag = $video_thumbnail_etag;

                    $this->user_photo_model->save(false);
                }
            }
        }
    }
}
