<?php

namespace backend\modules\operatorapproval\controllers;

use common\models\operatorregistration\OperatorRegistration;
use common\models\operatorregistration\OperatorRegistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OperatorRegistrationSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionUpdate($id)
    // {

    //     $model = $this->findModel($id);
    // }

    protected function findModel($id)
    {
        if (($model = OperatorRegistration::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
