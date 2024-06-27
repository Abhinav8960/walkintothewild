<?php

namespace frontend\modules\sharedsafari;

use Yii;

/**
 * sharedsafari module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\sharedsafari\controllers';

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