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
            // 'id',
            'title',
            'slug',
            'private_url',
            // 'public_url',
            'thumbnail',
            'status' =>  function () {
                return (bool) $this->status;
            },
            'can_share' =>  function () {
                return true;
            },
            'image_count' => function () {
                return PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->id, 'status' => PartnerGalleryImage::STATUS_ACTIVE])->count();
            },
        ];

        // Add images field if the layout matches
        if (in_array(\Yii::$app->controller->layout, [SELF::PARTNER_GALLERY_API_LAYOUT_FULL])) {
            $fields['images'] = $this->galleryActiveImages;
            unset($fields['private_url']);
            unset($fields['status']);
        }


        return $fields;
    }

  

    public function getPrivate_url()
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


    public function getPublic_url()
    {
        return Yii::$app->params['api_url'] . '/chat/gallery-images/' . $this->slug;
    }

    public function getGalleryActiveImages()
    {
        return $this->hasMany(PartnerGalleryImage::class, ['partner_gallery_id' => 'id'])->andWhere(['partner_gallery_image.status' => 1])->orderBy(['partner_gallery_image.sequence'=>SORT_ASC]);
    }

    public function PrepareFullResponse()
    {
        return $arr = [
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'status' => (bool) $this->status,
            'image_count' => $this->getGalleryActiveImages()->count(),
            'images' => array_map(function ($image) {
                return $image->toArray(); // Convert each related model to an array
            }, $this->galleryActiveImages),
        ];
    }
}
