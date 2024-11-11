<?php

namespace api\models\package;

use api\models\park\SafariPark;
use Yii;

/**
 * This is the model class for table "package_safari_park".
 *
 * @property int $id
 * @property int $package_id
 * @property int $park_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PackageSafariPark extends \common\models\package\PackageSafariPark
{
   
    public function getPark()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'park_id']);
    }
}
