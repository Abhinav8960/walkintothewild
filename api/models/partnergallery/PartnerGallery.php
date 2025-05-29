<?php

namespace api\models\partnergallery;

use api\models\park\SafariPark;
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

    public function getSafari_park_label()
    {
        if ($this->park) {
            return $this->park->title;
        }
        return null;
    }
}
