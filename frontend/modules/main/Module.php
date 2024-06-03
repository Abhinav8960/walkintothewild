<?php

namespace frontend\modules\main;

use Yii;

/**
 * main module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\main\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!isset(Yii::$app->user->identity)) {
            return Yii::$app->getResponse()->redirect('/site/login')->send();
            exit;
        }
        parent::init();
    }
}
