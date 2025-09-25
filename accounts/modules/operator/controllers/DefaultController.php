<?php

namespace accounts\modules\operator\controllers;

use common\models\operator\SafariOperator;
use yii\web\Controller;
use common\models\operator\SafariOperatorSearch;
use yii\web\NotFoundHttpException;

/**
 * SafariOperatorController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariOperatorSearch();
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

        return $this->render('view', ['model' => $model]);
    }

    protected function findModel($id)
    {
        if (($model = SafariOperator::findOne(['id' => $id, 'status' => [SafariOperator::STATUS_ACTIVE, SafariOperator::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}