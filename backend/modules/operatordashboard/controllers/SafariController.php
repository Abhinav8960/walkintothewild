<?php

namespace backend\modules\operatordashboard\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;

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

        $query = OperatorQuote::find()->where(['operator_id' => $safari_operator->id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('quote', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
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
     * Renders the index view for the module
     * @return string
     */
    public function actionReview()
    {
        $safari_operator = $this->findModel();
        $query = SafariOperatorRating::find()->where(['safari_operator_id' => $safari_operator->id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('review', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionFollower()
    {
        $safari_operator = $this->findModel();
        $query = SafariOperatorFollow::find()->where([
            'safari_operator_id' => $safari_operator->id,
            'status' => 1
        ]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('follower', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
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
