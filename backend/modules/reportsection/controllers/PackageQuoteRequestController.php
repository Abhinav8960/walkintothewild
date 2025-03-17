<?php

namespace backend\modules\reportsection\controllers;

use common\models\package\PackageQuote;
use common\models\package\PackageQuoteSearch;
use yii\web\Controller;

/**
 * PackageQuoteRequestController.
 */
class PackageQuoteRequestController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackageQuoteSearch();
        $searchModel->status = PackageQuote::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
