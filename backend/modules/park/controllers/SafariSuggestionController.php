<?php

namespace backend\modules\park\controllers;

use common\interfaces\StatusInterface;
use common\models\operator\OperatorQuote;
use common\models\operator\OperatorQuoteSearch;
use common\models\suggestions\SafariSuggestions;
use common\models\suggestions\SafariSuggestionsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SafariSuggestionController.
 */
class SafariSuggestionController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariSuggestionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->full_name = $model->id . '_' . $model->full_name;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = SafariSuggestions::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
