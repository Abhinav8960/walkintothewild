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

    public $file;
    public $caption;
    public $user_id;

    public $user_image_model;
    public $status;
    public $safari_operator_id;
    public $version;

    public function __construct(UserPosts $user_image_model = null)
    {
        $this->user_image_model = Yii::createObject([
            'class' => UserPosts::className()
        ]);
        if ($user_image_model != null) {
            $this->user_image_model = $user_image_model;

            $this->caption = $this->user_image_model->caption;
            $this->user_id = $this->user_image_model->user_id;
            $this->safari_operator_id = $this->user_image_model->safari_operator_id;
            $this->version = $this->user_image_model->version;

            $this->status = $this->user_image_model->status;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['file'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
            ],
            [['user_id', 'status','safari_operator_id'], 'integer'],
            [['caption'], 'string'],
            [
                ['file'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 18 * 1024 * 1024,
            ],
            [
                ['caption'],
                'required',
                'when' => function ($model) {
                    return empty($model->file);
                },
            ],
            [
                ['file'],
                'required',
                'when' => function ($model) {
                    return empty($model->caption);
                },
            ],
            [['version'],'integer'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'version' => 'Version',
            'safari_operator_id' => 'Safari Operator Id',
            'caption' => 'Caption',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {

        $this->user_image_model->caption = $this->caption;
        $this->user_image_model->user_id = $this->user_id;
        $this->user_image_model->safari_operator_id = $this->safari_operator_id;
        $this->user_image_model->version = $this->version;
        $this->user_image_model->status = $this->status;
    }



    public function uploadFile()
    {

        if ($this->file) {
            $storagePath = 'post';
            $userPath = $storagePath . '/' . $this->user_image_model->user_id . '/media';

            $fileName = $this->user_image_model->user_id . '_media_' . time() . '.' . $this->file->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
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
