<?php

namespace api\models\package;

use api\models\park\SafariPark;
use Yii;

/**
 * This is the model class for table "package_safari_park".
 *
 * @property int $id
 * @property int $package_id
 * @property int $park_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PackageSafariPark extends \common\models\package\PackageSafariPark
{
    public function fields()
    {
        $fields = parent::fields();

        if (!in_array(\Yii::$app->controller->action->uniqueId, ['park/default/view'])) {
            $fields[] = 'park';
            $hold_fields = [
                'id',
                'park_id',
                'package_id',
                'status',
                'created_by',
                'updated_by',
                'created_at',
                'created_by',
                'updated_at',
            ];
        } else {
            $hold_fields = [
                'id',
                'park_id',
                'package_id',
                'status',
                'created_by',
                'updated_by',
                'created_at',
                'created_by',
                'updated_at',
            ];
        }


        return array_diff($fields, $hold_fields);
    }
    public function getPark()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'park_id']);
    }
}
