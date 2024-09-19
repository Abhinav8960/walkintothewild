<?php

namespace api\models\master\operatorcategory;

use Yii;

/**
 * This is the model class for table "master_operator_category".
 *
 * @property int $id
 * @property string|null $title
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterOperatorCategory extends \common\models\master\operatorcategory\MasterOperatorCategory
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
