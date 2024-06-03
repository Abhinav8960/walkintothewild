<?php
// In backend/controllers/LogController.php

namespace backend\modules\portalsetting\controllers;

use common\models\RenderedContentSearch;
use Yii;
use yii\web\Controller;

class PageviewController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new RenderedContentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
