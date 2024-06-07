<?php

namespace frontend\modules\article\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\park\SafariPark;
use frontend\models\ArticleSearch;
use frontend\models\CommentForm;
use frontend\models\ReplyForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
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
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $article = Article::find()->where(['status' => Article::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();


        $model = new CommentForm();
        $replymodel = new ReplyForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($article)) {
            Yii::$app->session->setFlash('success', 'Comment Successfully submitted');
            return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'comment-wrapper']);
        }

        if ($replymodel->load(Yii::$app->request->post()) && $replymodel->validate() && $replymodel->reply($article)) {
            Yii::$app->session->setFlash('success', 'Reply Successfully submitted');
            return $this->redirect(['/article/default/view', 'slug' => $slug, '#' => 'comment-wrapper']);
        }

        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        if (empty($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render(
            'view',
            [
                'article' => $article,
                'featured_parks' => $featured_parks,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'replymodel' => $replymodel,
            ]
        );
    }
}
