<?php

namespace support\modules\sharesafari;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'support\modules\sharesafari\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!Yii::$app->request->isConsoleRequest) {
            if (!Yii::$app->user->identity) {
                \Yii::$app->response->redirect('/site/login')->send();
            }
        }
        parent::init();
    }
}
