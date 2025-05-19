<?php

namespace api\models;

use Yii;


class FirebaseNotificationLog extends \common\models\firebasenotification\FirebaseNotificationLog
{
    public function fields()
    {
        $fields = ['title','message'];
        return $fields;
    }
}
