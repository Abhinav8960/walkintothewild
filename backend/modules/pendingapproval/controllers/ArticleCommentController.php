<?php

namespace backend\modules\pendingapproval\controllers;

use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleCommentController extends Controller
{
    public function actionIndex()
    {
        $query = ArticleComment::find()->where(['status' => 3]);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ],
        );

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }



    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {


        $article = Article::find()->where(['status' => Article::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if (empty($article)) {
            return $this->redirect(['/pendingapproval/article-comment/index']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }



        return $this->render(
            'view',
            [
                'article' => $article,
            ]
        );
    }



    public function actionApproved($id)
    {
        $model = ArticleComment::find()->where(['id' => $id])->one();
        $model->status = 1;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Approved Successfully');
        return $this->redirect(['/pendingapproval/article-comment/index']);
    }

    public function actionDisapproved($id)
    {
        $model = ArticleComment::find()->where(['id' => $id])->one();
        $model->status = 2;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Disapproved Successfully');
        return $this->redirect(['/pendingapproval/article-comment/index']);
    }
}
