<?php

namespace api\models;

use Yii;
use api\models\park\SafariPark;

class UserExperience extends \common\models\UserExperience
{
    // public function fields()
    // {
    //     $fields = parent::fields();
    //     $fields[] = 'park';
    //     $hold_fields = ['user_id','park_id','file','description', 'created_by', 'updated_by', 'created_at', 'updated_at'];
    //     return array_diff($fields, $hold_fields);
    //     return $fields;
    // }

    // public function getImagepath()
    // {
    //     if ($this->file != '') {
    //         return '/storage/userpost/' . $this->id . '/' . $this->file;
    //     }
    // }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }
}
