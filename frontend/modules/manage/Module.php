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

        // custom initialization code goes here
    }

    /**
     * Check if Currect user is a Operator
     */
    public function operatormodel()
    {
        if (!Yii::$app->user->identity) {
            throw new ForbiddenHttpException('Please Login to Access Business Page');
        }
        if (Yii::$app->user->identity->is_safari_operator != 1) {
            throw new ForbiddenHttpException('You are not Allowed to access this Page');
        }
        return SafariOperator::find()->where(['user_id' => Yii::$app->user->identity->id])->limit(1)->one();
    }
}
