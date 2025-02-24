<?php

namespace api\modules\posts\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\posts\UserPostCommentLike;
use api\models\posts\UserPosts;
use api\models\posts\UserPostSearch;
use common\models\postscomment\form\UserPostCommentForm;
use common\models\postscomment\form\UserPostReplyForm;
use frontend\models\profile\UserPostsForm;
use frontend\models\profile\UserPostsVideoForm;
use getID3;
use Yii;
use yii\filters\AccessControl;

class DefaultController extends RestController
{

    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {

    //   return  $behaviors = parent::behaviors();

    //     // return $behaviors += [
    //     //     'apiauth' => [
    //     //         'class' => Apiauth::className(),
    //     //         'exclude' => ['index', 'view'],
    //     //     ],
    //     //     'access' => [
    //     //         'class' => AccessControl::className(),
    //     //         'only' => ['create', 'comment', 'reply', 'like'],
    //     //         'rules' => [
    //     //             [
    //     //                 'actions' => ['create', 'comment', 'reply', 'like'],
    //     //                 'allow' => true,
    //     //                 'roles' => ['@'],
    //     //             ],

    //     //         ],
    //     //     ],
    //     //     'verbs' => [
    //     //         'class' => Verbcheck::className(),
    //     //         'actions' => [
    //     //             'index' => ['GET'],
    //     //             'view' => ['GET'],
    //     //             'user-posts' => ['GET'],
    //     //             'create' => ['POST'],
    //     //             'comment' => ['POST'],
    //     //             'reply' => ['POST'],
    //     //         ],
    //     //     ],
    //     // ];
    // }

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
        $model = new UserPostsVideoForm();
        $model->user_id = $this->userinfoId;
        $model->status = UserPosts::STATUS_ACTIVE;

        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        $model->file = \yii\web\UploadedFile::getInstanceByName('file');
        $model->v_size = $model->file->size;
        $model->v_duration = $this->getVideoDuration($model->file);

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_photo_model->save()) {
                $model->uploadFile();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Post added successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not added successfully"]);
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
            return Yii::$app->api->sendResponse($data = [], ['message' => "Post Not Found!!!"]);
        }
        $searchModel = new UserPostSearch();
        $searchModel->id = $userpost->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts", $additionalSearchQueryParams = [], $singleRecord = true);
    }


    public function actionComment($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Post Not Found!!!"]);
        }

        $model = new UserPostCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($userpost)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
        }

        return Yii::$app->api->sendFailedStringResponse($userpost->firstErrors, 400);
    }


    public function actionReply($id, $parent_id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Post Not Found!!!"]);
        }

        $replymodel = new UserPostReplyForm();
        $replymodel->parent_id = $parent_id;

        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($userpost)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }

        return Yii::$app->api->sendFailedStringResponse($userpost->firstErrors, 400);
    }


    public function actionLike($user_post_comment_id)
    {

        $like = UserPostCommentLike::find()->where(['user_id' => $this->userinfoId, 'user_post_comment_id' => $user_post_comment_id, 'status' => UserPostCommentLike::STATUS_ACTIVE])->one();
        if (!$like) {
            $like = new UserPostCommentLike();
            $like->user_id = $this->userinfoId;
            $like->user_post_comment_id = $user_post_comment_id;
            $like->status = UserPostCommentLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Liked Comment or Reply"]);
            }
        } else {
            $like->delete();
            return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Remove Liked Successfully"]);
        }
    }

    /**
     * 
     * @return string
     */
    public function actionUserPosts($user_id)
    {
        $searchModel = new UserPostSearch();
        $searchModel->user_id = $user_id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts");
    }


    private function getVideoDuration($tempFile)
    {
        $tempFilePath = $tempFile->tempName;
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($tempFilePath);
        if (isset($fileInfo['playtime_seconds'])) {
            return (int) $fileInfo['playtime_seconds'];
        }
        return 0;
    }
}