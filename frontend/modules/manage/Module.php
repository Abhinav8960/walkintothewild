<?php

namespace frontend\modules\manage;

use Yii;
use yii\web\ForbiddenHttpException;
use common\models\operator\SafariOperator;

/**
 * manage module definition class
 */
class Module extends \yii\base\Module
{

    public $account_deactivate_message = '<p class="text-danger">*You are Account is Deactivated please <a href="/contact">Contact Us</a>.</p>';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\manage\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!Yii::$app->user->identity) {
            return Yii::$app->getResponse()->redirect('/site/login')->send();
            exit;
        }
        if (Yii::$app->user->identity->is_safari_operator != 1) {
            return Yii::$app->getResponse()->redirect('/')->send();
        }
    }

    /**
     * Check if Currect user is a Operator
     */
    public function operatormodel()
    {
        if ($operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->limit(1)->one()) {
            return $operator;
        }
        throw new ForbiddenHttpException('You are not Allowed to access this Page');
    }
}
