<?php

namespace api\models\master\packageinclude;

use Yii;

/**
 * This is the model class for table "master_vehicle".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterPackageInclude extends \common\models\master\packageinclude\MasterPackageInclude
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
