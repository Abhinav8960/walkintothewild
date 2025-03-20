<?php

namespace common\models\moderation\form;

use common\Helper\FsHelper;
use common\models\moderation\Moderation;
use Yii;
use yii\base\Model;

class ModerationForm extends Model
{
    const MODERATION_TYPE_IMAGE = 'image';
    const MODERATION_TYPE_VIDEO = 'video';
    const MODERATION_TYPE_TEXT = 'text';
    const DEFAULT_VALUE = 0.00;

    public $moderation_model;
    public $video_url;
    public $image_url;
    public $text;
    public $type;
    public $video;


    public function __construct(Moderation $moderation_model = null)
    {
        $this->moderation_model = Yii::createObject([
            'class' => Moderation::className()
        ]);

        if ($moderation_model  != '') {
            $this->moderation_model = $moderation_model;

            $this->video_url = $this->moderation_model->video_url;
            $this->image_url = $this->moderation_model->image_url;
            $this->text = $this->moderation_model->text;
            $this->type = $this->moderation_model->type;
        }
    }

    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
            [['text'], 'string'],
            [['video_url', 'image_url'], 'string', 'max' => 512],
            ['text', 'required', 'when' => function ($model) {
                return $model->type == 1;
            }, 'whenClient' => "function (attribute, value) {
               return $('#" . $this->formName() . "-type').val() == 1;
            }"],
            ['image_url', 'required', 'when' => function ($model) {
                return $model->type == 3;
            }, 'whenClient' => "function (attribute, value) {
                return $('#" . $this->formName() . "-type').val() == 3;
            }"],
            /**Video Validation */
            [
                ['video'],
                'file',
                'extensions' => ['mp4', 'avi', 'mkv', 'webm'],
            ],
            ['video', 'required', 'when' => function ($model) {
                return $model->type == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('#" . $this->formName() . "-type').val() == 2;
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Type',
            'video_url' => 'Video Url',
            'image_url' => 'Image Url',
            'text' => 'Text',
        ];
    }

    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->moderation_model->video_url = $this->video_url;
        $this->moderation_model->image_url = $this->image_url;
        $this->moderation_model->text = $this->text;
        $this->moderation_model->type = $this->type;
    }

    public function uploadFile()
    {
        if ($this->video) {
            $storagePath = 'moderation';
            $moderationPath = $storagePath . '/' . $this->moderation_model->id . '/media';

            $fileName = $this->moderation_model->id . '_video_' . time() . '.' . $this->video->extension;
            $filePath = $moderationPath . '/' . $fileName;

            if ($fileName) {
                if ($etag =  FsHelper::saveUploadedFile($this->video, $filePath, $fileName, true)) {
                    $this->moderation_model->video = $fileName;
                    $this->moderation_model->video_url = $filePath;
                    $this->moderation_model->etag = $etag;
                    $this->moderation_model->save(false);
                }
            }
        }
    }
}
