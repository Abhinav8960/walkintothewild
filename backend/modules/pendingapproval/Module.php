<?php

namespace backend\modules\pendingapproval;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\pendingapproval\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {

        if (!Yii::$app->request->isConsoleRequest) {
            if (!Yii::$app->user->identity) {
                \Yii::$app->response->redirect('/site/login')->send();
            } else {
                if (Yii::$app->user->identity->is_report_manager || Yii::$app->user->identity->is_resort_manager || Yii::$app->user->identity->is_birding_operator || Yii::$app->user->identity->is_safari_operator|| Yii::$app->user->identity->is_cms_manager) {
                    throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Admin can View this page.');
                }
            }
        }
        parent::init();
    }
}
