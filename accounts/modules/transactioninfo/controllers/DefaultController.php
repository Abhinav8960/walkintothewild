<?php

namespace accounts\modules\transactioninfo\controllers;

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
        $initated_transaction = Transaction::find()->where(['status' => Transaction::STATUS_INITIATED])->count();
        $failed_transaction = Transaction::find()->where(['status' => Transaction::STATUS_FAILED])->count();
        $success_transaction = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->count();

        $searchModel = new TransactionSearch();
        $searchModel->status = $status;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'initated_transaction' => $initated_transaction,
            'failed_transaction' => $failed_transaction,
            'success_transaction' => $success_transaction,
        ]);
    }
}
