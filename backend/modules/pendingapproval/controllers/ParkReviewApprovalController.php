<?php

namespace backend\modules\pendingapproval\controllers;

use common\models\GeneralModel;
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
        if ($model->status == 0) {
            $model->status = SafariParkRating::STATUS_ACTIVE;
            if ($model->save(false)) {
                $safari_park = $model->park;
                GeneralModel::updateRatingintoTable($safari_park);
            }
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Approved']);
            \Yii::$app->getSession()->setFlash('success', $message);
        } else {
            $model->status = SafariParkRating::STATUS_SUSPEND;
            $model->save(false);
            if ($model->save(false)) {
                $safari_park = $model->park;
                GeneralModel::updateRatingintoTable($safari_park);
            }
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Disapproved']);
            \Yii::$app->getSession()->setFlash('success', $message);
        }

        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = SafariParkRating::findOne(['id' => $id, 'status' => [SafariParkRating::STATUS_ACTIVE, SafariParkRating::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
