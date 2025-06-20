<?php

namespace api\models\master\suggetioncategory;

use Yii;

/**
 * This is the model class for table "master_suggestion_category".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class MasterSuggestionCategory extends \common\models\master\suggetioncategory\MasterSuggestionCategory
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'sequence',  'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
