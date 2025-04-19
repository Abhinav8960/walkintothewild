<?php

namespace frontend\modules\quatation;

use common\models\User;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * sharedsafari module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\quatation\controllers';

    /**
     * {@inheritdoc}
     */
    
    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->user->identity)) {
            return Yii::$app->getResponse()->redirect('/site/login')->send();
            exit;
        }
    }



    public function user()
    {
        if (isset(Yii::$app->request->queryParams['user_handle'])) {
            $user = User::find()->where(['user_handle' => Yii::$app->request->queryParams['user_handle']])->one();
            if (!$user) {
                throw new NotFoundHttpException('User Not Found');
            }
            return $user;
        }

        return Yii::$app->user->identity;
    }
}
