<?php

namespace backend\components;

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

        $webasset = Yii::$app->view->assetManager->getBundle('backend\assets\NovaAppAsset');
        Yii::$app->view->params['baseurl'] = $webasset->baseUrl;
    }
}
