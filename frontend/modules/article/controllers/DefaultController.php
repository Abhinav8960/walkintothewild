<?php

namespace frontend\modules\article\controllers;


use Yii;
use frontend\models\ArticleSearch;
use yii\web\NotFoundHttpException;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use common\models\cms\article\MasterArticleAuthor;
use frontend\controllers\FrontendBaseController;
use common\models\cms\mastercategory\MasterTopic;
use common\models\cms\mastertag\MasterTag;
use common\models\GeneralModel;
use common\models\MailLog;
use frontend\models\ArticleCommentForm;
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
        $article = Article::find()->where(['status' => Article::STATUS_ACTIVE, 'slug' => $slug])
            ->limit(1)->one();

        if (empty($article)) {
            return $this->redirect(['/article']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new ArticleCommentForm();
        $model->action_validate_url = '/article/default/validate-comment';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($article)) {
            Yii::$app->session->setFlash('success', 'Comment submitted Successfully');
            return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
        }

        return $this->render(
            'view',
            [
                'article' => $article,
                'model' => $model,
            ]
        );
    }


    public function actionReply($slug, $parent_id)
    {

        $article = Article::find()->where(['status' => Article::STATUS_ACTIVE, 'slug' => $slug])
            ->limit(1)->one();


        if (empty($article)) {
            return $this->redirect(['/article']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $replymodel = new ArticleReplyForm();
        $replymodel->parent_id = $parent_id;

        $replymodel->action_validate_url = '/article/default/validate-reply';


        if ($replymodel->load(Yii::$app->request->post())) {
            if ($replymodel->validate()) {
                if ($replymodel->reply($article)) {
                    Yii::$app->session->setFlash('success', 'Reply successfully submitted');
                    return $this->redirect(['/article/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
                }
            }
        }

        return $this->renderAjax('_reply_form', ['replymodel' => $replymodel]);
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

        $article_topic = MasterTopic::find()->where(['slug' => $slug])->one();
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

        $article_tag = MasterTag::find()->where(['slug' => $slug])->one();

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
        $article_author = MasterArticleAuthor::find()->where(['slug' => $slug])->limit(1)->one();
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
            'sub_title' => '<b>Author :</b> ' . ($article_author ? $article_author->name : strtoupper($slug)),
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

                        //Flag mail
                        $to_mail = Yii::$app->params['adminEmail'];
                        $subject = 'Flag Raised | Article : ' . substr($article->title, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                        $req = ['comment' => $comments->comment, 'report_details' => $model->flag_model->report_detail, 'username' => isset(Yii::$app->user->identity) ? Yii::$app->user->identity->name : ''];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }


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

    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidateComment($id = null)
    {
        $commentmodel = new ArticleCommentForm();
        if ($id != null) {
            $formmodel = $this->findReplyModel($id);
            $commentmodel = new ArticleCommentForm($formmodel);
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
        if (($model = ArticleComment::findOne(['id' => $id, 'status' => ArticleComment::STATUS_ACTIVE])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
