<?php

namespace frontend\modules\profile\controllers;


use Yii;
use yii\helpers\Url;
use common\models\User;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use frontend\models\article\ArticleForm;
use common\models\cms\article\ArticleTag;
use common\models\sharesafari\ShareSafari;
use common\models\cms\article\ArticleTopic;
use common\models\cms\article\ArticleAuthor;
use common\models\cms\article\ArticleComment;
use common\models\cms\article\ArticleCommentReport;
use frontend\controllers\FrontendBaseController;
use frontend\models\ArticleCommentReportForm;
use frontend\models\ArticleReplyForm;
use frontend\models\ArticleSearch;
use frontend\models\CommentForm;

/**
 * ArticleController.
 */
class ArticleController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $model = ShareSafari::find()->where(['host_user_id' => $user->id])->all();
        if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) {
            $articles = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id, 'status' => [Article::STATUS_ACTIVE, Article::STATUS_SUSPEND]])->orderby(['id' => SORT_DESC])->all();
        } else {
            $articles = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id, 'status' => Article::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
        }
        $sharesafrimodel = ShareSafari::find()->where(['host_user_id' => $user->id])->orderby(['id' => SORT_DESC])->limit(2)->all();
        $model_count = ShareSafari::find()->where(['host_user_id' => $user->id])->count();
        return $this->render(
            'index',
            [
                'user' => $user,
                'articles' => $articles,
                'model' => $model,
                'sharesafrimodel' => $sharesafrimodel,
                'model_count' => $model_count
            ]
        );
    }

    public function actionCreate()
    {
        $user = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
        $model = new ArticleForm();
        $model->action_url = '/profile/article/create';
        $model->action_validate_url = '/profile/article/validate';
        // $model->status = Article::STATUS_ACTIVE;
        $model->user_id = Yii::$app->user->identity->id;
        $model->user_type = Article::USER_TYPE_INDIVIDUAL;
        $model->scenario = 'create';
        $model->article_date = date('Y-m-d');
        $model->publish_date_time = date('Y-m-d h:i:s');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                if ($model->validate()) {
                    $model->meta_title = $model->title;
                    $model->initializeForm();
                    if ($model->article_model->save(false)) {
                        $model->uploadFile();

                        /**
                         * Here is the concept of generating article_author_id and author_name and first save in Article Author
                         */
                        $author = ArticleAuthor::find()->where(['user_type' => ArticleAuthor::AUTHOR_TYPE_INDIVIDUAL, 'user_id' => Yii::$app->user->identity->id])->limit(1)->one();
                        if (!$author) {
                            $author = new ArticleAuthor();
                        }
                        $author->user_id = Yii::$app->user->identity->id; // check here which id will user $this->module->user()->id
                        $author->author_name = Yii::$app->user->identity->name;
                        $author->status = 1;
                        if ($author->save()) {
                            $model->article_model->article_author_id = $author->id;
                            $model->article_model->author_name = $author->author_name;
                            $model->article_model->save(false);
                        };



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
                        \Yii::$app->session->setFlash('success', 'Article Created Successfully');
                        return $this->redirect(['/profile/article/index', 'user_handle' => $user->user_handle]);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionValidate($slug = null)
    {
        $model = new ArticleForm();
        if ($slug != null) {
            $formmodel = $this->findModel($slug);
            $model = new ArticleForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $slug ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Article::findOne(['slug' => $slug, 'user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => Yii::$app->user->identity->id, 'status' => [Article::STATUS_ACTIVE, Article::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Article Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $article_model = $this->findModel($slug);
        $user = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
        $model = new ArticleForm($article_model);
        $model->action_url = Url::toRoute(['/profile/article/update', 'slug' => $slug]);
        $model->action_validate_url = Url::toRoute(['/profile/article/validate', 'slug' => $slug]);
        $model->is_approved = 0;
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                if ($model->validate()) {
                    $model->meta_title = $model->title;
                    $model->initializeForm();
                    // Inactive if Anything is changed into form
                    if ($model->article_model->save(false)) {
                        $model->uploadFile();

                        $articleTopics = $model->article_topics;
                        if ($articleTopics) {
                            ArticleTopic::deleteAll(['article_id' => $article_model->id]);
                            foreach ($articleTopics as $articleT) {
                                $articleTopic = new ArticleTopic();
                                $articleTopic->article_id = $model->article_model->id;
                                $articleTopic->master_article_topic_id = $articleT;
                                $articleTopic->save(false);
                            }
                        }

                        $articleTags = $model->article_tags;
                        if ($articleTags) {
                            ArticleTag::deleteAll(['article_id' => $article_model->id]);
                            foreach ($articleTags as $articleT) {
                                $articleTag = new ArticleTag();
                                $articleTag->article_id = $model->article_model->id;
                                $articleTag->master_article_tag_id = $articleT;
                                $articleTag->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Artical Updated Successfully');
                        return $this->redirect(['/profile/article/index', 'user_handle' => $user->user_handle]);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug, $user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $article = Article::findOne(['slug' => $slug, 'user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id]);
        if (empty($article)) {
            return $this->redirect(['/profile/article/index', 'user_handle' => $user_handle]);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new CommentForm();
        $model->action_validate_url = '/profile/article/validate-comment';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->comment($article)) {
                    Yii::$app->session->setFlash('success', 'Comment submitted Successfully');
                    return $this->redirect(['/profile/article/view',  'slug' => $slug, 'user_handle' => $user->user_handle]);
                }
            }
        }

        return $this->render(
            'view',
            [
                'article' => $article,
                'user' => $user,
                'model' => $model,
            ]
        );
    }

    public function actionReply($slug, $user_handle, $parent_id)
    {

        $article = Article::findOne(['slug' => $slug, 'user_type' => Article::USER_TYPE_INDIVIDUAL, 'status' => Article::STATUS_ACTIVE]);
        if (empty($article)) {
            return $this->redirect(['/profile/article/index', 'user_handle' => $user_handle]);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $replymodel = new ArticleReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->action_validate_url = '/profile/article/validate-reply';


        if ($replymodel->load(Yii::$app->request->post())) {
            if ($replymodel->validate()) {
                if ($replymodel->reply($article)) {
                    Yii::$app->session->setFlash('success', 'Reply successfully submitted');
                    return $this->redirect(['/profile/article/view',  'slug' => $slug, 'user_handle' => $user_handle]);
                }
            }
        }

        return $this->renderAjax('_reply_form', ['replymodel' => $replymodel]);
    }

    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidateComment($id = null)
    {
        $commentmodel = new CommentForm();
        if ($id != null) {
            $formmodel = $this->findReplyModel($id);
            $commentmodel = new CommentForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $commentmodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($commentmodel);
        }
    }

    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidateReply($id = null)
    {
        $replymodel = new ArticleReplyForm();
        if ($id != null) {
            $formmodel = $this->findReplyModel($id);
            $replymodel = new ArticleReplyForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $replymodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($replymodel);
        }
    }

    protected function findReplyModel($id)
    {
        if (($model = ArticleComment::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFlag($slug, $article_comment_id, $user_handle)
    {
        $article = Article::findOne(['slug' => $slug, 'user_type' => Article::USER_TYPE_INDIVIDUAL, 'status' => Article::STATUS_ACTIVE]);
        if (empty($article)) {
            return $this->redirect(['/profile/article/index', 'user_handle' => $user_handle]);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $comments = ArticleComment::find()->where(['id' => $article_comment_id, 'status' => 1])->limit(1)->one();

        $model = new ArticleCommentReportForm();
        $model->article_id = $article->id;
        $model->article_comment_id = $article_comment_id;

        // $model->action_url = '/article/default';
        $model->action_validate_url = '/profile/article/validateflag';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->flag_model->save(false)) {
                        $comments->flaged = 1;
                        $comments->save(false);
                        Yii::$app->session->setFlash('success', 'Review Reported Successfully!');
                        return $this->redirect(['/profile/article/view',  'slug' => $slug, 'user_handle' => $user_handle]);
                    }
                }
            }
        } else {
            $model->flag_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_flag_form', [
                'model' => $model,
                'slug' => $slug,
                'comments' => $comments,
            ]);
        }
    }

    public function actionValidateflag($id = null)
    {
        $model = new ArticleCommentReportForm();
        if ($id != null) {
            $flag_model = $this->findflagModel($id);
            $model = new ArticleCommentReportForm($flag_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    protected function findflagModel($id)
    {
        if (($model = ArticleCommentReport::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
