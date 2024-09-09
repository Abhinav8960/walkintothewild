<?php

namespace backend\modules\cms\controllers;

use common\interfaces\StatusInterface;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use common\models\cms\article\ArticleCommentReport;
use common\models\cms\article\ArticleCommentSearch;
use common\models\cms\article\ArticleSearch;
use common\models\cms\article\ArticleTag;
use common\models\cms\article\ArticleTopic;
use common\models\cms\article\form\ArticleCommentActionForm;
use common\models\cms\article\form\ArticleForm;
use common\models\cms\article\MasterArticleTag;
use common\models\pendingapproval\form\UserArticleApprovalForm;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * Article Controller for the `blog` module
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
        // $dataProvider->query->andWhere("user_type=3");

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
        $model->user_type = Article::USER_TYPE_ADMIN;
        $model->status = Article::STATUS_ACTIVE;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_model->save(false)) {
                        $model->uploadFile();

                        $articleTopics = $model->article_topics;
                        if ($articleTopics) {
                            foreach ($articleTopics as $articleT) {
                                $articleTopic = new ArticleTopic();
                                $articleTopic->article_id = $model->article_model->id;
                                $articleTopic->master_article_topic_id = $articleT;
                                $articleTopic->save(false);
                            }
                        }

                        $articleTags = $model->article_tags;
                        if ($articleTags) {
                            foreach ($articleTags as $articleT) {
                                $articleTag = new ArticleTag();
                                $articleTag->article_id = $model->article_model->id;
                                $articleTag->master_article_tag_id = $articleT;
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

        return $this->render('form', [
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

        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
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
                                $articleTopic->master_article_topic_id = $articleT;
                                $articleTopic->save(false);
                            }
                        }

                        $articleTags = $model->article_tags;
                        if ($articleTags) {
                            ArticleTag::deleteAll(['article_id' => $id]);
                            foreach ($articleTags as $articleT) {
                                $articleTag = new ArticleTag();
                                $articleTag->article_id = $model->article_model->id;
                                $articleTag->master_article_tag_id = $articleT;
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

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionAddTag()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tags = Yii::$app->request->post('tags');

        if (is_array($tags)) {
            // Handle the case where 'tags' is an array (e.g., if multiple tags are submitted)
            $tagsArray = $tags;
        } elseif (is_string($tags)) {
            // Handle the case where 'tags' is a string (e.g., if only one tag is submitted)
            $tagsArray = explode(',', $tags);
        } else {
            // Handle any other unexpected cases
            return ['success' => false, 'message' => 'Invalid tags format'];
        }

        if (!empty($tagsArray)) {
            $existingTags = MasterArticleTag::find()->select('title')->column();

            foreach ($tagsArray as $tag) {
                $tag = trim($tag);
                if (!in_array($tag, $existingTags)) {
                    $newTag = new MasterArticleTag();
                    $newTag->title = $tag;
                    $newTag->slug = $tag;
                    $newTag->status = MasterArticleTag::STATUS_ACTIVE;
                    if (!$newTag->save(false)) {
                        return ['success' => false, 'message' => 'Failed to save tag: ' . $newTag->title];
                    }
                }
            }
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'No tags provided'];
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

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $articleTopics = ArticleTopic::findAll(['article_id' => $model->id]);
        if (!empty($articleTopics)) {
            foreach ($articleTopics as $articleTopic) {
                $articleTopic->status = StatusInterface::STATUS_DELETE;
                $articleTopic->save();
            }
        }

        $model->title = $model->id . '_' . $model->title;
        $model->slug = $model->id . '_' . $model->slug;
        $model->status = Article::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(Yii::$app->request->referrer);
    }








    public function actionComment($id)
    {
        $article = Article::find()->where(['id' => $id])->limit(1)->one();

        $searchModel = new ArticleCommentSearch();
        $searchModel->article_id = $article->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => null]);

        return $this->render(
            'comment',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
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
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDisapproved($id)
    {
        $model = ArticleComment::find()->where(['id' => $id])->one();
        $model->status = 2;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Disapproved Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
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
            'query' =>  ArticleCommentReport::find()->where(['article_comment_id' => $id, 'status' => [1, 20]]),
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
    //     $model = $this->findModel($id);
    //     $model->status = Article::STATUS_DELETE;
    //     $model->save();
    //     \Yii::$app->session->setFlash('success', 'Deleted Successfully');
    //     return $this->redirect(['index']);
    // }

    public function actionArticledelete($id)
    {
        $user_article_approval_model = $this->findModel($id);
        $model = new UserArticleApprovalForm($user_article_approval_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_article_approval_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Update');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_article_approval_model->loadDefaultValues();
        }
        return $this->renderAjax('delete_form', [
            'approval_model' => $model,
        ]);
    }


    public function actionApproval($id)
    {
        $user_article_approval_model = $this->findModel($id);
        $model = new UserArticleApprovalForm($user_article_approval_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_article_approval_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Update');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_article_approval_model->loadDefaultValues();
        }
        return $this->renderAjax('approval_form', [
            'approval_model' => $model,
        ]);
    }


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
