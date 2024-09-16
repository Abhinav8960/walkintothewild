<?php

namespace api\models\meta;

use Yii;

/**
 * This is the model class for table "meta_package_rage".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $min_range
 * @property int|null $max_range
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MetaPackageRange extends \common\models\meta\MetaPackageRange
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
