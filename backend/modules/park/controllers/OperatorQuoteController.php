<?php

namespace backend\modules\park\controllers;


use common\models\operator\OperatorQuote;
use common\models\operator\OperatorQuoteSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OperatorQuoteController.
 */
class OperatorQuoteController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OperatorQuoteSearch();
        // $searchModel->report_days = 'today';
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->full_name = $model->id . '_' . $model->full_name;
        $model->status = OperatorQuote::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = OperatorQuote::findOne(['id' => $id, 'status' => [OperatorQuote::STATUS_ACTIVE, OperatorQuote::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
