<?php

namespace frontend\modules\profile\controllers;


use common\models\cms\article\Article;
use common\models\cms\article\ArticleAuthor;
use common\models\cms\article\ArticleTag;
use common\models\cms\article\ArticleTopic;
use common\models\sharesafari\ShareSafari;
use frontend\controllers\FrontendBaseController;
use frontend\models\article\ArticleForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ArticleController.
 */
class ArticleController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = ShareSafari::find()->where(['host_user_id' => $this->module->user()->id])->all();
        $articles = Article::find()->where(['user_id' => $this->module->user()->id])->all();
        return $this->render(
            'index',
            [
                'user' => $this->module->user(),
                'articles' => $articles,
                'model' => $model
            ]
        );
    }

    public function actionCreate()
    {
        $model = new ArticleForm();
        $model->action_url = '/profile/article/create';
        $model->action_validate_url = '/profile/article/validate';
        $model->status = Article::STATUS_SUSPEND;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_model->save(false)) {
                        $model->uploadFile();

                        /**
                         * Here is the concept of generating article_author_id and author_name and first save in Article Author
                         */
                        $author = ArticleAuthor::find()->where(['user_id' => Yii::$app->user->identity->id])->limit(1)->one();
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
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

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
