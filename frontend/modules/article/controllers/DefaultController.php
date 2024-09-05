<?php

namespace frontend\modules\article\controllers;

use common\interfaces\StatusInterface;
use common\models\article\article\form\ArticleForm;
use Yii;
use frontend\models\CommentForm;
use common\models\park\SafariPark;
use frontend\models\ArticleSearch;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleAuthor;
use common\models\cms\article\ArticleComment;
use common\models\cms\article\MasterArticleTag;
use frontend\controllers\FrontendBaseController;
use common\models\cms\article\MasterArticleTopic;
use frontend\models\ArticleCommentReportForm;
use frontend\models\ArticleReplyForm;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{
    /**
     * Actions ids for Save Page Views
     */
    public $action_ids = ['index', 'view', 'topic', 'tag', 'author'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $searchModel->status = Article::USER_PUBLISHED;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
        ]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $article = Article::find()->where(['status' => Article::USER_PUBLISHED, 'slug' => $slug])
            ->andWhere(ArticleSearch::addtionalQuery())
            ->limit(1)->one();


        if (empty($article)) {
            return $this->redirect(['/article']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new CommentForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($article)) {
            Yii::$app->session->setFlash('success', 'Comment submitted Successfully');
            return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
        }
        $replymodel = new ArticleReplyForm();
        if ($replymodel->load(Yii::$app->request->post()) && $replymodel->validate() && $replymodel->reply($article)) {
            Yii::$app->session->setFlash('success', 'Reply successfully submitted');
            return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
        }
        return $this->render(
            'view',
            [
                'article' => $article,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'replymodel' => $replymodel,
                'model' => $model,
            ]
        );
    }


    /**
     * Articles by Topic
     */
    public function actionTopic($slug)
    {
        $searchModel = new ArticleSearch();
        $searchModel->topic_slug = $slug;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();

        $article_topic = MasterArticleTopic::find()->where(['slug' => $slug])->one();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'slug' => $slug,
            'sub_title' => '<b>Category :</b> ' . ($article_topic ? $article_topic->title : strtoupper($slug)),
        ]);
    }

    /**
     * Articles by Tag
     */
    public function actionTag($slug)
    {
        $searchModel = new ArticleSearch();
        $searchModel->tag_slug = $slug;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();

        $article_tag = MasterArticleTag::find()->where(['slug' => $slug])->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'slug' => $slug,
            'sub_title' => '<b>Tag :</b> ' . ($article_tag ? $article_tag->title : strtoupper($slug)),
        ]);
    }

    /**
     * Articles by Author
     */
    public function actionAuthor($slug)
    {
        $article_author = ArticleAuthor::find()->where(['slug' => $slug])->limit(1)->one();
        if (empty($article_author)) {
            return $this->redirect(['/article']);
        }

        $searchModel = new ArticleSearch();
        $searchModel->article_author_id = $article_author->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'slug' => $slug,
            'sub_title' => '<b>Author :</b> ' . ($article_author ? $article_author->author_name : strtoupper($slug)),
        ]);
    }






    public function actionFlag($slug, $article_comment_id)
    {
        $article = Article::find()->where(['slug' => $slug])->one();
        if (!$article) {
            return $this->redirect(['/article']);
        }

        $comments = ArticleComment::find()->where(['id' => $article_comment_id])->limit(1)->one();

        $model = new ArticleCommentReportForm();
        $model->article_id = $article->id;
        $model->article_comment_id = $article_comment_id;

        $model->action_url = '/article/default';
        $model->action_validate_url = '/article/default/validateflag';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->flag_model->save(false)) {
                        $comments->flaged = 1;
                        $comments->save(false);
                        Yii::$app->session->setFlash('success', 'Review Reported Successfully!');
                        return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
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
            $flag_model = $this->findModel($id);
            $model = new ArticleCommentReportForm($flag_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}
