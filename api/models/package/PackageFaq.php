<?php

namespace api\models\package;

use Yii;

/**
 * This is the model class for table "package_faq".
 *
 * @property int $id
 * @property int $package_id
 * @property string|null $question
 * @property string|null $answer
 * @property int|null $position
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PackageFaq extends \common\models\package\PackageFaq
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = [ 'faq_id', 'package_id', 'position', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
