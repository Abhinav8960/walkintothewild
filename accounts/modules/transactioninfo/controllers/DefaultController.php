<?php

namespace accounts\modules\transactioninfo\controllers;

use common\models\transaction\form\TransactionUpdateDetailForm;
use common\models\transaction\Transaction;
use common\models\transaction\TransactionSearch;
use yii\web\Controller;
use yii;
use yii\web\NotFoundHttpException;


/**
 * Default controller for the `transactioninfo` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($custom_days = null)
    {
        $today_success_transaction = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->andWhere(['between', 'created_at', strtotime('today'), strtotime('tomorrow') - 1])->count();
        $last_three_day_success_transaction = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->andWhere(['between', 'created_at', strtotime('-3 days'), time()])->count();
        $last_seven_day_success_transaction = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->andWhere(['between', 'created_at', strtotime('-7 days'), time()])->count();

        $searchModel = new TransactionSearch();
        $searchModel->status = Transaction::STATUS_SUCCESS;
        $searchModel->custom_days = $custom_days;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'today_success_transaction' => $today_success_transaction,
            'last_three_day_success_transaction' => $last_three_day_success_transaction,
            'last_seven_day_success_transaction' => $last_seven_day_success_transaction,
        ]);
    }

    public function actionUpdatePayuStatus($id)
    {
        $transaction = Transaction::findOne($id);
        if (!$transaction) {
            throw new NotFoundHttpException('Transaction not found!!!');
        }
        $transaction->payment_received_at_payu = 1;
        if ($transaction->save(false)) {
            return $this->redirect(['index']);
        }
    }

    public function actionUpdateTransactionDetail($id)
    {
        $transaction = Transaction::findOne($id);
        if (!$transaction) {
            throw new NotFoundHttpException('Transaction not found!!!');
        }

        $model = new TransactionUpdateDetailForm($transaction);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->transation_update_detail_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}'=>'Transaction Details']);
                        Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->transation_update_detail_model->loadDefaultValues();
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
}
