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
        $model->status = SafariSuggestions::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = SafariSuggestions::findOne(['id' => $id, 'status' => [SafariSuggestions::STATUS_ACTIVE, SafariSuggestions::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
