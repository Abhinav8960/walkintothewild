<?php

namespace api\models\meta;

use Yii;

/**
 * This is the model class for table "meta_animal_type".
 *
 * @property int $id
 * @property int|null $title
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MetaAnimalType extends \common\models\meta\MetaAnimalType
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
