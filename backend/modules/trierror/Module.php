<?php

namespace app\modules\admin\modules\trierror;

/**
 * lamp module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\modules\trierror\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (\Yii::$app->user->isGuest) {
            header('Location:/login');
            exit;
        }
        // custom initialization code goes here
    }
}
