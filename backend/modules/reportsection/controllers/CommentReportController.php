<?php

namespace backend\modules\reportsection\controllers;

use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * CommentReportController.
 */
class CommentReportController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariCommentSearch();
        $dataProvider = $searchModel->listingsearch($this->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => null]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionReply()
    {
        $searchModel = new ShareSafariCommentSearch();
        $dataProvider = $searchModel->listingsearch($this->request->queryParams);
        $dataProvider->query->andWhere(['not', ['parent_id' => null]]);
        return $this->render('replylist', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionReplyview($id)
    {
        $review = ShareSafariComment::find()->where(['parent_id' => $id]);
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  $review,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('_replyview', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
