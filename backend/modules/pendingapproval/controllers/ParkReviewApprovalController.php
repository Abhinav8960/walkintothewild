<?php

namespace backend\modules\pendingapproval\controllers;


use common\interfaces\StatusInterface;
use common\models\park\SafariParkRating;
use common\models\park\SafariParkRatingSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParkReviewApprovalController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new SafariParkRatingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApproved($id)
    {
        $model = $this->findModel($id);
        if ($model->status == 2) {
            $model->status = StatusInterface::STATUS_ACTIVE;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Approved Successfully');
        } else {
            $model->status = StatusInterface::STATUS_SUSPEND;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Disapproved Successfully');
        }

        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = SafariParkRating::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
