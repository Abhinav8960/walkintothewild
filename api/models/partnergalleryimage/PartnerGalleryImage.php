<?php

namespace api\models\partnergalleryimage;

use Yii;


class PartnerGalleryImage extends \common\models\partnergalleryimage\PartnerGalleryImage
{

    public function fields()
    {


        $fields = [
            'id',
            // 'original_filename',
            'gallery_image_path',
            // 'file',
            'title',
            'caption',
            'sequence',
            'set_as_thumbnail' => function () {
                return (bool)$this->set_as_thumbnail;
            },
            'status',
        ];

        return $fields;
    }
    public function getGallery_image_path()
    {
        if ($this->filepath) {
            return Yii::$app->params['s3_endpoint'] . '/' . $this->filepath;
        }
        return '';
    }
}
