<?php

namespace developer\modules\feature;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'developer\modules\feature\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (!Yii::$app->user->identity) {
            \Yii::$app->response->redirect('/site/login')->send();
        } else {
            if (!(Yii::$app->user->identity->is_developer)) {
                throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Developer can View this page.');
            }
        }
    }
}
