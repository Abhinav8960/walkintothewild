<?php

namespace frontend\modules\manage\controllers;

use Yii;
use frontend\controllers\FrontendBaseController;
use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingReportSearch;

/**
 * Default controller for the `manage` module
 */
class ReviewController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $review_query = SafariOperatorRating::find()->where(['safari_operator_id' => $safari_operator->id]);
        $review_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $review_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', [
            'safari_operator' => $safari_operator,
            'review_dataProvider' => $review_dataProvider
        ]);
    }


    /**
     * Flag View
     */
    public function actionFlagview($id)
    {
        $safari_operator = $this->module->operatormodel();

        $searchModel = new SafariOperatorRatingReportSearch();
        $searchModel->safari_operator_rating_id = $id;
        $searchModel->status = 1;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('flag_review', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'safari_operator' => $safari_operator,
            ]);
        }
    }
}
