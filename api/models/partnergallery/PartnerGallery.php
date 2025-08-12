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
            'slug',
            'private_url',
            'thumbnail',
            'status' =>  function () {
                return $this->listing_status == 1 ? true : false;
            },
            'can_share' =>  function () {
                return  $this->listing_status == 1 ? true : false;
            },
            'gallery_image_count' => function () {
                return (int) $this->gallery_images_count;
            },
            'live_image_count' => function () {
                return (int) $this->live_gallery_images_count;
            },
            'can_send_for_approval' =>  function () {
                return  $this->edit_status == 1 ? true : false;
            },
            'can_edit' =>  function () {
                return $this->edit_status == 1 ? true : false;
            },
            'gallery_status_label' => function ($model) {
                return $model->getStatusLabel();
            }
        ];

        if (in_array(\Yii::$app->controller->layout, [self::PARTNER_GALLERY_API_LAYOUT_FULL])) {
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
        return $this->hasMany(PartnerGalleryImage::class, ['partner_gallery_id' => 'id'])->andWhere(['partner_gallery_image.status' => 1])->orderBy(['partner_gallery_image.sequence' => SORT_ASC]);
    }

    // public function PrepareFullResponse()
    // {
    //     return $arr = [
    //         'title' => $this->title,
    //         'slug' => $this->slug,
    //         'thumbnail' => $this->thumbnail,
    //         'status' => (bool) $this->status,
    //         'image_count' => $this->getGalleryActiveImages()->count(),
    //         'images' => array_map(function ($image) {
    //             return $image->toArray(); // Convert each related model to an array
    //         }, $this->galleryActiveImages),
    //     ];
    // }

    public function getStatuslabel()
    {
        if ($this->edit_status == 1) {
            return "In Draft";
        } else if ($this->edit_status == 2) {
            return "Send for Approval";
        } else if ($this->listing_status == 1) {
            return "Approved";
        }
    }
}
