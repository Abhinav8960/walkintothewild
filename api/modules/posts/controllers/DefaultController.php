<?php

namespace api\modules\posts\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\posts\UserPostComment;
use api\models\posts\UserPostCommentLike;
use api\models\posts\UserPostLike;
use api\models\posts\UserPosts;
use api\models\posts\UserPostSearch;
use common\models\PostReportForm;
use common\models\postscomment\form\UserPostCommentFlagForm;
use common\models\postscomment\form\UserPostCommentForm;
use common\models\postscomment\form\UserPostReplyForm;
use frontend\models\profile\UserPostsImageForm;
use getID3;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class DefaultController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors += [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['index', 'view', 'posts-images', 'comment-view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'comment', 'reply', 'comment-like', 'user-post-like', 'user-post-report', 'post-delete', 'post-edit', 'flag'],
                'rules' => [
                    [
                        'actions' => ['create', 'comment', 'reply', 'comment-like', 'user-post-like', 'user-post-report', 'flag'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['post-delete', 'post-edit'],
                        'allow' => $this->isOwner(),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'user-posts' => ['GET'],
                    'create' => ['POST'],
                    'comment' => ['POST'],
                    'reply' => ['POST'],
                    'user-post-like' => ['POST'],
                    'comment-like' => ['POST'],
                    'user-post-report' => ['POST'],
                    'post-delete' => ['POST'],
                    'post-edit' => ['POST'],
                    'flag' => ['POST'],
                    'comment-view' => ['GET'],

                ],
            ],
        ];
    }

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserPostSearch();
        $searchModel->status = UserPostSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts");
    }

    public function actionCreate()
    {
        $model = new UserPostsImageForm();
        $model->user_id = $this->userinfoId;
        $model->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
        $model->status = UserPosts::STATUS_ACTIVE;

        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());

        $model->file = \yii\web\UploadedFile::getInstanceByName('file');
        $model->version = 1;


        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_image_model->save()) {
                $model->uploadFile();

                if ($model->file) {
                    list($width, $height) = getimagesize($model->file->tempName);
                    $model->user_image_model->height = $height;
                    $model->user_image_model->width = $width;
                    $model->user_image_model->size = $model->file->size;
                }

                if ($model->user_image_model->save()) {
                    $model->user_image_model->savehistory();
                    $message = Yii::$app->api->messageManager->getMessage('post.create_post.post_added');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
            }
            $message = Yii::$app->api->messageManager->getMessage('post.create_post.post_not_added');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    /**
     *
     * @return string
     */
    public function actionView($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $searchModel = new UserPostSearch();
        $searchModel->id = $userpost->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts", $additionalSearchQueryParams = [], $singleRecord = true);
    }


    public function actionComment($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new UserPostCommentForm();
        $model->attributes = $this->request;
        $model->version = $userpost->version;
        if ($model->validate() && $model->comment($userpost)) {
            $message = Yii::$app->api->messageManager->getMessage('common.comment_success');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.comment_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    public function actionPostDelete($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo) {
            if ($this->userinfoId != $userpost->user_id) {
                $message = Yii::$app->api->messageManager->getMessage('common.delete_restricted',['{var}'=>'Post']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }

        $userpost->status = UserPosts::STATUS_DELETE;
        if ($userpost->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.deleted');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.delete_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }


    public function actionReply($id, $parent_id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $replymodel = new UserPostReplyForm();
        $replymodel->parent_id = $parent_id;

        $replymodel->attributes = $this->request;
        $replymodel->version = $userpost->version;

        if ($replymodel->validate()) {
            if ($replymodel->reply($userpost)) {
                $message = Yii::$app->api->messageManager->getMessage('common.reply_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        $message = Yii::$app->api->messageManager->getMessage('common.reply_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
    }


    public function actionCommentLike($user_post_comment_id)
    {

        $like = UserPostCommentLike::find()->where(['user_id' => $this->userinfoId, 'user_post_comment_id' => $user_post_comment_id, 'status' => UserPostCommentLike::STATUS_ACTIVE])->one();
        if (!$like) {
            $like = new UserPostCommentLike();
            $like->user_id = $this->userinfoId;
            $like->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
            $like->user_post_comment_id = $user_post_comment_id;
            $like->status = UserPostCommentLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.like_success',['{var}'=> 'Comment or Reply']);
                return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => true], ['message' => $message]);
            }
        } else {
            $like->delete();
            $message = Yii::$app->api->messageManager->getMessage('common.like_removed');
            return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => false], ['message' => $message]);
        }
    }


    public function actionUserPostLike($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $like = UserPostLike::find()->where(['user_id' => $this->userinfoId, 'user_post_id' => $id, 'status' => UserPostLike::STATUS_ACTIVE])->one();
        if (!$like) {
            $like = new UserPostLike();
            $like->user_id = $this->userinfoId;
            $like->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
            $like->user_post_id = $id;
            $like->version = $userpost->version;
            $like->status = UserPostLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.like_success',['{var}'=> 'Post']);
                return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => true], ['message' => $message]);
            }
        } else {
            $like->delete();
            $message = Yii::$app->api->messageManager->getMessage('common.like_removed');
            return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => false], ['message' => $message]);
        }
    }

    public function actionUserPostReport($id)
    {
        $post = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$post) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new PostReportForm();
        $model->user_id = $this->userinfoId;
        $model->status = UserPosts::STATUS_ACTIVE;
        $model->post_id = $post->id;
        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        if ($model->validate()) {
            $model->initializeForm();

            if ($model->post_model->save()) {
                $message = Yii::$app->api->messageManager->getMessage('common.report_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.not_submitted');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionPostEdit($id)
    {
        $user_image_model = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$user_image_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($this->userinfo) {
            if ($this->userinfoId != $user_image_model->user_id) {
                $message = Yii::$app->api->messageManager->getMessage('post.edit_post.edit_restricted');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }

        $model = new UserPostsImageForm($user_image_model);
        $model->attributes = $this->request;
        $model->file = \yii\web\UploadedFile::getInstanceByName('file');
        $model->version = $user_image_model->version + 1;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_image_model->save()) {
                $model->uploadFile();

                if ($model->file) {
                    list($width, $height) = getimagesize($model->file->tempName);
                    $model->user_image_model->height = $height;
                    $model->user_image_model->width = $width;
                    $model->user_image_model->size = $model->file->size;
                }

                if ($model->user_image_model->save()) {
                    $model->user_image_model->savehistory();
                    $message = Yii::$app->api->messageManager->getMessage('post.edit_post.edit_success');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
            }
            $message = Yii::$app->api->messageManager->getMessage('post.edit_post.edit_failed');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionFlag($id, $user_post_comment_id)
    {
        $user_post_model = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$user_post_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $flag_comment = UserPostComment::find()->where(['id' => $user_post_comment_id])->limit(1)->one();

        if (!$flag_comment) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Comment']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($flag_comment->user_id == $this->userinfoId) {
            $message = Yii::$app->api->messageManager->getMessage('common.flag_restricted');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new UserPostCommentFlagForm();
        $model->user_posts_id = $user_post_model->id;
        $model->user_post_comment_id = $flag_comment->id;

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_post_flag_model->save(false)) {
                $flag_comment->flaged = 1;
                $flag_comment->save(false);
                $message = Yii::$app->api->messageManager->getMessage('common.flag_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionCommentView($id)
    {
        $user_post_model = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$user_post_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=> 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => UserPostComment::find()->where(['user_posts_id' => $user_post_model->id, 'status' => 1, 'parent_id' => null]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "comments");
    }

    private function isOwner()
    {
        if ($this->userinfo) {
            $owner = UserPosts::find()->where(['user_id' => $this->userinfoId, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
            if ($owner) {
                return true;
            }
            return false;
        }
        return false;
    }
}
