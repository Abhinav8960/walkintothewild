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
    public $high_thumbnail;
    public $sighting_thumbnail_model;
    public $created_at;


    public function __construct(Sighting $sighting_thumbnail_model = null)
    {

        $this->sighting_thumbnail_model = Yii::createObject([
            'class' => Sighting::className()
        ]);

        if ($sighting_thumbnail_model  != '') {
            $this->sighting_thumbnail_model    = $sighting_thumbnail_model;
            $this->created_at       =  $this->sighting_thumbnail_model->created_at;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['high_thumbnail'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 8 * 1024 * 1024,
            ],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'high_thumbnail' => 'High Thumbnail',
        ];
    }

    public function uploadFile()
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

        // if ($this->high_thumbnail) {

        //     $remove_extension_file_path = \common\models\GeneralModel::extentionRemove($this->sighting_thumbnail_model->filepath);
        //     $remove_extension_file_name = \common\models\GeneralModel::extentionRemove($this->sighting_thumbnail_model->file);

        //     $replacePath = 'thumbnail/high';
        //     $filePath = $replacePath . '/' . $remove_extension_file_path .'.jpg';
        //     $fileName = $remove_extension_file_name . '.jpg';

        //     if ($filePath && $fileName) {
        //         FsHelper::saveUploadedFilethumbnail($this->high_thumbnail, $filePath, $fileName, true);
        //     }
        // }


        if ($this->high_thumbnail) {
            $url = $this->sighting_thumbnail_model->thumbnail;
            $parsedUrl = parse_url($url);
            $path = $parsedUrl['path'];
            
            if ($path) {
                $path = ltrim($path, '/');
                $pathParts = explode('/', $path);
                $fileName = array_pop($pathParts);
                FsHelper::saveUploadedFilethumbnail($this->high_thumbnail, $path, $fileName, true);
            }
        }
    }
}
