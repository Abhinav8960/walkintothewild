<?php

namespace backend\modules\user;

use Yii;
use backend\models\User;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\user\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (!Yii::$app->request->isConsoleRequest) {
            if (!Yii::$app->user->identity) {
                \Yii::$app->response->redirect('/site/login')->send();
            } else {
                if (!Yii::$app->user->identity->is_admin) {
                    throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Admin can View this page.');
                }
            }
        }
    }
}
