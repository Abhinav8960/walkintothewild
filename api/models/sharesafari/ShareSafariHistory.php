<?php

namespace api\models\sharesafari;

use api\models\park\SafariPark;
use api\models\User;
use Yii;

class ShareSafariHistory extends \common\models\sharesafari\ShareSafariHistory
{
    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }
}
