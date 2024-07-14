<?php

namespace frontend\modules\package;

use Yii;

/**
 * package module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\package\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // if (!isset(Yii::$app->user->identity)) {
        //     return Yii::$app->getResponse()->redirect('/site/login')->send();
        //     exit;
        // }
        parent::init();
    }
}