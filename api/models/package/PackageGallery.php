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

    public function getImagepath()
    {
        if ($this->image != '') {
            return '/storage/package_gallery/' . $this->id . '/' . $this->image;
        }
    }
}
