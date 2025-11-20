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
use api\models\User;
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

    /**
     * Post Image
     *
     * Allows users to post image.
     *
     * @OA\Post(
     *     path="/posts/create",
     *     tags={"User Post"},
     *     summary="Post Image",
     *     description="Allows users to post image.",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"caption","file"},
     *                 @OA\Property(
     *                     property="caption",
     *                     type="string",
     *                     description="Enter Caption",
     *                     example=""
     *                 ),
     *                  @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="Upload Post",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post added successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post added successfully!"
     *             )
     *         )
     *     ),
     *    @OA\Response(
     *     response=400,
     *     description="Validation errors occurred.",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="message",
     *             type="string",
     *             example="Caption cannot be blank., File cannot be blank."
     *         )
     *     )
     *   ),
     * )
     */
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
                    $active_followers = $model->user_image_model->user->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->asArray()->all();
                    if (!empty($active_followers)) {
                        new \common\events\post\PostCreatedByUser($active_followers, $model->user_image_model->user->name);
                    }
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
     * Get Post View
     *
     *
     * @OA\Get(
     *     path="/posts/view",
     *     tags={"User Post"},
     *     summary="Get Post View",
     *     description="Get Single Post View",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="id to query single post",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Single Post fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="summary",
     *                type="object",
     *                @OA\Property(
     *                property="query_params",
     *                type="object",
     *                @OA\Property(property="id", type="string", example="651")
     *               )
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PostDetailSchema"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Post Not found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionView($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $searchModel = new UserPostSearch();
        $searchModel->id = $userpost->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts", $additionalSearchQueryParams = [], $singleRecord = true);
    }

    /**
     * Post Comment 
     *
     * Allows users to comment on post.
     *
     * @OA\Post(
     *     path="/posts/comment",
     *     tags={"User Post"},
     *     summary="Comment on Post",
     *     description="Allows users to comment on Post.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"comment"},
     *                 @OA\Property(
     *                     property="comment",
     *                     type="string",
     *                     description="Enter Comment",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *
     *      @OA\Response(
     *         response=200,
     *         description="Comment submitted successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment submitted successfully!"
     *             )
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Post Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not Found!"
     *             )
     *         )
     *     )
     * )
     */

    public function actionComment($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
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

    /**
     * Post Delete 
     *
     * Allows users to Delete Post.
     *
     * @OA\Post(
     *     path="/posts/post-delete",
     *     tags={"User Post"},
     *     summary="Delete Post",
     *     description="Allows users to Delete Post.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post",
     *         @OA\Schema(type="integer")
     *     ),
     *       @OA\Response(
     *         response=200,
     *         description="Post Delete successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Delete successfully!"
     *             )
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Post Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionPostDelete($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo) {
            if ($this->userinfoId != $userpost->user_id) {
                $message = Yii::$app->api->messageManager->getMessage('common.delete_restricted', ['{var}' => 'Post']);
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

    /**
     * Post Reply 
     *
     * Allows users to reply on comment in Post.
     *
     * @OA\Post(
     *     path="/posts/reply",
     *     tags={"User Post"},
     *     summary="Reply on comment in post",
     *     description="Allows users to reply on comment in Post",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="parent_id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post Comment",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"comment"},
     *                 @OA\Property(
     *                     property="comment",
     *                     type="string",
     *                     description="Enter Comment",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *       @OA\Response(
     *         response=200,
     *         description="Reply submitted successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Reply submitted successfully!"
     *             )
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Post Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionReply($id, $parent_id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
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

    /**
     * Like Comment or Removed Liked
     *
     * Allows users to liked comment or removed that.
     *
     * @OA\Post(
     *     path="/posts/comment-like",
     *     tags={"User Post"},
     *     summary="Liked comment or removed that ",
     *     description="Allows users to liked comment or removed that",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user_post_comment_id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post Comment",
     *         @OA\Schema(type="integer")
     *     ),
     *  @OA\Response(
     *         response=200,
     *         description="Comment or Reply Liked successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property( property="isLike", type="boolean", example=true ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment or Reply Liked successfully!"
     *             )
     *         )
     *     ), 
     * )
     */
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
                $message = Yii::$app->api->messageManager->getMessage('common.like_success', ['{var}' => 'Comment or Reply']);
                return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => true], ['message' => $message]);
            }
        } else {
            $like->delete();
            $message = Yii::$app->api->messageManager->getMessage('common.like_removed');
            return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => false], ['message' => $message]);
        }
    }

    /**
     * Like Post or Removed Liked
     *
     * Allows users to liked Post or removed that.
     *
     * @OA\Post(
     *     path="/posts/user-post-like",
     *     tags={"User Post"},
     *     summary="Liked Post or removed that",
     *     description="Allows users to liked Post or removed that",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post Liked successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property( property="isLike", type="boolean", example=true ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Liked successfully!"
     *             )
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Post Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionUserPostLike($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
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
                $message = Yii::$app->api->messageManager->getMessage('common.like_success', ['{var}' => 'Post']);
                return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => true], ['message' => $message]);
            }
        } else {
            $like->delete();
            $message = Yii::$app->api->messageManager->getMessage('common.like_removed');
            return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => false], ['message' => $message]);
        }
    }

    /**
     * Post Report 
     *
     * Allows users to report Post.
     *
     * @OA\Post(
     *     path="/posts/user-post-report",
     *     tags={"User Post"},
     *     summary="Report post",
     *     description="Allows users to report Post",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"message"},
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Enter Message",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Reported successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Reported successfully!"
     *             )
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Post Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionUserPostReport($id)
    {
        $post = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$post) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
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

    /**
     * Post Image Update
     *
     * Allows users to update post.
     *
     * @OA\Post(
     *     path="/posts/post-edit",
     *     tags={"User Post"},
     *     summary="Post Update",
     *     description="Allows users to update post.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"caption","file"},
     *                 @OA\Property(
     *                     property="caption",
     *                     type="string",
     *                     description="Enter Caption",
     *                     example=""
     *                 ),
     *                  @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="Upload Post",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post updated successfully!"
     *             )
     *         )
     *     ),
     *    @OA\Response(
     *     response=400,
     *     description="Validation errors occurred.",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="message",
     *             type="string",
     *             example="Caption cannot be blank., File cannot be blank."
     *         )
     *     )
     *   ),
     *      @OA\Response(
     *         response=404,
     *         description="Post Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not Found!"
     *             )
     *         )
     *     ),
     * )
     */
    public function actionPostEdit($id)
    {
        $user_image_model = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$user_image_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
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

    /**
     * Comment Flag in Post 
     *
     * Allows users to flag comment in Post.
     *
     * @OA\Post(
     *     path="/posts/flag",
     *     tags={"User Post"},
     *     summary="Flag comment  post",
     *     description="Allows users to report Post",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="user_post_comment_id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of User Post Comment",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"flag_reason_id","flag_detail"},
     *                 @OA\Property(
     *                     property="flag_reason_id",
     *                     type="string",
     *                     description="Select Reason",
     *                     example=""
     *                 ),
     *                  @OA\Property(
     *                     property="flag_detail",
     *                     type="string",
     *                     description="Enter Detail",
     *                     example=""
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Flagged successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Flagged successfully!"
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Post Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post Not Found!"
     *             )
     *         )
     *     ),
     * )
     */
    public function actionFlag($id, $user_post_comment_id)
    {
        $user_post_model = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$user_post_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $flag_comment = UserPostComment::find()->where(['id' => $user_post_comment_id])->limit(1)->one();

        if (!$flag_comment) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Comment']);
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
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Post']);
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
