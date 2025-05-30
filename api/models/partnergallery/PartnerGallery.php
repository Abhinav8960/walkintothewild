<?php

namespace api\models\partnergallery;

use api\models\park\SafariPark;
use api\models\partnergalleryimage\PartnerGalleryImage;
use Yii;

class PartnerGallery extends \common\models\partnergallery\PartnerGallery
{

    public function fields()
    {


        $fields = [
            'title',
            'safari_park_id',
            'safari_park_label',
            'slug',
            'url',
            'thumbnail',
            'status'
        ];

        return $fields;
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'safari_park_id']);
    }

    public function getUrl()
    {
        return Yii::$app->params['api_url'] . '/manage/gallery/' . $this->slug . '/gallery-images';
    }

    public function getThumbnail()
    {
        $model = PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->id])->andWhere(['set_as_thumbnail' => 1])->limit(1)->one();
        if ($model) {
            return Yii::$app->params['s3_endpoint'] . '/' . $model->filepath;
        }
        return null;
    }

    public function getSafari_park_label()
    {
        if ($this->park) {
            return $this->park->title;
        }
        return null;
    }
}
