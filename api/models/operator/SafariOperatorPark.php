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
    

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id'])->andWhere(['safari_park.status' => 1]);
    }

    // public function getOperator()
    // {
    //     return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id'])->andWhere(['safari_operator.status' => 1]);
    // }
}
