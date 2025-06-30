<?php

namespace api\modules\transaction;

use Yii;

/**
 * lamp module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\transaction\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // if (!Yii::$app->request->isConsoleRequest) {
        //     if (!Yii::$app->user->identity) {
        //         \Yii::$app->response->redirect('/site/login')->send();
        //     } else {
        //         if (!(Yii::$app->user->identity->is_report_manager || Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin)) {
        //             throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Admin can View this page.');
        //         }
        //     }
        // }
        parent::init();

        // custom initialization code goes here
    }
}
