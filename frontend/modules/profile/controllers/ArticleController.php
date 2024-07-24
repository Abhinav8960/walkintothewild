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
use frontend\controllers\FrontendBaseController;

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
        if (Yii::$app->user->identity->id == $user->id) {
            $articles = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id])->orderby(['id' => SORT_DESC])->all();
        } else {
            $articles = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id, 'status' => Article::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
        }
        return $this->render(
            'index',
            [
                'user' => $user,
                'articles' => $articles,
                'model' => $model
            ]
        );
    }

    public function actionCreate()
    {
        $user = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
        $model = new ArticleForm();
        $model->action_url = '/profile/article/create';
        $model->action_validate_url = '/profile/article/validate';
        $model->status = Article::STATUS_ACTIVE;
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
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
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
                    if ($model->article_model->dirtyattributes) {
                        $model->article_model->status = Article::STATUS_SUSPEND;
                    }
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

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
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
}
