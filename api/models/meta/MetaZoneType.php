<?php

namespace api\models\meta;

use Yii;

/**
 * This is the model class for table "meta_zone_type".
 *
 * @property int $id
 * @property string $name
 * @property string|null $color_code
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MetaZoneType extends \common\models\meta\MetaZoneType
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
