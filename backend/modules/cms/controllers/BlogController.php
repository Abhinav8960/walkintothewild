<?php

namespace backend\modules\cms\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\blog\Blog;
use common\models\cms\blog\BlogComment;
use common\models\cms\blog\BlogCommentReport;
use common\models\cms\blog\BlogCommentSearch;
use common\models\cms\blog\BlogSearch;
use common\models\cms\blog\BlogTag;
use common\models\cms\blog\BlogTopic;
use common\models\cms\blog\form\BlogCommentActionForm;
use common\models\cms\blog\form\BlogDeleteForm;
use common\models\cms\blog\form\BlogForm;
use common\models\cms\blog\MasterBlogTag;
use common\models\pendingapproval\form\UserBlogApprovalForm;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * Blog Controller for the `blog` module
 */
class BlogController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $searchModel->status = Blog::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);
        // $dataProvider->query->andWhere("user_type=3");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Blog Author
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogForm();
        $model->action_url = '/cms/blog/create';
        $model->action_validate_url = '/cms/blog/validate';
        $model->user_type = Blog::USER_TYPE_ADMIN;
        $model->status = Blog::STATUS_ACTIVE;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->blog_model->save(false)) {
                        $model->uploadFile();

                        $blogTopics = $model->blog_topics;
                        if ($blogTopics) {
                            foreach ($blogTopics as $blogT) {
                                $blogTopic = new BlogTopic();
                                $blogTopic->blog_id = $model->blog_model->id;
                                $blogTopic->master_blog_topic_id = $blogT;
                                $blogTopic->save(false);
                            }
                        }

                        $blogTags = $model->blog_tags;
                        if ($blogTags) {
                            foreach ($blogTags as $blogT) {
                                $blogTag = new BlogTag();
                                $blogTag->blog_id = $model->blog_model->id;
                                $blogTag->master_blog_tag_id = $blogT;
                                $blogTag->save(false);
                            }
                        }
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/cms/blog/index']);
                    }
                }
            }
        } else {
            $model->blog_model->loadDefaultValues();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Blog Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $blog_model = $this->findModel($id);
        $model = new BlogForm($blog_model);
        $model->action_url = '/cms/blog/update?id=' . $id;
        $model->action_validate_url = '/cms/blog/validate?id=' . $id;

        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->blog_model->save(false)) {
                        $model->uploadFile();

                        $blogTopics = $model->blog_topics;
                        if ($blogTopics) {
                            BlogTopic::deleteAll(['blog_id' => $id]);
                            foreach ($blogTopics as $blogT) {
                                $blogTopic = new BlogTopic();
                                $blogTopic->blog_id = $model->blog_model->id;
                                $blogTopic->master_blog_topic_id = $blogT;
                                $blogTopic->save(false);
                            }
                        }

                        $blogTags = $model->blog_tags;
                        if ($blogTags) {
                            BlogTag::deleteAll(['blog_id' => $id]);
                            foreach ($blogTags as $blogT) {
                                $blogTag = new BlogTag();
                                $blogTag->blog_id = $model->blog_model->id;
                                $blogTag->master_blog_tag_id = $blogT;
                                $blogTag->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/cms/blog/index']);
                    }
                }
            }
        } else {
            $model->blog_model->loadDefaultValues();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionAddTag()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tags = Yii::$app->request->post('tags');

        if (is_array($tags)) {
            // Handle the case where 'tags' is an array (e.g., if multiple tags are submitted)
            $tagsArray = $tags;
        } elseif (is_string($tags)) {
            // Handle the case where 'tags' is a string (e.g., if only one tag is submitted)
            $tagsArray = explode(',', $tags);
        } else {
            // Handle any other unexpected cases
            return ['success' => false, 'message' => 'Invalid tags format'];
        }

        if (!empty($tagsArray)) {
            $existingTags = MasterBlogTag::find()->select('title')->column();

            foreach ($tagsArray as $tag) {
                $tag = trim($tag);
                if (!in_array($tag, $existingTags)) {
                    $newTag = new MasterBlogTag();
                    $newTag->title = $tag;
                    $newTag->slug = $tag;
                    $newTag->status = MasterBlogTag::STATUS_ACTIVE;
                    if (!$newTag->save(false)) {
                        return ['success' => false, 'message' => 'Failed to save tag: ' . $newTag->title];
                    }
                }
            }
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'No tags provided'];
    }



    /**
     * Validate Form
     */
    public function actionValidate($id = null)
    {
        $model = new BlogForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new BlogForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $blogTopics = BlogTopic::findAll(['blog_id' => $model->id]);
        if (!empty($blogTopics)) {
            foreach ($blogTopics as $blogTopic) {
                $blogTopic->status = BlogTopic::STATUS_DELETE;
                $blogTopic->save();
            }
        }

        $model->title = $model->id . '_' . $model->title;
        $model->slug = $model->id . '_' . $model->slug;
        $model->status = Blog::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(Yii::$app->request->referrer);
    }








    public function actionComment($id)
    {
        $blog = Blog::find()->where(['id' => $id])->limit(1)->one();

        $searchModel = new BlogCommentSearch();
        $searchModel->blog_id = $blog->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => null]);

        return $this->render(
            'comment',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'blog' => $blog,
            ]
        );
    }


    public function actionApproved($id)
    {
        $model = BlogComment::find()->where(['id' => $id])->one();
        $model->status = 1;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Approved Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDisapproved($id)
    {
        $model = BlogComment::find()->where(['id' => $id])->one();
        $model->status = 2;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Disapproved Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }




    public function actionEdit($id)
    {
        $comment_action_model = BlogCommentReport::find()->where(['id' => $id])->limit(1)->one();
        $model = new BlogCommentActionForm($comment_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->comment_action_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Action Taken Successfully');
                        return $this->redirect(\Yii::$app->request->referrer);
                    }
                }
            }
        } else {
            $model->comment_action_model->loadDefaultValues();
        }
        return $this->renderAjax('edit', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {

        $dataProvider = new ActiveDataProvider([
            'query' =>  BlogCommentReport::find()->where(['blog_comment_id' => $id, 'status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('view', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne(['id' => $id, 'status' => [Blog::STATUS_ACTIVE, Blog::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // public function actionBlogdelete($id)
    // {
    //     $model = $this->findModel($id);
    //     $model->status = Blog::STATUS_DELETE;
    //     $model->save();
    //     \Yii::$app->session->setFlash('success', 'Deleted Successfully');
    //     return $this->redirect(['index']);
    // }

    public function actionBlogdelete($id)
    {
        $delete_blog_model = $this->findModel($id);
        $model = new BlogDeleteForm($delete_blog_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->delete_blog_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Update');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->delete_blog_model->loadDefaultValues();
        }
        return $this->renderAjax('delete_form', [
            'approval_model' => $model,
        ]);
    }


    // public function actionApproval($id)
    // {
    //     $user_blog_approval_model = $this->findModel($id);
    //     $model = new UserBlogApprovalForm($user_blog_approval_model);
    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->user_blog_approval_model->save(false)) {
    //                     \Yii::$app->session->setFlash('success', 'Successfully Update');
    //                     return $this->redirect(['index']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->user_blog_approval_model->loadDefaultValues();
    //     }
    //     return $this->renderAjax('approval_form', [
    //         'approval_model' => $model,
    //     ]);
    // }


    public function actionReplyview($id)
    {
        $review = BlogComment::find()->where(['parent_id' => $id]);
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  $review,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('_replyview', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFlagview($id)
    {
        $review = BlogCommentReport::find()->where(['blog_comment_id' => $id]);
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  $review,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('_flagview', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
