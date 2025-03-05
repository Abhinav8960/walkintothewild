<?php

namespace backend\modules\reportsection\controllers;

use common\models\package\Package;
use common\models\package\PackageSearch;
use yii\web\Controller;

/**
 * PackageReportController.
 */
class PackageReportController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->reportsearch($this->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
