<?php

namespace backend\modules\log\controllers;

use common\models\transaction\Transaction;
use common\models\transaction\TransactionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class TransactionController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = Transaction::find()->where(['id' => $id])->one();
        if(empty($model)){
            $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
            throw new NotFoundHttpException($message);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

}
