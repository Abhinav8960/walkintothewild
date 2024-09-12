<?php

namespace common\components;

use Yii;

class WebUser extends \yii\web\User
{
    public function login($identity, $duration = 0)
    {
        $result = parent::login($identity, $duration);
        if ($result) {
            $identity->afterLogin();
        }
        return $result;
    }

    public function logout($destroySession = true)
    {
        if ($destroySession) {
            $identity = Yii::$app->user->identity;
            if ($identity) {
                $identity->afterLogout();
            }
        }
        return parent::logout($destroySession);
    }
}
