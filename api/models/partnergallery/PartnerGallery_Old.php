<?php

namespace api\models\partnergallery;

use api\models\park\SafariPark;
use api\models\partnergalleryimage\PartnerGalleryImage;
use Yii;

class PartnerGallery_Old extends \common\models\partnergallery\PartnerGallery
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
                return !empty($this->live_images) ?  true : false;
            },
            'gallery_image_count' => function () {
                return PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->id, 'status' => PartnerGalleryImage::STATUS_ACTIVE])->count();
            },
            'live_image_count' => function () {
                if (!empty($this->live_images)) {
                    $c_arr =  json_decode($this->live_images, true);
                    return $c_arr['image_count'] ?? 0;
                }
                return 0;
            },
            'can_send_for_approval' =>  function () {
                return (bool) $this->send_for_approval;
            },
            'can_edit' =>  function () {
                return (bool) $this->in_draft;
            },
            'gallery_status_label' => function ($model) {
                return $model->getStatusLabel();
            }
        ];

        // Add images field if the layout matches
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
        // return $this->hasMany(PartnerGalleryImage::class, ['partner_gallery_id' => 'id'])->andWhere(['partner_gallery_image.status' => 1])->orderBy(['partner_gallery_image.sequence' => SORT_ASC]);
        if (!empty($this->live_images)) {
            $c_arr =  json_decode($this->live_images, true);
            return $c_arr['images'] ?? [];
        }
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
        if ($this->in_draft == 1) {
            return "In Draft";
        } else if ($this->send_for_approval == 1) {
            return "Send for Approval";
        } else if ($this->is_approved == 1) {
            return "Approved";
        }
    }
}
