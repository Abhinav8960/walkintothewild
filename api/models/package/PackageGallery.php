<?php

namespace api\models\package;

use Yii;

/**
 * This is the model class for table "package_gallery".
 *
 * @property int $id
 * @property int $package_id
 * @property string|null $image
 * @property string|null $image_caption
 * @property int $sequence
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class PackageGallery extends \common\models\package\PackageGallery
{

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'image_path';
        $hold_fields = ['image','sequence','status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImage_path()
    {
        if ($this->image != '') {
            return \Yii::$app->params['frontend_url_for_api'] .'/storage/package_gallery/' . $this->id . '/' . $this->image;
        }
    }
}
