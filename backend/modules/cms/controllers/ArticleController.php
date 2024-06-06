<?php

namespace backend\modules\cms\controllers;

use common\interfaces\StatusInterface;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleSearch;
use common\models\cms\article\ArticleTopic;
use common\models\cms\article\form\ArticleForm;
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
                    if ($model->article_model->save()) {
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
}
