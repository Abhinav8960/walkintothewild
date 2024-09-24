<?php

namespace backend\modules\cms\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleAuthor;
use common\models\cms\article\ArticleComment;
use common\models\cms\article\ArticleCommentReport;
use common\models\cms\article\ArticleCommentSearch;
use common\models\cms\article\ArticleSearch;
use common\models\cms\article\ArticleTag;
use common\models\cms\article\ArticleTopic;
use common\models\cms\article\form\ArticleCommentActionForm;
use common\models\cms\article\form\ArticleDeleteForm;
use common\models\cms\article\form\ArticleForm;
use common\models\cms\article\MasterArticleTag;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * Article Controller for the `article` module
 */
class ArticleController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $searchModel->status = Article::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Article Author
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleForm();
        $model->action_url = '/cms/article/create';
        $model->action_validate_url = '/cms/article/validate';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_model->save(false)) {
                        $model->uploadFile();

                        $articleTopics = $model->article_topics;
                        if ($articleTopics) {
                            foreach ($articleTopics as $articleT) {
                                $articleTopic = new ArticleTopic();
                                $articleTopic->article_id = $model->article_model->id;
                                $articleTopic->master_topic_id = $articleT;
                                $articleTopic->save(false);
                            }
                        }

                        $articleTags = $model->article_tags;
                        if ($articleTags) {
                            foreach ($articleTags as $articleT) {
                                $articleTag = new ArticleTag();
                                $articleTag->article_id = $model->article_model->id;
                                $articleTag->master_tag_id = $articleT;
                                $articleTag->save(false);
                            }
                        }
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/cms/article/index']);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Article Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $article_model = $this->findModel($id);
        $model = new ArticleForm($article_model);
        $model->action_url = '/cms/article/update?id=' . $id;
        $model->action_validate_url = '/cms/article/validate?id=' . $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_model->save(false)) {
                        $model->uploadFile();

                        $articleTopics = $model->article_topics;
                        if ($articleTopics) {
                            ArticleTopic::deleteAll(['article_id' => $id]);
                            foreach ($articleTopics as $articleT) {
                                $articleTopic = new ArticleTopic();
                                $articleTopic->article_id = $model->article_model->id;
                                $articleTopic->master_topic_id = $articleT;
                                $articleTopic->save(false);
                            }
                        }

                        $articleTags = $model->article_tags;
                        if ($articleTags) {
                            ArticleTag::deleteAll(['article_id' => $id]);
                            foreach ($articleTags as $articleT) {
                                $articleTag = new ArticleTag();
                                $articleTag->article_id = $model->article_model->id;
                                $articleTag->master_tag_id = $articleT;
                                $articleTag->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/cms/article/index']);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Validate Form
     */
    public function actionValidate($id = null)
    {
        $model = new ArticleForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new ArticleForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionArticleView($id)
    {
        $article = Article::find()->where(['id' => $id])->limit(1)->one();

        $searchModel = new ArticleCommentSearch();
        $searchModel->article_id = $article->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => null]);

        return $this->render(
            'articleview',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'article' => $article,
            ]
        );
    }


    public function actionEdit($id)
    {
        $comment_action_model = ArticleCommentReport::find()->where(['id' => $id])->limit(1)->one();
        $model = new ArticleCommentActionForm($comment_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->comment_action_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Action Taken Successfully');
                        return $this->redirect(\Yii::$app->request->referrer);
                    }
                }
            }
        } else {
            $model->comment_action_model->loadDefaultValues();
        }
        return $this->renderAjax('edit', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {

        $dataProvider = new ActiveDataProvider([
            'query' =>  ArticleCommentReport::find()->where(['article_comment_id' => $id, 'status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('view', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id, 'status' => [Article::STATUS_ACTIVE, Article::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    // public function actionArticledelete($id)
    // {
    //     $delete_article_model = $this->findModel($id);
    //     $model = new ArticleDeleteForm($delete_article_model);
    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->delete_article_model->save(false)) {
    //                     \Yii::$app->session->setFlash('success', 'Successfully Update');
    //                     return $this->redirect(['index']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->delete_article_model->loadDefaultValues();
    //     }
    //     return $this->renderAjax('delete_form', [
    //         'approval_model' => $model,
    //     ]);
    // }


    public function actionReplyview($id)
    {
        $review = ArticleComment::find()->where(['parent_id' => $id]);
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

    public function actionFlagview($id)
    {
        $review = ArticleCommentReport::find()->where(['article_comment_id' => $id]);
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
        return $this->renderAjax('_flagview', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
