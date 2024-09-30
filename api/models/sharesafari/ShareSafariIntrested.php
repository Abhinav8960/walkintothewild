<?php

namespace api\models\sharesafari;

use Yii;
use api\models\User;
use yii\base\Model;

class ShareSafariIntrested extends Model
{

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'user';
        $fields[] = 'sharesafari';
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSharesafari()
    {
        return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    }
}
