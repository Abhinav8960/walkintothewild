<?php

namespace backend\modules\article;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\article\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {

        if (!Yii::$app->request->isConsoleRequest) {
            if (!Yii::$app->user->identity) {
                \Yii::$app->response->redirect('/site/login')->send();
            } else {
                if (!(Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_adminstrator)) {
                    throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Admin or CMS Manager can View this page.');
                }
            }
        }
        parent::init();
    }
}
