<?php

namespace business\modules\sharesafari;

use common\models\operator\SafariOperator;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * sharesafari module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'business\modules\sharesafari\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!SafariOperator::find()->where(['user_id' => \Yii::$app->user->id, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->exists()) {
            \Yii::$app->getResponse()->redirect(['/partner-registration/create'])->send();
            \Yii::$app->end();
        }

        // if (!Yii::$app->request->isConsoleRequest) {
        //     if (!Yii::$app->user->identity) {
        //         \Yii::$app->response->redirect('/site/login')->send();
        //     } else {
        //         if (!(Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_adminstrator)) {
        //             throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Admin or CMS Manager can View this page.');
        //         }
        //     }
        // }
        parent::init();
    }

    public function operatormodel()
    {
        if ($operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->limit(1)->one()) {
            return $operator;
        }
        throw new ForbiddenHttpException('You are not Allowed to access this Page');
    }
}
