<?php

namespace backend\modules\flag\controllers;


use common\models\cms\blog\BlogCommentReport;
use common\models\cms\blog\BlogCommentSearch;
use common\models\cms\blog\form\BlogCommentActionForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\blog\BlogComment;
use common\models\sharesafari\form\FlagActionForm;

class BlogController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BlogCommentSearch();
        $searchModel->flaged = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
                        if ($model->comment_action_model->status == -1) {
                            if ($blog_comment = $comment_action_model->comment) {
                                $blog_comment->is_deleted = 1;
                                if ($blog_comment->save()) {
                                    BlogCommentReport::updateAll(['status' => 3], ['blog_comment_id' => $blog_comment->id, 'status' => 1]);
                                    \Yii::$app->session->setFlash('success', 'Action Taken Successfully');
                                    return $this->redirect(['index']);
                                }
                            }
                        }
                        return $this->redirect(Yii::$app->request->referrer);
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
        $review = BlogComment::find()->where(['id' => $id])->one();
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  BlogCommentReport::find()->where(['blog_comment_id' => $id, 'status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'review' => $review,
        ]);
    }

    public function actionFlagview($id)
    {
        $review = BlogComment::find()->where(['id' => $id])->one();
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }

        if ($this->request->isPost && isset($_POST['flag_action'])) {
            $post_data = $_POST['flag_action'];
            $is_comment_mark_as_delete = 'mark_as_not_delete';
            foreach ($post_data as $key => $new_status) {
                $flag = BlogCommentReport::findOne($key);
                $flag->status = $new_status;
                if ($flag->save(false)) {
                    if ($new_status == 2 && $is_comment_mark_as_delete = 'mark_as_not_delete') {
                        $comment = BlogComment::findOne($flag->blog_comment_id);
                        $comment->status = $new_status;
                        if ($comment->save()) {
                            $is_comment_mark_as_delete = 'mark_as_delete';
                        }
                    }
                }
            }
            \Yii::$app->session->setFlash('success', 'Action Taken Successfully');
        }

        //form model
        $model = new FlagActionForm();

        $review_flags = BlogCommentReport::find()->where(['blog_comment_id' => $id])->orderBy('id DESC')->all();

        return $this->render('flagview', [
            'review' => $review,
            'model' => $model,
            'review_flags' => $review_flags
        ]);
    }
}
