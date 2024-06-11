<?php

namespace backend\modules\operator\controllers;

use common\interfaces\StatusInterface;
use common\models\registration\BirdingOperatorRequest;
use frontend\models\BirdingOperatorRequestSearch;
use yii\base\Controller;
use yii\web\NotFoundHttpException;

/**
 * BirdingOperatorController.
 */
class BirdingOperatorController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BirdingOperatorRequestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = BirdingOperatorRequest::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
