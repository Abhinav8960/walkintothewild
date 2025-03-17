<?php

namespace backend\modules\reportsection\controllers;

use common\models\operator\OperatorQuote;
use common\models\operator\OperatorQuoteSearch;
use yii\web\Controller;

/**
 * OperatorQuoteRequestController.
 */
class OperatorQuoteRequestController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OperatorQuoteSearch();
        $searchModel->status = OperatorQuote::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
