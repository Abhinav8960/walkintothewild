<?php

namespace webhook\components;

use Yii;
use yii\base\Application;
use common\models\UserSession;
use yii\base\BootstrapInterface;

class AppBootstrap implements BootstrapInterface
{
    /** 
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app) {}
}
