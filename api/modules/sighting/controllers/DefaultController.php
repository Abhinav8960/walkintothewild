<?php

namespace api\modules\sighting\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\sighting\Sighting;
use api\models\sighting\SightingComment;
use api\models\sighting\SightingCommentLike;
use api\models\sighting\SightingLike;
use api\models\sighting\SightingSearch;
use api\models\User;
use common\models\operator\SafariOperator;
use common\models\sighting\form\SightingCommentFlagForm;
use common\models\sighting\form\SightingCommentForm;
use common\models\sighting\form\SightingForm;
use common\models\sighting\form\SightingReplyForm;
use common\models\sighting\form\SightingReportForm;
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
                'exclude' => ['index', 'view', 'daily-update', 'comment-view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'comment', 'reply', 'comment-like', 'sighting-like', 'sighting-report', 'sighting-delete', 'flag'],
                'rules' => [
                    [
                        'actions' => ['comment', 'reply', 'comment-like', 'sighting-like', 'sighting-report', 'flag'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => $this->isSafariOperator(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['sighting-delete'],
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
                    'create' => ['POST'],
                    'comment' => ['POST'],
                    'reply' => ['POST'],
                    'sighting-like' => ['POST'],
                    'comment-like' => ['POST'],
                    'sighting-report' => ['POST'],
                    'sighting-delete' => ['POST'],
                    'flag' => ['POST'],
                    'daily-update' => ['GET'],
                    'comment-view' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Get Sighting List
     *
     *
     * @OA\Get(
     *     path="/sighting",
     *     tags={"Sighting"},
     *     summary="Get Sighting List",
     *     description="Get paginated list of Sighting with optional filters.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sighting fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="sighting",
     *                 type="object",
     *                 @OA\Property(property="summary", ref="#/components/schemas/SummarySchema"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/SightingViewSchema")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function actionIndex()
    {
        $searchModel = new SightingSearch();
        $searchModel->status = Sighting::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "sighting");
    }

    /**
     * Post Sighting
     *
     * Allows operator to post sighting.
     *
     * @OA\Post(
     *     path="/sighting/create",
     *     tags={"Sighting"},
     *     summary="Post Sighting",
     *     description="Allows operator to post sighting.",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"description","file","location","master_animal_id","safari_session_id","post_datetime"},
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Enter Description",
     *                     example="",
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="Upload Video",
     *                 ),
     *                 @OA\Property(
     *                     property="location",
     *                     type="integer",
     *                     description="Enter Park Id",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="safari_session_id",
     *                     type="integer",
     *                     description="Select Session",
     *                     example="",
     *                 ),
     *                   @OA\Property(
     *                     property="post_datetime",
     *                     type="string",
     *                     format="date",
     *                     description="Enter date in format (YYYY-MM_DD)",
     *                     example="",
     *                 ),
     *             )
     *         )
     *     ),
     *      @OA\Response(
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
     *                 example="Sighting added successfully!"
     *             )
     *         )
     *     ),
     *    
     * )
     */
    public function actionCreate()
    {
        $model = new SightingForm();
        $model->user_id = $this->userinfoId;
        $model->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
        $model->status = Sighting::STATUS_ACTIVE;

        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        $model->file = \yii\web\UploadedFile::getInstanceByName('file');
        $model->video_thumbnail = \yii\web\UploadedFile::getInstanceByName('video_thumbnail');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->sighting_model->save()) {
                $model->uploadFile();
                $model->sighting_model->v_size = $model->file->size;
                $model->sighting_model->v_duration = $this->getVideoDuration($model->file);

                $resolution = $this->getVideoResolution($model->file);
                $model->sighting_model->width  = $resolution['width'];
                $model->sighting_model->height = $resolution['height'];

                if ($model->sighting_model->save()) {
                    $active_followers = $model->sighting_model->user->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->asArray()->all();
                    if (!empty($active_followers)) {
                        new \common\events\sighting\SightingCreatedByUser($active_followers, $model->sighting_model->user->name);
                    }
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sighting added successfully"]);
                }
            }
            $message = Yii::$app->api->messageManager->getMessage('sighting.create_sighting.sighting_not_added');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    /**
     * Get Sighting View
     *
     *
     * @OA\Get(
     *     path="/sighting/view",
     *     tags={"Sighting"},
     *     summary="Get Sighting View",
     *     description="Get single sighting details.",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="slug to query single sighting",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Sighting fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="sighting",
     *                 type="object",
     *                 @OA\Property(property="summary", ref="#/components/schemas/SummarySchema"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/SightingViewSchema")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sighting Not found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Not found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionView($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $searchModel = new SightingSearch();
        $searchModel->id = $sighting->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Sighting", $additionalSearchQueryParams = [], $singleRecord = true);
    }

    /**
     * Sighting Comment 
     *
     * Allows users to comment on sighting.
     *
     * @OA\Post(
     *     path="/sighting/comment",
     *     tags={"Sighting"},
     *     summary="Comment on Sighting",
     *     description="Allows users to comment on Sighting.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting",
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
     *                     example="",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
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
     *         description="Sighting Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionComment($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new SightingCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($sighting)) {
            $message = Yii::$app->api->messageManager->getMessage('common.comment_success');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.comment_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    /**
     * Sighting Reply 
     *
     * Allows users to reply on comment in Sighting.
     *
     * @OA\Post(
     *     path="/sighting/reply",
     *     tags={"Sighting"},
     *     summary="Reply on comment in Sighting",
     *     description="Allows users to reply on comment in Sighting",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="parent_id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting Comment",
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
     *                     example="",
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
     *         description="Sighting Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionReply($id, $parent_id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $replymodel = new SightingReplyForm();
        $replymodel->parent_id = $parent_id;

        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($sighting)) {
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
     *     path="/sighting/comment-like",
     *     tags={"Sighting"},
     *     summary="Liked comment or removed that ",
     *     description="Allows users to liked comment or removed that",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="sighting_comment_id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting Comment",
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
    public function actionCommentLike($sighting_comment_id)
    {

        $like = SightingCommentLike::find()->where(['user_id' => $this->userinfoId, 'sighting_comment_id' => $sighting_comment_id, 'status' => SightingCommentLike::STATUS_ACTIVE])->one();
        if (!$like) {
            $like = new SightingCommentLike();
            $like->user_id = $this->userinfoId;
            $like->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
            $like->sighting_comment_id = $sighting_comment_id;
            $like->status = SightingCommentLike::STATUS_ACTIVE;
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
     * Like Sighting or Removed Liked
     *
     * Allows Sighting to liked Post or removed that.
     *
     * @OA\Post(
     *     path="/sighting/sighting-like",
     *     tags={"Sighting"},
     *     summary="Liked Post or removed that ",
     *     description="Allows users to liked Sighting or removed that",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Sighting Liked successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property( property="isLike", type="boolean", example=true ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Liked successfully!"
     *             )
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Sighting Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionSightingLike($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $like = SightingLike::find()->where(['user_id' => $this->userinfoId, 'sighting_id' => $id, 'status' => SightingLike::STATUS_ACTIVE])->one();
        if (!$like) {
            $like = new SightingLike();
            $like->user_id = $this->userinfoId;
            $like->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
            $like->sighting_id = $id;
            $like->status = SightingLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.like_success', ['{var}' => 'Sighting']);
                return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => true], ['message' => $message]);
            }
        } else {
            $like->delete();
            $message = Yii::$app->api->messageManager->getMessage('common.like_removed');
            return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => false], ['message' => $message]);
        }
    }

    private function getVideoDuration($tempFile)
    {
        $tempFilePath = $tempFile->tempName;
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($tempFilePath);
        if (isset($fileInfo['video'])) {
            return (int) $fileInfo['playtime_seconds'];
        }
        return 0;
    }

    /**
     * Sighting Report 
     *
     * Allows Sighting to report Post.
     *
     * @OA\Post(
     *     path="/sighting/sighting-report",
     *     tags={"Sighting"},
     *     summary="Report Sighting ",
     *     description="Allows users to report Sighting",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting",
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
     *                     example="",
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
     *         description="Sighting Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionSightingReport($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new SightingReportForm();
        $model->user_id = $this->userinfoId;
        $model->status = Sighting::STATUS_ACTIVE;
        $model->sighting_id = $sighting->id;
        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        if ($model->validate()) {
            $model->initializeForm();

            if ($model->sighting_model->save()) {
                $message = Yii::$app->api->messageManager->getMessage('common.report_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.not_submitted');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

     /**
     * Sighting Delete 
     *
     * Allows users to Sighting Post.
     *
     * @OA\Post(
     *     path="/sighting/sighting-delete",
     *     tags={"Sighting"},
     *     summary="Delete ",
     *     description="Allows users to Delete Sighting.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting",
     *         @OA\Schema(type="integer")
     *     ),
     *        @OA\Response(
     *         response=200,
     *         description="Sighting Delete successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property( property="status", type="integer", example=1 ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Delete successfully!"
     *             )
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Sighting Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionSightingDelete($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo) {
            if ($this->userinfoId != $sighting->user_id) {
                $message = Yii::$app->api->messageManager->getMessage('common.delete_restricted', ['{var}' => 'Sighting']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }

        $sighting->status = Sighting::STATUS_DELETE;
        if ($sighting->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.deleted');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.delete_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    /**
     * Comment Flag in Sighting 
     *
     * Allows users to flag comment in Sighting.
     *
     * @OA\Post(
     *     path="/sighting/flag",
     *     tags={"Sighting"},
     *     summary="Flag comment  Sighting ",
     *     description="Allows users to report Sighting",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="sighting_comment_id",
     *         in="query",
     *         required=true,
     *         description="Primary Key of Sighting Comment",
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
     *         description="Sighting Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sighting Not Found!"
     *             )
     *         )
     *     ),
     * )
     */
    public function actionFlag($id, $sighting_comment_id)
    {
        $sighting_model = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $flag_comment = SightingComment::find()->where(['id' => $sighting_comment_id])->limit(1)->one();

        if (!$flag_comment) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Comment']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($flag_comment->user_id == $this->userinfoId) {
            $message = Yii::$app->api->messageManager->getMessage('common.flag_restricted');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new SightingCommentFlagForm();
        $model->sighting_id = $sighting_model->id;
        $model->sighting_comment_id = $flag_comment->id;

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->sighting_flag_model->save(false)) {
                $flag_comment->flaged = 1;
                $flag_comment->save(false);
                $message = Yii::$app->api->messageManager->getMessage('common.flag_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    private function isSafariOperator()
    {
        if ($this->userinfo) {
            $operator = SafariOperator::find()->where(['user_id' => $this->userinfoId, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();
            if ($operator) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function actionDailyUpdate()
    {
        // $query = Sighting::find()->where(['show_in_front' => 1, 'status' => Sighting::STATUS_ACTIVE])->limit(9);
        $query = Sighting::find()->where(['status' => Sighting::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC])->limit(10);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => false,
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "sighting");
    }

    public function actionCommentView($id)
    {
        $sighting_model = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => SightingComment::find()->where(['sighting_id' => $sighting_model->id, 'status' => 1, 'parent_id' => null]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "comments");
    }

    private function isOwner()
    {
        if ($this->userinfo) {
            $owner = Sighting::find()->where(['user_id' => $this->userinfoId, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
            if ($owner) {
                return true;
            }
            return false;
        }
        return false;
    }

    private function getVideoResolution($tempFile)
    {
        $tempFilePath = $tempFile->tempName;
        $getID3 = new \getID3();
        $fileInfo = $getID3->analyze($tempFilePath);

        $width = !empty($fileInfo['video']['resolution_x']) ? $fileInfo['video']['resolution_x'] : 0;
        $height = !empty($fileInfo['video']['resolution_y']) ? $fileInfo['video']['resolution_y'] : 0;

        return ['width' => $width, 'height' => $height];
    }
}
