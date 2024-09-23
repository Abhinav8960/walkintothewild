<?php

namespace api\models\master\faq;

use Yii;

/**
 * This is the model class for table "master_faq".
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $answer
 * @property int $position
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterFaq extends \common\models\master\faq\MasterFaq
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['id', 'position', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
