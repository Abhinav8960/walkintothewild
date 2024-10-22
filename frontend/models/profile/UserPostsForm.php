<?php

namespace frontend\models\profile;

use common\Helper\FsHelper;
use Yii;
use yii\base\Model;
use common\models\UserPosts;
use yii\imagine\Image;

/**
 * UserPostsForm form
 */
class UserPostsForm extends Model
{
    public $id;

    public $file;
    public $caption;
    public $description;
    public $user_id;
    public $type_of_post;
    public $height;
    public $width;
    public $like_count;
    public $location;
    public $latitude;
    public $longitude;

    public $user_photo_model;
    public $action_url;
    public $action_validate_url;
    public $status;

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
            $this->type_of_post = $this->user_photo_model->type_of_post;
            $this->height = $this->user_photo_model->height;
            $this->width = $this->user_photo_model->width;
            $this->like_count = $this->user_photo_model->like_count;
            $this->location = $this->user_photo_model->location;
            $this->latitude = $this->user_photo_model->latitude;
            $this->longitude = $this->user_photo_model->longitude;

            $this->status = $this->user_photo_model->status;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'type_of_post', 'file'], 'required'],
            [
                ['file'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png', 'mp4', 'avi', 'mkv', 'webm'],
            ],
            [['user_id', 'type_of_post', 'height', 'width', 'like_count', 'status'], 'integer'],
            [['caption', 'description', 'location'], 'string'],
            [['latitude', 'longitude'], 'number'],
        ];
    }

    // protected function getFileExtensions()
    // {
    //     if ($this->type_of_post == 1) {
    //         return ['mp4', 'avi', 'mkv', 'webm'];
    //     } else {
    //         return  ['jpeg', 'jpg', 'png'];
    //     }
    // }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'type_of_post' => 'Type Of Post',
            'caption' => 'Caption',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {

        $this->user_photo_model->caption = $this->caption;
        $this->user_photo_model->description = $this->description;
        $this->user_photo_model->user_id = $this->user_id;
        $this->user_photo_model->type_of_post = $this->type_of_post;
        // $this->user_photo_model->height = $this->height;
        // $this->user_photo_model->width = $this->width;
        $this->user_photo_model->like_count = $this->like_count;
        $this->user_photo_model->location = $this->location;
        $this->user_photo_model->latitude = $this->latitude;
        $this->user_photo_model->longitude = $this->longitude;
        $this->user_photo_model->status = $this->status;
    }


    // public function uploadFile()
    // {

    //     if ($this->file) {
    //         $storagePath = Yii::$app->params['datapath'] . '/userpost';

    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath);
    //             chmod($storagePath, 0777);
    //         }
    //         $userPath = $storagePath . '/' . $this->user_photo_model->user_id;
    //         if (!file_exists($userPath)) {
    //             mkdir($userPath);
    //             chmod($userPath, 0777);
    //         }

    //         $fileName = 'user' . time() . '.' . $this->file->extension;
    //         $filePath = $userPath . '/' . $fileName;


    //         if ($this->file->saveAs($filePath)) {
    //             $this->user_photo_model->file = $fileName;

    //              /**Thumb Nail Save */
    //             if ($this->type_of_post == 1) {
    //                 $thumbFileName = 'user' . time() . '-thumb.' . $this->file->extension;
    //                 $thumbFilePath = $userPath . '/' . $thumbFileName;
    //                 Image::thumbnail($filePath, 200, 200)->save($thumbFilePath, ['quality' => 80]);
    //             }


    //             $this->user_photo_model->save(false);
    //         }
    //     }

    // }



    public function uploadFile()
    {

        if ($this->file) {
            $storagePath = 'watchpost';
            $userPath = $storagePath . '/' . $this->user_photo_model->user_id . '/media';

            $fileName = $this->user_photo_model->user_id . '_media_' . time() . '.' . $this->file->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
                        $this->user_photo_model->file = $fileName;
                        $this->user_photo_model->filepath = $filePath;
                        $this->user_photo_model->etag = $etag;

                        $extension = $this->file->extension;
                        if ($extension === 'svg') {
                            $width = 0;
                            $height = 0;
                        } else {
                            list($width, $height) = getimagesize($this->file->tempName);
                        }
                        $this->user_photo_model->height =  $height;
                        $this->user_photo_model->width = $width;
                        $this->user_photo_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }
    }
}
