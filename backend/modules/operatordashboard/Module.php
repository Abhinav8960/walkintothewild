<?php

namespace backend\modules\operatordashboard;

use Yii;

/**
 * operatordashboard module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\operatordashboard\controllers';

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
                if (!(Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_birding_operator)) {
                    throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Operator can View this page.');
                }
            }
        }
    }
}
