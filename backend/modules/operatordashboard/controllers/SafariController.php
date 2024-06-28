<?php

namespace backend\modules\operatordashboard\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\operator\SafariOperator;

/**
 * Safari controller for the `operatordashboard` module
 */
class SafariController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $safari_operator = $this->findModel();

        return $this->render('index', ['safari_operator' => $safari_operator]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionParklist()
    {
        $safari_operator = $this->findModel();

        return $this->render('parklist', ['safari_operator' => $safari_operator]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionQuote()
    {
        $safari_operator = $this->findModel();

        return $this->render('quote', ['safari_operator' => $safari_operator]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSharedsafari()
    {
        $safari_operator = $this->findModel();

        return $this->render('sharedsafari', ['safari_operator' => $safari_operator]);
    }

    /**
     * Find Model of Operator
     */
    protected function findModel()
    {
        if (($model = SafariOperator::findOne(['user_id' => Yii::$app->user->identity->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
