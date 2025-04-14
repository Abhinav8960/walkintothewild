<?php

namespace backend\modules\home\controllers;

use common\models\sighting\Sighting;
use common\models\sighting\SightingSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SightingController.
 */
class SightingController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new SightingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        if ($model->status == 0) {
            $model->status = Sighting::STATUS_ACTIVE;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Published Successfully');
        } else {
            $model->status = Sighting::STATUS_SUSPEND;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Suspend Successfully');
        }

        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = Sighting::findOne(['id' => $id, 'status' => [Sighting::STATUS_ACTIVE, Sighting::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
