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
    public $thumbnail;
    public $sighting_thumbnail_model;
    public $path;


    public function __construct(Sighting $sighting_thumbnail_model = null)
    {

        $this->sighting_thumbnail_model = Yii::createObject([
            'class' => Sighting::className()
        ]);

        if ($sighting_thumbnail_model  != '') {
            $this->sighting_thumbnail_model    = $sighting_thumbnail_model;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['thumbnail'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 8 * 1024 * 1024,
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
            'thumbnail' => 'Thumbnail',
        ];
    }

    public function uploadFile($url_path)
    {
        // if ($this->video_thumbnail) {
        //     $storagePath = 'watchpost' . '/' . date('ym', $this->created_at);
        //     $fileName = 'thumbnail_' . $this->sighting_thumbnail_model->user_id . '_' . time() . '.' . $this->video_thumbnail->extension;
        //     $filePath = $storagePath . '/' . $fileName;

        //     if ($fileName) {
        //         if ($video_thumbnail_etag =  FsHelper::saveUploadedFile($this->video_thumbnail, $filePath, $fileName, true)) {
        //             $this->sighting_thumbnail_model->video_thumbnail = $fileName;
        //             $this->sighting_thumbnail_model->video_thumbnail_path = $filePath;
        //             $this->sighting_thumbnail_model->original_thumbnail = $this->video_thumbnail->name;
        //             $this->sighting_thumbnail_model->video_thumbnail_etag = $video_thumbnail_etag;
        //             $this->sighting_thumbnail_model->save(false);
        //         }
        //     }
        // }

        if ($this->thumbnail && $url_path) {
            $url = $url_path;
            $parsedUrl = parse_url($url);
            $path = $parsedUrl['path'];

            if ($path) {
                $path = ltrim($path, '/');
                $pathParts = explode('/', $path);
                $fileName = array_pop($pathParts);
                FsHelper::saveUploadedFilethumbnail($this->thumbnail, $path, $fileName, true);
            }
        }

    }
}
