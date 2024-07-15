<?php

namespace frontend\modules\profile;

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
    public $controllerNamespace = 'frontend\modules\profile\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }



    public function user()
    {
        if (isset(Yii::$app->request->queryParams['user_name'])) {
            $user = User::find()->where(['username' => Yii::$app->request->queryParams['user_name']])->one();
            if (!$user) {
                throw new NotFoundHttpException('User Not Found');
            }
            return $user;
        }

        return Yii::$app->user->identity;
    }
}
