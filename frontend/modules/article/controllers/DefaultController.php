<?php

namespace frontend\modules\article\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use common\models\park\SafariPark;
use frontend\models\CommentForm;
use frontend\models\ArticleSearch;
use frontend\controllers\FrontendBaseController;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{
    /**
     * Actions ids for Save Page Views
     */
    public $action_ids = ['index', 'view', 'topic', 'tag'];

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
        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        return $this->render('index', [
            'featured_parks' => $featured_parks,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
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
        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        return $this->render('index', [
            'featured_parks' => $featured_parks,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
        ]);
    }
}
