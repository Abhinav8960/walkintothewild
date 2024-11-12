<?php

namespace api\models\package;

use api\models\master\packageinclude\MasterPackageInclude;
use Yii;

/**
 * This is the model class for table "package_included".
 *
 * @property int $id
 * @property int $package_id
 * @property int $include_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 */
class PackageIncluded  extends \common\models\package\PackageIncluded
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'packageInclude';
        $fields[] = 'includeoption';
        $hold_fields = [
            'id',
            'selection',
            'include_id',
            'package_id',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'created_by',
            'updated_at',
        ];

        return array_diff($fields, $hold_fields);
    }

    public function getPackageInclude()
    {
        return $this->hasMany(MasterPackageInclude::class, ['id' => 'include_id']);
    }

    public function getIncludeoption()
    {
        if ($this->selection == 1) {
            return 'Include';
        } elseif ($this->selection == 2) {
            return 'Not Include';
        } else {
            return 'Optional';
        }
    }
}
