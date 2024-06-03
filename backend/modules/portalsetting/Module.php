<?php

namespace backend\modules\portalsetting;

use Yii;

/**
 * portalsetting module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\portalsetting\controllers';

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
