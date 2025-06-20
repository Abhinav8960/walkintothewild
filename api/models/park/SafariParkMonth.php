<?php

namespace common\models\park;

use api\models\master\month\MasterMonth;
use Yii;

/**
 * This is the model class for table "safari_park_month".
 *
 * @property int $id
 * @property int|null $safari_park_id
 * @property int|null $month_id
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class SafariParkMonth extends \common\models\park\SafariParkMonth
{
    public function getMastermonth()
    {
        return $this->hasOne(MasterMonth::className(), ['month' => 'month_id']);
    }
}
