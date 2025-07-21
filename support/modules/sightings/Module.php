<?php

namespace support\modules\sightings;


use Yii;

/**
 * Sighting module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'support\modules\sightings\controllers';

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
