<?php

namespace backend\modules\park;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\park\controllers';

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
                    throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Admin can View this page.');
                }
            }
        }
        parent::init();

        $this->modules = [
            'safari' => [
                'class' => 'backend\modules\park\modules\safari\Module',
            ],
            'birding' => [
                'class' => 'backend\modules\park\modules\birding\Module',
            ],

        ];
    }
}
