<?php

namespace frontend\modules\article\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\park\SafariPark;
use common\models\RenderedContent;
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
    public function init()
    {
        parent::init();
        Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
            // Save rendered content and other details to the database
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $renderedContent = new RenderedContent();
                $renderedContent->created_at = date('Y-m-d H:i:s');
                $renderedContent->url = Yii::$app->request->absoluteUrl;
                $renderedContent->title = Yii::$app->view->title;
                $renderedContent->action_url = Yii::$app->request->url;

                // Save query parameters to a separate column
                $queryParams = Yii::$app->request->getQueryParams();
                $renderedContent->query_params = json_encode($queryParams); // Save query parameters as JSON

                // Add device info and IP address
                $renderedContent->user_agent = Yii::$app->request->userAgent;
                $renderedContent->ip_address = Yii::$app->request->userIP;

                if ($renderedContent->save()) {
                    $transaction->commit();
                } else {
                    Yii::error('Failed to save rendered content: ' . json_encode($renderedContent->errors));
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                Yii::error('Exception occurred while saving rendered content: ' . $e->getMessage());
                $transaction->rollBack();
            }
        });
    }

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
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($article)) {
            Yii::$app->session->setFlash('success', 'Comment Successfully submitted');
            return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
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
            ]
        );
    }
}
