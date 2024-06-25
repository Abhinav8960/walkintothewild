<?php

namespace frontend\modules\park;

use Yii;

/**
 * park module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\park\controllers';

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
