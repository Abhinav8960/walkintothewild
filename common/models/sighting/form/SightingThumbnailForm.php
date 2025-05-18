<?php

namespace common\models\sighting\form;

use common\Helper\FsHelper;
use common\models\sighting\Sighting;
use Yii;
use yii\base\Model;


/**
 * SightingThumbnailForm is the model behind the reply form.
 */
class SightingThumbnailForm extends Model
{
    public $video_thumbnail;
    public $sighting_thumbnail_model;


    public function __construct(Sighting $sighting_thumbnail_model = null)
    {

        $this->sighting_thumbnail_model = Yii::createObject([
            'class' => Sighting::className()
        ]);

        if ($sighting_thumbnail_model  != '') {
            $this->sighting_thumbnail_model    = $sighting_thumbnail_model;
            $this->video_thumbnail       =  $this->sighting_thumbnail_model->video_thumbnail;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['video_thumbnail'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                // 'maxSize' => 50 * 1024,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_thumbnail' => 'Video Thumbnail',
        ];
    }

    public function uploadFile()
    {
        if ($this->video_thumbnail) {
            $storagePath = 'watchpost';
            $userPath = $storagePath . '/' . $this->sighting_thumbnail_model->user_id . '/thumbnail';

            $fileName = $this->sighting_thumbnail_model->user_id . '_thumbnail_' . time() . '.' . $this->video_thumbnail->extension;
            $filePath = $userPath . '/' . $fileName;

            if ($fileName) {
                if ($video_thumbnail_etag =  FsHelper::saveUploadedFile($this->video_thumbnail, $filePath, $fileName, true)) {
                    $this->sighting_thumbnail_model->video_thumbnail = $fileName;
                    $this->sighting_thumbnail_model->video_thumbnail_path = $filePath;
                    $this->sighting_thumbnail_model->video_thumbnail_etag = $video_thumbnail_etag;
                    $this->sighting_thumbnail_model->save(false);
                }
            }
        }
    }
}
