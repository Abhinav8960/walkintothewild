<?php

namespace frontend\modules\account;

use Yii;

/**
 * account module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\account\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->user->identity)) {
            return Yii::$app->getResponse()->redirect('/site/login')->send();
            exit;
        }
    }
}
