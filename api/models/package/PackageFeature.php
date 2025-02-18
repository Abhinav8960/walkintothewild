<?php

namespace api\models\package;

use api\models\master\packagefeature\MasterPackagefeature;
use Yii;

/**
 * This is the model class for table "package_feature".
 *
 * @property int $id
 * @property int $package_id
 * @property int $feature_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 */
class PackageFeature extends \common\models\package\PackageFeature
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'featurename';
        $hold_fields = ['id', 'package_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getFeaturename()
    {
        return $this->hasOne(MasterPackagefeature::class, ['id' => 'feature_id']);
    }
}
