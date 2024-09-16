<?php

namespace api\models\meta;

use Yii;

/**
 * This is the model class for table "meta_bird_type".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MetaBirdType extends \common\models\meta\MetaBirdType
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
