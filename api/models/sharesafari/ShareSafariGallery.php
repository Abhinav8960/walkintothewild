<?php

namespace api\models\sharesafari;

use Yii;
use yii\base\Model;

class ShareSafariGallery extends \common\models\sharesafari\ShareSafariGallery
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'image_path';
        $hold_fields = ['image','sequence','status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImage_path()
    {
        if ($this->image != '') {
            return \Yii::$app->params['s3_endpoint'] . '/share_safari/gallery/' . $this->id . '/' . $this->image;
        }
    }
}
