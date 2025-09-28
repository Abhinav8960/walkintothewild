<?php

namespace accounts\modules\operator;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'accounts\modules\operator\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (!Yii::$app->user->identity) {
            \Yii::$app->response->redirect('/site/login')->send();
        } else {
            if (!(Yii::$app->user->identity->is_account_manager)) {
                throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Admin can View this page.');
            }
        }
    }
}
