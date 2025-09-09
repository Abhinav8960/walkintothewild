<?php

namespace backend\modules\transactioninfo\controllers;

use common\models\transaction\Transaction;
use common\models\transaction\TransactionSearch;
use yii\web\Controller;
use yii;

/**
 * Default controller for the `transactioninfo` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($status = null)
    {
        $initiated_count = Transaction::find()->where(['status' => Transaction::STATUS_INITIATED])->count();
        $failed_count = Transaction::find()->where(['status' => Transaction::STATUS_FAILED])->count();
        $success_count = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->count();

        $searchModel = new TransactionSearch();
        $searchModel->status = $status;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'initiated_count' => $initiated_count,
            'failed_count' => $failed_count,
            'success_count' => $success_count,
        ]);
    }
    
}
