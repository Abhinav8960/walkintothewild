<?php

namespace api\models\master\sharesafarireason;

use Yii;

/**
 * This is the model class for table "master_share_safari_reason".
 *
 * @property int $id
 * @property string|null $reason
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterShareSafariReason extends \common\models\master\sharesafarireason\MasterShareSafariReason
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status',  'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
