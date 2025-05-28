<?php

namespace business\modules\gallery;

use common\models\operator\SafariOperator;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Sighting module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'business\modules\gallery\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!SafariOperator::find()->where(['user_id' => \Yii::$app->user->id, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->exists()) {
            \Yii::$app->getResponse()->redirect(['/partner-registration/create'])->send();
            \Yii::$app->end();
        }
        
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
