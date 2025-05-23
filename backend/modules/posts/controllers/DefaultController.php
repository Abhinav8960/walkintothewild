<?php

namespace backend\modules\posts\controllers;

use common\models\postscomment\form\UserPostDeleteForm;
use common\models\postscomment\UserPostComment;
use common\models\UserPosts;
use common\models\UserPostSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController for the `posts` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new UserPostSearch();
        $searchModel->status = UserPosts::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id])->limit(1)->one();
        if (!$userpost) {
            \Yii::$app->session->setFlash('danger', 'Post not Found!!!');
            return $this->redirect(['index']);
        }
        return $this->render('view', [
            'model' => $userpost,
        ]);
    }

    public function actionCommentListing($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id])->limit(1)->one();
        if (!$userpost) {
            \Yii::$app->session->setFlash('danger', 'Post not Found!!!');
            return $this->redirect(['index']);
        }

        $query = UserPostComment::find()->where(['user_posts_id' => $userpost->id, 'status' => 1])->andWhere(['parent_id' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_comment_list', ['dataProvider' => $dataProvider]);
    }

    public function actionReplyListing($parent_id)
    {
        $query = UserPostComment::find()->where(['parent_id' => $parent_id, 'status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_reply_list', ['dataProvider' => $dataProvider]);
    }

    public function actionPostDelete($id)
    {
        $user_posts_model = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$user_posts_model) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Post Not Found!!!"]);
        }

        $model = new UserPostDeleteForm($user_posts_model);
        $model->status = UserPosts::STATUS_DELETE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_posts_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_posts_model->loadDefaultValues();
        }

        return $this->renderAjax('_delete_form', [
            'model' => $model,
        ]);
    }



    public function actionCommentDelete($id)
    {
        $comment = UserPostComment::find()->where(['id' => $id, 'status' => 1])->limit(1)->one();

        if (!$comment) {
            Yii::$app->session->setFlash('error', 'Comment not found');
            return $this->redirect(['index']);
        }

        $replies = UserPostComment::find()->where(['parent_id' => $id, 'status' => 1])->all();
        $comment->status = UserPostComment::STATUS_DELETE;

        if ($comment->save(false)) {
            if ($replies) {
                foreach ($replies as $rep) {
                    $rep->status = UserPostComment::STATUS_DELETE;
                    $rep->save(false);
                }
            }
            Yii::$app->session->setFlash('success', 'Comment and Replies related to it has been deleted successfully.');
            return $this->redirect(['view', 'id' => $comment->user_posts_id]);
        }

        Yii::$app->session->setFlash('danger', 'Not deleted successfully.');
        return $this->redirect(['index']);
    }

    public function actionReplyDelete($id)
    {
        $reply = UserPostComment::find()->where(['id' => $id, 'status' => 1])->limit(1)->one();
        if (!$reply) {
            Yii::$app->session->setFlash('error', 'Reply not found');
            return $this->redirect(['index']);
        }
        $reply->status = UserPostComment::STATUS_DELETE;

        if ($reply->save(false)) {
            Yii::$app->session->setFlash('success', 'Reply has been deleted successfully.');
            return $this->redirect(['view', 'id' => $reply->user_posts_id]);
        }

        Yii::$app->session->setFlash('danger', 'Not deleted successfully.');
        return $this->redirect(['index']);
    }

    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        $model->status = UserPosts::STATUS_SUSPEND;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = UserPosts::STATUS_ACTIVE;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = UserPosts::findOne(['id' => $id, 'status' => [UserPosts::STATUS_ACTIVE, UserPosts::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
