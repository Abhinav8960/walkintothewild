<?php

namespace backend\modules\trierror\controllers;

use common\models\trierror\BackendErrorLogSearch;
use common\models\trierror\ErrorLogSearch;
use common\models\trierror\FrontendErrorLogSearch;
use yii\web\Controller;
use yii;

/**
 * Default controller for the `error` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BackendErrorLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionFrontIndex()
    {
        $searchModel = new FrontendErrorLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('front_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
