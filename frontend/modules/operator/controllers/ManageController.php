<?php

namespace frontend\modules\operator\controllers;

use Yii;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use frontend\controllers\FrontendBaseController;

/**
 * ManageController.
 */
class ManageController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Manage Operator List
     */
    public function actionIndex()
    {
        $safari_operator = $this->operatormodel();

        $query = OperatorQuote::find()->where(['operator_id' => $safari_operator->id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $review_query = SafariOperatorRating::find()->where(['safari_operator_id' => $safari_operator->id]);
        $review_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $review_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        $follow_query = SafariOperatorFollow::find()->where([
            'safari_operator_id' => $safari_operator->id,
            'status' => 1
        ]);
        $follow_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $follow_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'user' => Yii::$app->user->identity,
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider,
            'review_dataProvider' => $review_dataProvider,
            'follow_dataProvider' => $follow_dataProvider
        ]);
    }

    /**
     * Park List of Operator
     */
    public function actionPark()
    {
        $safari_operator = $this->operatormodel();


        return $this->render('park', ['safari_operator' => $safari_operator]);
    }


    /**
     * Check if Currect user is a Operator
     */
    protected function operatormodel()
    {
        if (Yii::$app->user->identity->is_safari_operator != 1) {
            return $this->redirect(['/']);
        }
        return SafariOperator::find()->where(['user_id' => Yii::$app->user->id])->limit(1)->one();
    }
}
