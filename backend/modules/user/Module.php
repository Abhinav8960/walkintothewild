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
                if (!in_array(Yii::$app->user->identity->role_id, [User::ROLE_ADMINISTRATOR, User::ROLE_ATHENA_INFONOMICS_LEVEL])) {
                    throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Adminstrator can view this page.');
                }
            }
        }
    }
}
