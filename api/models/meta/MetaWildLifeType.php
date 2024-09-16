<?php

namespace api\models\meta;

use Yii;

/**
 * This is the model class for table "meta_wild_life_type".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MetaWildLifeType extends \common\models\meta\MetaWildLifeType
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
