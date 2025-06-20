<?php

namespace api\models\park;

use api\models\meta\MetaStayCategory;
use common\traits\CommanRelationship;
use Yii;

class ParkStayCategory extends \common\models\park\ParkStayCategory
{
    public function fields()
    {
        $fields = [
            'stay_category',
            'status' => function () {
                return (bool)$this->status;
            }
        ];

        return $fields;
    }



    public function getStay_category()
    {
        return $this->hasOne(MetaStayCategory::class, ['id' => 'meta_stay_category_id']);
        // $model = MetaStayCategory::find()->where(['id' => 'meta_stay_category_id'])->limit(1)->one();
        // if ($model) {
        //     return $model->title;
        // }
        // return null;
    }
}
