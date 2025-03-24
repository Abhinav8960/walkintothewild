<?php

namespace api\modules\manage;

use api\models\operator\SafariOperator;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * manage module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\manage\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // if (\Yii::$app->params['active_user']->is_safari_operator != 1) {
        //     return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not Allowed to access this Page"]);
        // }
    }

    /**
     * Check if Currect user is a Operator
     */
    public function operatormodel()
    {
        if ($operator = SafariOperator::find()->where(['user_id' => \Yii::$app->params['active_user'] ? \Yii::$app->params['active_user_id'] : null])->andWhere(['status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one()) {
            return $operator;
        }
        throw new ForbiddenHttpException('You are not Allowed to access this Page');
    }
}
