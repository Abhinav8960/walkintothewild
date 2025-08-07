<?php

namespace backend\modules\reportsection\controllers;

use common\models\package\PackageVersion;
use common\models\package\PackageVersionSearch;
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
        $searchModel = new PackageVersionSearch();
        $dataProvider = $searchModel->reportsearch($this->request->queryParams);
        $dataProvider->query->andWhere("safari_operator_id IN (SELECT id from safari_operator WHERE status=1)");
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
