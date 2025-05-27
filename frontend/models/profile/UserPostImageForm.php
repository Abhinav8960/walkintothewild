<?php

namespace frontend\models\profile;

use common\Helper\FsHelper;
use Yii;
use yii\base\Model;
use common\models\UserPosts;
use yii\web\UploadedFile;

/**
 * UserPostImageForm
 */
class UserPostImageForm extends Model
{
    public $file;
    public $caption;
    public $user_id;
    public $status;
    public $safari_operator_id;
    public $version;
    public $created_at;
    public $NewRecord = true;

    /** @var UserPosts */
    public $user_image_model;

    public function __construct(UserPosts $user_image_model = null, $config = [])
    {
        parent::__construct($config);

        if ($user_image_model !== null) {
            $this->NewRecord = false;
            $this->user_image_model = $user_image_model;

            $this->caption = $user_image_model->caption;
            $this->user_id = $user_image_model->user_id;
            $this->safari_operator_id = $user_image_model->safari_operator_id;
            $this->version = $user_image_model->version;
            $this->status = $user_image_model->status;
            $this->created_at = $user_image_model->created_at;
        } else {
            $this->user_image_model = new UserPosts();
        }
    }

    public function rules()
    {
        return [
            [['user_id', 'status', 'safari_operator_id', 'version'], 'integer'],
            [['caption'], 'string'],
            [['created_at'], 'safe'],
            [
                ['caption'],
                'required',
                'when' => function ($model) {
                    return empty($model->file);
                },
            ],
            [
                ['file'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 18 * 1024 * 1024,
                'skipOnEmpty' => !$this->NewRecord,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'version' => 'Version',
            'safari_operator_id' => 'Safari Operator ID',
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
        $this->user_image_model->created_at = $this->created_at ?? time();
    }

    public function uploadFile()
    {
        if ($this->file instanceof UploadedFile) {
            $this->created_at = $this->created_at ?? time();
            $storagePath = 'post/' . date('ym', $this->created_at);
            $fileName = $this->user_image_model->user_id . '_' . time() . '.' . $this->file->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($etag = FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
                $this->user_image_model->file = $fileName;
                $this->user_image_model->original_filename = $this->file->name;
                $this->user_image_model->filepath = $filePath;
                $this->user_image_model->etag = $etag;

                return $this->user_image_model->save(false);
            }
        }

        return false;
    }
}
