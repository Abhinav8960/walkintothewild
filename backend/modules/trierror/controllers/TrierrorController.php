<?php

namespace app\modules\admin\modules\trierror\controllers;
use app\models\trierror\ErrorLogSearch;
use yii\web\Controller;
use yii;
/**
 * Default controller for the `lamp` module
 */
class TrierrorController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ErrorLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGoogle()
    {
        $searchModel = new ErrorLogSearch();
        $searchModel->reference_url ="google" ;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('google', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrsindia()
    {
        $searchModel = new ErrorLogSearch();
        $searchModel->reference_url ="prs" ;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('prsindia', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMissingpdf()
    {
        $searchModel = new ErrorLogSearch();
        $searchModel->request_url =".pdf" ;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('missingpdf', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}
