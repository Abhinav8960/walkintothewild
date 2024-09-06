<?php

namespace backend\modules\flag\controllers;

use common\models\UntracedFlagSearch;
use Yii;
use yii\web\Controller;


class UntracedFlagController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UntracedFlagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
