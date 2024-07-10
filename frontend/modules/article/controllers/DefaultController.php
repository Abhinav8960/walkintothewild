<?php

namespace frontend\modules\article\controllers;

use Yii;
use frontend\models\CommentForm;
use common\models\park\SafariPark;
use frontend\models\ArticleSearch;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleAuthor;
use common\models\cms\article\MasterArticleTag;
use frontend\controllers\FrontendBaseController;
use common\models\cms\article\MasterArticleTopic;

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

        $article = Article::find()->where(['status' => Article::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($article)) {
            return $this->redirect(['/article']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new CommentForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($article)) {
            Yii::$app->session->setFlash('success', 'Comment Successfully submitted');
            return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
        }

        return $this->render(
            'view',
            [
                'article' => $article,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
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
}
