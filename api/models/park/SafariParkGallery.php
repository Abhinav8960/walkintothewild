<?php

namespace api\models\park;

use Yii;

/**
 * This is the model class for table "safari_park_gallery".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property string|null $image
 * @property string|null $image_caption
 * @property int $sequence
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariParkGallery extends \common\models\park\SafariParkGallery
{

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'imagepath';



        $hold_fields = [

            'id',
            'safari_park_id',
            'image',
            'sequence',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImagepath()
    {
        if ($this->image != '') {
            return \Yii::$app->params['frontend_url'] . 'storage/safariparkgallery/' . $this->id . '/' . $this->image;
        }
    }
}
