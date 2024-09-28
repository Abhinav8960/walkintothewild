<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "master_meta_table_info".
 *
 * @property int $id
 * @property string $name
 * @property int $total_count
 * @property string $last_updated_time
 */
class MasterMetaTableInfo extends \common\models\MasterMetaTableInfo
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['id'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
