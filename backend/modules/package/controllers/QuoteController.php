<?php

namespace backend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\package\PackageQuote;
use common\models\package\PackageQuoteSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * QuoteController.
 */
class QuoteController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackageQuoteSearch();
        $searchModel->report_days = 'today';
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = PackageQuote::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
