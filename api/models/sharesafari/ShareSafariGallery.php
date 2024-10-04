<?php

namespace api\models\sharesafari;

use Yii;
use yii\base\Model;

class ShareSafariGallery extends \common\models\sharesafari\ShareSafariGallery
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'imagepath';
        $hold_fields = ['sequence','status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
   
    public function getImagepath()
    {
        if ($this->image != '') {
            return \Yii::$app->params['frontend_url'] .'storage/share_safari/gallery/' . $this->id . '/' . $this->image;
        }
    }
}
