<?php

namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use common\models\UserPosts;

/**
 * UserPostsForm form
 */
class UserPostsForm extends Model
{
    public $id;
    public $file;
    public $caption;
    public $user_id;
    public $type_of_post;
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
            $this->file = $this->user_photo_model->file;
            $this->caption = $this->user_photo_model->caption;
            $this->user_id = $this->user_photo_model->user_id;
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
            [['file', 'caption'], 'required'],
            [['file'], 'safe'],
            [
                ['file'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 250 * 1024
            ],
            [['user_id', 'type_of_post', 'status'], 'integer'],
            [['caption'], 'string'],


        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'type_of_post' => 'Type Of Post',
            'file' => 'File',
            'caption' => 'Caption',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->user_photo_model->user_id = $this->user_id;
        $this->user_photo_model->type_of_post = $this->type_of_post;
        $this->user_photo_model->caption = $this->caption;
        $this->user_photo_model->status = $this->status;
    }


    public function uploadFile()
    {

        if ($this->file) {
            $storagePath = Yii::$app->params['datapath'] . '/userpost';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->user_photo_model->id;

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'user' . time() . '.' . $this->file->extension;

            $filePath = $storagePath . '/' . $fileName;


            if ($this->file->saveAs($filePath)) {
                $this->user_photo_model->file = $fileName;
                $this->user_photo_model->save(false);
            }
        }
    }
}
