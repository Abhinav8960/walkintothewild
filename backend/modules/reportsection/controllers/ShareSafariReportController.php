<?php

namespace backend\modules\reportsection\controllers;

use common\models\sharesafari\ShareSafariSearch;
use yii\web\Controller;

/**
 * ShareSafariReportController.
 */
class ShareSafariReportController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        $dataProvider = $searchModel->reportsearch($this->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
