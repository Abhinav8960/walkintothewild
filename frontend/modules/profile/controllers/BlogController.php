<?php

namespace frontend\modules\profile\controllers;


use Yii;
use yii\helpers\Url;
use common\models\User;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use common\models\cms\blog\Blog;
use frontend\models\blog\BlogForm;
use common\models\cms\blog\BlogTag;
use common\models\sharesafari\ShareSafari;
use common\models\cms\blog\BlogTopic;
use common\models\cms\blog\BlogAuthor;
use common\models\cms\blog\BlogComment;
use common\models\cms\blog\BlogCommentReport;
use frontend\controllers\FrontendBaseController;
use frontend\models\BlogCommentReportForm;
use frontend\models\BlogReplyForm;
use frontend\models\CommentForm;

/**
 * BlogController.
 */
class BlogController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $model = ShareSafari::find()->where(['host_user_id' => $user->id])->all();
        if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) {
            $blogs = Blog::find()->where(['user_id' => $user->id, 'status' => [Blog::STATUS_ACTIVE, Blog::STATUS_SUSPEND]])->orderby(['id' => SORT_DESC])->all();
        } else {
            $blogs = Blog::find()->where(['user_id' => $user->id, 'status' => Blog::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
        }
        $sharesafrimodel = ShareSafari::find()->where(['host_user_id' => $user->id])->orderby(['id' => SORT_DESC])->limit(2)->all();
        $model_count = ShareSafari::find()->where(['host_user_id' => $user->id])->count();
        return $this->render(
            'index',
            [
                'user' => $user,
                'blogs' => $blogs,
                'model' => $model,
                'sharesafrimodel' => $sharesafrimodel,
                'model_count' => $model_count
            ]
        );
    }

    public function actionCreate()
    {
        $user = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
        $model = new BlogForm();
        $model->action_url = '/profile/blog/create';
        $model->action_validate_url = '/profile/blog/validate';
        // $model->status = Blog::STATUS_ACTIVE;
        $model->user_id = Yii::$app->user->identity->id;
        // $model->user_type = Blog::USER_TYPE_INDIVIDUAL;
        $model->scenario = 'create';
        $model->blog_date = date('Y-m-d');
        // $model->publish_date_time = date('Y-m-d h:i:s');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                // $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                if ($model->validate()) {
                    $model->meta_title = $model->title;
                    $model->initializeForm();
                    if ($model->blog_model->save(false)) {
                        $model->uploadFile();

                        /**
                         * Here is the concept of generating blog_author_id and author_name and first save in Blog Author
                         */
                        // $author = BlogAuthor::find()->where(['user_type' => BlogAuthor::AUTHOR_TYPE_INDIVIDUAL, 'user_id' => Yii::$app->user->identity->id])->limit(1)->one();
                        // if (!$author) {
                        //     $author = new BlogAuthor();
                        // }
                        // $author->user_id = Yii::$app->user->identity->id; // check here which id will user $this->module->user()->id
                        // $author->author_name = Yii::$app->user->identity->name;
                        // $author->status = 1;
                        // if ($author->save()) {
                        //     $model->blog_model->blog_author_id = $author->id;
                        //     $model->blog_model->author_name = $author->author_name;
                        //     $model->blog_model->save(false);
                        // };



                        $blogTopics = $model->blog_topics;
                        if ($blogTopics) {
                            foreach ($blogTopics as $blogT) {
                                $blogTopic = new BlogTopic();
                                $blogTopic->blog_id = $model->blog_model->id;
                                $blogTopic->master_topic_id = $blogT;
                                $blogTopic->save(false);
                            }
                        }

                        $blogTags = $model->blog_tags;
                        if ($blogTags) {
                            foreach ($blogTags as $blogT) {
                                $blogTag = new BlogTag();
                                $blogTag->blog_id = $model->blog_model->id;
                                $blogTag->master_tag_id = $blogT;
                                $blogTag->save(false);
                            }
                        }
                        \Yii::$app->session->setFlash('success', 'Blog Created Successfully');
                        return $this->redirect(['/profile/blog/index', 'user_handle' => $user->user_handle]);
                    }
                }
            }
        } else {
            $model->blog_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionValidate($slug = null)
    {
        $model = new BlogForm();
        if ($slug != null) {
            $formmodel = $this->findModel($slug);
            $model = new BlogForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $slug ID
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Blog::findOne(['slug' => $slug, 'user_id' => Yii::$app->user->identity->id, 'status' => [Blog::STATUS_ACTIVE, Blog::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Blog Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $blog_model = $this->findModel($slug);
        $user = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
        $model = new BlogForm($blog_model);
        $model->action_url = Url::toRoute(['/profile/blog/update', 'slug' => $slug]);
        $model->action_validate_url = Url::toRoute(['/profile/blog/validate', 'slug' => $slug]);
        $model->is_approved = 0;
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                if ($model->validate()) {
                    $model->meta_title = $model->title;
                    $model->initializeForm();
                    // Inactive if Anything is changed into form
                    if ($model->blog_model->save(false)) {
                        $model->uploadFile();

                        $blogTopics = $model->blog_topics;
                        if ($blogTopics) {
                            BlogTopic::deleteAll(['blog_id' => $blog_model->id]);
                            foreach ($blogTopics as $blogT) {
                                $blogTopic = new BlogTopic();
                                $blogTopic->blog_id = $model->blog_model->id;
                                $blogTopic->master_topic_id = $blogT;
                                $blogTopic->save(false);
                            }
                        }

                        $blogTags = $model->blog_tags;
                        if ($blogTags) {
                            BlogTag::deleteAll(['blog_id' => $blog_model->id]);
                            foreach ($blogTags as $blogT) {
                                $blogTag = new BlogTag();
                                $blogTag->blog_id = $model->blog_model->id;
                                $blogTag->master_tag_id = $blogT;
                                $blogTag->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Blog Updated Successfully');
                        return $this->redirect(['/profile/blog/index', 'user_handle' => $user->user_handle]);
                    }
                }
            }
        } else {
            $model->blog_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug, $user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $blog = Blog::findOne(['slug' => $slug,  'user_id' => $user->id]);
        if (empty($blog)) {
            return $this->redirect(['/profile/blog/index', 'user_handle' => $user_handle]);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new CommentForm();
        $model->action_validate_url = '/profile/blog/validate-comment';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->comment($blog)) {
                    Yii::$app->session->setFlash('success', 'Comment submitted Successfully');
                    return $this->redirect(['/profile/blog/view',  'slug' => $slug, 'user_handle' => $user->user_handle]);
                }
            }
        }

        return $this->render(
            'view',
            [
                'blog' => $blog,
                'user' => $user,
                'model' => $model,
            ]
        );
    }

    public function actionReply($slug, $user_handle, $parent_id)
    {

        $blog = Blog::findOne(['slug' => $slug,'status' => Blog::STATUS_ACTIVE]);
        if (empty($blog)) {
            return $this->redirect(['/profile/blog/index', 'user_handle' => $user_handle]);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $replymodel = new BlogReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->action_validate_url = '/profile/blog/validate-reply';


        if ($replymodel->load(Yii::$app->request->post())) {
            if ($replymodel->validate()) {
                if ($replymodel->reply($blog)) {
                    Yii::$app->session->setFlash('success', 'Reply successfully submitted');
                    return $this->redirect(['/profile/blog/view',  'slug' => $slug, 'user_handle' => $user_handle]);
                }
            }
        }

        return $this->renderAjax('_reply_form', ['replymodel' => $replymodel]);
    }

    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidateComment($id = null)
    {
        $commentmodel = new CommentForm();
        if ($id != null) {
            $formmodel = $this->findReplyModel($id);
            $commentmodel = new CommentForm($formmodel);
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
        $replymodel = new BlogReplyForm();
        if ($id != null) {
            $formmodel = $this->findReplyModel($id);
            $replymodel = new BlogReplyForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $replymodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($replymodel);
        }
    }

    protected function findReplyModel($id)
    {
        if (($model = BlogComment::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFlag($slug, $blog_comment_id, $user_handle)
    {
        $blog = Blog::findOne(['slug' => $slug,'status' => Blog::STATUS_ACTIVE]);
        if (empty($blog)) {
            return $this->redirect(['/profile/blog/index', 'user_handle' => $user_handle]);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $comments = BlogComment::find()->where(['id' => $blog_comment_id, 'status' => 1])->limit(1)->one();

        $model = new BlogCommentReportForm();
        $model->blog_id = $blog->id;
        $model->blog_comment_id = $blog_comment_id;

        // $model->action_url = '/blog/default';
        $model->action_validate_url = '/profile/blog/validateflag';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->flag_model->save(false)) {
                        $comments->flaged = 1;
                        $comments->save(false);
                        Yii::$app->session->setFlash('success', 'Review Reported Successfully!');
                        return $this->redirect(['/profile/blog/view',  'slug' => $slug, 'user_handle' => $user_handle]);
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
        $model = new BlogCommentReportForm();
        if ($id != null) {
            $flag_model = $this->findflagModel($id);
            $model = new BlogCommentReportForm($flag_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    protected function findflagModel($id)
    {
        if (($model = BlogCommentReport::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
