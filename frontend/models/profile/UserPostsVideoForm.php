<?php

namespace frontend\models\profile;

use common\Helper\FsHelper;
use common\models\master\animal\MasterAnimal;
use common\models\meta\MetaSafariSession;
use common\models\meta\MetaZoneType;
use common\models\park\SafariPark;
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
    public $video_thumbnail;
    public $type_of_post;

    public $location;
    public $master_animal_id;
    public $safari_session_id;
    public $post_datetime;
    public $zone_id;


    public function __construct(UserPosts $user_photo_model = null)
    {
        $this->user_photo_model = Yii::createObject([
            'class' => UserPosts::className()
        ]);
        if ($user_photo_model != null) {
            $this->user_photo_model = $user_photo_model;

            $this->description = $this->user_photo_model->description;
            $this->user_id = $this->user_photo_model->user_id;
            $this->v_size = $this->user_photo_model->v_size;
            $this->v_duration = $this->user_photo_model->v_duration;
            $this->video_thumbnail = $this->user_photo_model->video_thumbnail;
            $this->location = $this->user_photo_model->location;
            $this->type_of_post = $this->user_photo_model->type_of_post;

            $this->status = $this->user_photo_model->status;

            $this->master_animal_id = $this->user_photo_model->master_animal_id;
            $this->safari_session_id = $this->user_photo_model->safari_session_id;
            $this->post_datetime = $this->user_photo_model->post_datetime;
            $this->zone_id = $this->user_photo_model->zone_id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'master_animal_id', 'safari_session_id', 'post_datetime', 'zone_id', 'location','description'], 'required'],
            [
                ['file'],
                'file',
                'extensions' => ['mp4', 'avi', 'mkv', 'webm'],
                'maxSize' => 18 * 1024 * 1024,
            ],
            [
                ['video_thumbnail'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                // 'maxSize' => 10 * 1024,
            ],
            [['user_id', 'like_count', 'status', 'type_of_post'], 'integer'],
            [['caption', 'description'], 'string'],
            [['v_size', 'v_duration', 'master_animal_id', 'safari_session_id', 'zone_id', 'location'], 'integer'],
            [['post_datetime'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['master_animal_id', 'exist', 'targetClass' => MasterAnimal::class, 'targetAttribute' => ['master_animal_id' => 'id']],
            ['safari_session_id', 'exist', 'targetClass' => MetaSafariSession::class, 'targetAttribute' => ['safari_session_id' => 'id']],
            ['zone_id', 'exist', 'targetClass' => MetaZoneType::class, 'targetAttribute' => ['zone_id' => 'id']],
            ['location', 'exist', 'targetClass' => SafariPark::class, 'targetAttribute' => ['location' => 'id']],
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

        $this->user_photo_model->description = $this->description;
        $this->user_photo_model->user_id = $this->user_id;
        $this->user_photo_model->v_size = $this->v_size;
        $this->user_photo_model->v_duration = $this->v_duration;
        $this->user_photo_model->video_thumbnail = $this->video_thumbnail;
        $this->user_photo_model->location = $this->location;
        $this->user_photo_model->type_of_post = $this->type_of_post;
        $this->user_photo_model->status = $this->status;

        $this->user_photo_model->master_animal_id = $this->master_animal_id;
        $this->user_photo_model->safari_session_id = $this->safari_session_id;
        $this->user_photo_model->post_datetime = $this->post_datetime;
        $this->user_photo_model->zone_id = $this->zone_id;
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
