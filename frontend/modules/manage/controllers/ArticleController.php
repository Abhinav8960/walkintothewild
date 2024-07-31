<?php

namespace frontend\modules\manage\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use frontend\models\article\ArticleForm;
use common\models\cms\article\ArticleTag;
use common\models\cms\article\ArticleTopic;
use common\models\cms\article\ArticleAuthor;
use frontend\controllers\FrontendBaseController;

/**
 * Default controller for the `manage` module
 */
class ArticleController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $query = Article::find()->where([
            'user_type' => Article::USER_TYPE_SAFARI_OPERATOR, 'user_id' => $safari_operator->id
        ]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => ['defaultOrder' => [
                'id' => SORT_DESC
            ]]
        ]);

        return $this->render('index', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionCreate()
    {
        $safari_operator = $this->module->operatormodel();
        $model = new ArticleForm();
        $model->action_url = '/manage/article/create';
        $model->action_validate_url = '/manage/article/validate';
        $model->status = Article::STATUS_ACTIVE;
        $model->user_id = $safari_operator->id;
        $model->user_type = Article::USER_TYPE_SAFARI_OPERATOR;
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

                        $author = ArticleAuthor::find()->where(['user_type' => ArticleAuthor::AUTHOR_TYPE_SAFARI_OPERATOR, 'user_id' => $safari_operator->id])->limit(1)->one();
                        if (!$author) {
                            $author = new ArticleAuthor();
                        }
                        $author->user_id = $safari_operator->id;
                        $author->author_name = $safari_operator->business_name;
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
                        return $this->redirect(['/manage/article/index']);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'safari_operator' => $safari_operator,
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
        $safari_operator = $this->module->operatormodel();

        if (($model = Article::findOne(['slug' => $slug, 'user_type' => Article::USER_TYPE_SAFARI_OPERATOR, 'user_id' => $safari_operator->id, 'status' => [Article::STATUS_ACTIVE, Article::STATUS_SUSPEND]])) !== null) {
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
        $safari_operator = $this->module->operatormodel();
        $article_model = $this->findModel($slug);
        $model = new ArticleForm($article_model);
        $model->action_url = Url::toRoute(['/manage/article/update', 'slug' => $slug]);
        $model->action_validate_url = Url::toRoute(['/manage/article/validate', 'slug' => $slug]);
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
                        $model->article_model->status = Article::STATUS_ACTIVE;
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
                        return $this->redirect(['/manage/article/index']);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'safari_operator' => $safari_operator,
        ]);
    }
}
