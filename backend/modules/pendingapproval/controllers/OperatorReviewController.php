<?php

namespace backend\modules\pendingapproval\controllers;

use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OperatorReviewController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new SafariOperatorRatingSearch();
        $searchModel->status = SafariOperatorRating::STATUS_CREATED;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApproved($id)
    {
        $model = $this->findModel($id);
        if ($model->status == 10) {
            $model->status = SafariOperatorRating::STATUS_ACTIVE;
            if ($model->save(false)) {
                $operator = $model->operator;
                $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $model->safari_operator_id, 'is_deleted' => 0])->average('rating');
                $count = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $model->safari_operator_id, 'is_deleted' => 0])->count();
                $operator->google_rating = $avg;
                $operator->google_review_count = $count;
                $operator->save(false);
            }
            \Yii::$app->getSession()->setFlash('success', 'Approved Successfully');
        }
        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = SafariOperatorRating::findOne(['id' => $id, 'status' => SafariOperatorRating::STATUS_CREATED])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
