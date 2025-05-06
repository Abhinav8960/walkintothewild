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
        $fields[] = 'package_include';
        $fields[] = 'include_option';
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

    public function getPackage_include()
    {
        
        return $this->hasOne(MasterPackageInclude::class, ['id' => 'include_id'])->andWhere(['master_package_include.status' => MasterPackageInclude::STATUS_ACTIVE]);
    }

    public function getInclude_option()
    {
        if ($this->selection == 1) {
            return 'Included';
        } elseif ($this->selection == 2) {
            return 'Not Included';
        } else {
            return 'Optional';
        }
    }
}
