<?php

namespace frontend\modules\profile\controllers;

use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingReportSearch;
use frontend\controllers\FrontendBaseController;
use Yii;

/**
 * BusinessController.
 */
class BusinessController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->identity) {
            \Yii::$app->response->redirect('/site/login')->send();
        } else {
            if (Yii::$app->user->identity->is_safari_operator != 1) {
                throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Operator can View this page.');
            }
        }

        $safari_operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->id])->limit(1)->one();
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
            'user' => $this->module->user(),
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider,
            'review_dataProvider' => $review_dataProvider,
            'follow_dataProvider' => $follow_dataProvider
        ]);
    }

    public function actionFlagview($id)
    {

        $searchModel = new SafariOperatorRatingReportSearch();
        $searchModel->safari_operator_rating_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $safari_operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->id])->limit(1)->one();

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('flag_review', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'safari_operator' => $safari_operator,
            ]);
        }
    }
}
