<?php

namespace frontend\models\profile;

use common\Helper\FsHelper;
use Yii;
use yii\base\Model;
use common\models\UserPosts;

/**
 * UserPostsForm form
 */
class UserPostsImageForm extends Model
{
    public $id;

    public $type_of_post;
    public $file;
    public $caption;
    public $user_id;
    public $like_count;

    public $user_image_model;
    public $status;

    public function __construct(UserPosts $user_image_model = null)
    {
        $this->user_image_model = Yii::createObject([
            'class' => UserPosts::className()
        ]);
        if ($user_image_model != null) {
            $this->user_image_model = $user_image_model;

            $this->caption = $this->user_image_model->caption;
            $this->user_id = $this->user_image_model->user_id;
            $this->like_count = $this->user_image_model->like_count;

            $this->status = $this->user_image_model->status;
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
                'extensions' => ['jpeg', 'jpg', 'png'],
            ],
            [['user_id', 'like_count', 'status'], 'integer'],
            [['user_id', 'like_count', 'status'], 'integer'],
            [['caption'], 'string'],
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

        $this->user_image_model->caption = $this->caption;
        $this->user_image_model->user_id = $this->user_id;
        $this->user_image_model->like_count = $this->like_count;
        $this->user_image_model->status = $this->status;
    }



    public function uploadFile()
    {

        if ($this->file) {
            $storagePath = 'watchpost';
            $userPath = $storagePath . '/' . $this->user_image_model->user_id . '/media';

            $fileName = $this->user_image_model->user_id . '_media_' . time() . '.' . $this->file->extension;
            $filePath = $userPath . '/' . $fileName;

            $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                // try {
                if ($etag =  FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
                    $this->user_image_model->file = $fileName;
                    $this->user_image_model->filepath = $filePath;
                    $this->user_image_model->etag = $etag;

                    $this->user_image_model->save(false);
                }
            }
        }

    }
}
