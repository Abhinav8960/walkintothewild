<?php

namespace frontend\components;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class AppBootstrap implements BootstrapInterface
{
    /** 
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {

        $session = Yii::$app->session;
        if (!$session->get('user_session_id')) {
            $session->set('user_session_id', session_create_id('user-session'));
        }

        if (isset(Yii::$app->user->identity)) {
            if (Yii::$app->user->identity->status !== \common\models\User::STATUS_ACTIVE) {
                \Yii::$app->user->logout();
            }
        }
    }
}
