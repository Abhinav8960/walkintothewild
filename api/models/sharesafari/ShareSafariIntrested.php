<?php

namespace api\models\sharesafari;

use Yii;
use api\models\User;

class ShareSafariIntrested extends \common\models\sharesafari\ShareSafariIntrested
{
    public function fields()
    {

        if ($this->user) {
            foreach ($this->user->toArray() as $key => $value) {
                $fields[$key] = function () use ($key) {
                    if ($key == 'is_safari_operator') {
                        return (bool) $this->user->is_safari_operator;
                    }
                    return $this->user->{$key};
                };
            }
        }

        $fields['joined_at'] = function () {
            return $this->intrested_at;
        };

        return $fields;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // public function getSharesafari()
    // {
    //     return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    // }
}
