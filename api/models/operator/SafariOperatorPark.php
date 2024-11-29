<?php

namespace api\models\operator;

use api\models\park\SafariPark;
use Yii;

/**
 * This is the model class for table "safari_operator_park".
 *
 * @property int $id
 * @property int|null $safari_operator_id
 * @property int|null $park_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 */
class SafariOperatorPark extends \common\models\operator\SafariOperatorPark
{
    public function fields()
    {
        $fields = parent::fields();
        if(!in_array(\Yii::$app->controller->action->uniqueId, ['operator/default/user-rating-parklist']))
        {
            // $fields[] = 'park';
            $hold_fields = [
                'id',
                'safari_operator_id',
                'park_id',
                'status',
                'show_in_front',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];
        }else{
            $hold_fields = [
                'id',
                'safari_operator_id',
                'show_in_front',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];
        }
       
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id'])->andWhere(['safari_park.status' => 1]);
    }

    // public function getOperator()
    // {
    //     return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id'])->andWhere(['safari_operator.status' => 1]);
    // }
}
