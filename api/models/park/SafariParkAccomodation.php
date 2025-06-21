<?php

namespace api\models\park;

use api\models\meta\MetaStayCategory;
use Yii;

/**
 * This is the model class for table "safari_park_accomodation".
 *
 * @property int $id
 * @property int|null $safari_park_id
 * @property int|null $master_accomodation_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SafariParkAccomodation extends \common\models\park\SafariParkAccomodation
{
    // public function fields()
    // {
    //     $fields = [
    //         'stay_category',
    //         'status' => function () {
    //             return (bool)$this->status;
    //         }
    //     ];

    //     return $fields;
    // }

    public function fields()
    {
        return [
            'id' => function () {
                return $this->stay_category->id ?? null;
            },
            'title' => function () {
                return $this->stay_category->title ?? null;
            },
            // 'status' => function () {
            //     return (bool)$this->status;
            // }
        ];
    }



    public function getStay_category()
    {
        return $this->hasOne(MetaStayCategory::class, ['id' => 'meta_stay_category_id']);
    }
}
