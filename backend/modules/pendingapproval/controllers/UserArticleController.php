<?php

namespace backend\modules\pendingapproval\controllers;


use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleSearch;
use common\models\pendingapproval\form\UserArticleApprovalForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserArticleController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $searchModel->status = Article::STATUS_ACTIVE;
        $searchModel->is_approved = 0;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    // public function actionView($id)
    // {
    //     $user_article_approval_model = $this->findModel($id);
    //     $model = new UserArticleApprovalForm($user_article_approval_model);
    //     $model->status = Article::STATUS_ACTIVE;
    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->user_article_approval_model->save(false)) {
    //                     \Yii::$app->session->setFlash('success', 'Successfully Update');
    //                     return $this->redirect(['index']);
    //                 }
    //             } else {
    //                 print_r($model->errors);
    //                 die();
    //             }
    //         }
    //     } else {
    //         $model->user_article_approval_model->loadDefaultValues();
    //     }
    //     return $this->render('view', [
    //         'model' => $user_article_approval_model,
    //         'approval_model' => $model,
    //     ]);
    // }


    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id, 'status' => [Article::STATUS_ACTIVE, Article::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->title = $model->id . '_' . $model->title;
        $model->slug = $model->id . '_' . $model->slug;
        $model->status = Article::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Deleted Successfully');
        return $this->redirect(Yii::$app->request->referrer);
    }
}
