<?php

namespace api\models\master\message;

use Yii;

/**
 * This is the model class for table "master_message".
 *
 * @property int $id
 * @property string|null $module
 * @property int|null $page_id
 * @property int|null $type_id
 * @property string|null $code
 * @property string|null $message
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterMessage extends \common\models\master\message\MasterMessage
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
