<?php

namespace backend\modules\reportsection\controllers;

use common\models\quatation\QuotationRequests;
use common\models\quatation\QuotationRequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * QuotationController.
 */
class QuotationController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuotationRequestsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionMarkSeen($id)
    {
        $model = QuotationRequests::findOne($id);
        if ($model) {
            $model->is_seen_by_admin = 1;
            $model->save(false);
        }
        return $this->redirect(['index']);
    }

    public function actionMarkUnseen($id)
    {
        $model = QuotationRequests::findOne($id);
        if ($model) {
            $model->is_seen_by_admin = 0;
            $model->save(false);
        }
        return $this->redirect(['index']);
    }

    public  function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = QuotationRequests::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
