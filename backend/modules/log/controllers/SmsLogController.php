<?php

namespace backend\modules\log\controllers;

use common\models\SmsLogSearch;
use yii\web\Controller;

/**
 * NotificationLogController.
 */
class SmsLogController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SmsLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
