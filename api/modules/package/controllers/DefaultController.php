<?php

namespace api\modules\package\controllers;

use api\behaviours\Apiauth;
use Yii;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\operator\SafariOperator;
use api\models\package\Package;
use api\models\package\PackageComment;
use api\models\package\PackageCommentSearch;
use api\models\package\PackageFaq;
use api\models\package\PackageFaqSearch;
use api\models\package\PackageSafariPark;
use api\models\package\PackageVersion;
use api\models\package\PackageVersionSearch;
use api\models\park\SafariPark;
use api\models\park\SafariParkSearch;
use api\models\UserWishlist;
use common\Helper\FirebaseNotificationHelper;
use common\Helper\FrontendNotificationHelper;
use common\models\GeneralModel;
use common\models\MailLog;
use common\models\package\PackageDaySearch;
use api\models\package\PackageSearch;
use common\models\leads\form\PackageLeadForm;
use frontend\models\PackageCommentForm;
use frontend\models\PackageCommentReportForm;
use frontend\models\PackageQuoteForm;
use frontend\models\PackageReplyForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class DefaultController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['index', 'view', 'staycategory', 'comment-view', 'package-park', 'package-days', 'package-faqs'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['comment', 'reply', 'wishlist', 'unwishlist', 'package-quote', 'flag'],
                'rules' => [
                    [
                        'actions' => ['comment', 'reply', 'wishlist', 'unwishlist', 'package-quote', 'flag'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'comment' => ['POST'],
                    'reply' => ['POST'],
                    'wishlist' => ['POST'],
                    'unwishlist' => ['POST'],
                    'package-quote' => ['POST'],
                    'flag' => ['POST'],
                    'staycategory' => ['GET'],
                    'comment-view' => ['GET'],
                    'package-park' => ['GET'],
                    'package-days'  => ['GET'],
                    'package-faqs' => ['GET']
                ],
            ],
        ];
    }

    /**
     * Get Package List
     *
     *
     * @OA\Get(
     *     path="/package",
     *     tags={"Package"},
     *     summary="Get Package List (Draft)",
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
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $searchModel->status = Package::STATUS_ACTIVE;
        $searchModel->custom_sort_by = 5;
        $condition = "safari_operator_id IN (SELECT id from safari_operator WHERE status=1)";

        return $this->dataProviderSenderWithCondition($searchModel, $rootIndexName = "packages", $condition);
    }


    // public function actionView($slug)
    // {
    //     $this->layout = \common\interfaces\NewStatusInterface::PACKAGE_API_LAYOUT_FULL;
    //     $package = Package::find()->where(['package_slug' => $slug])->limit(1)->one();
    //     if (!$package) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
    //     }
    //     $searchModel = new PackageVersionSearch();
    //     $searchModel->id = $package->id;
    //     return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    // }

    /**
     * Get Package View
     *
     *
     * @OA\Get(
     *     path="/package/{slug}/view",
     *     tags={"Package"},
     *     summary="Get Package View (Draft)",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query single package",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionView($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PACKAGE_API_LAYOUT_FULL;
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['IS NOT', 'live_version', null])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 404);
        }

        if ($package->status == Package::STATUS_BLOCKED) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 404);
        }

        if ($package->status != Package::STATUS_ACTIVE) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_in_use', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = ['data' => $package->toArray()], ['message' => $message]);
        }

        return Yii::$app->api->sendResponse($data = ['data' => $package->toArray()]);
    }



    /**
     * Post Comment on Package
     *
     * Allows users to comment on package
     *
     * @OA\Post(
     *     path="/package/{slug}/comment",
     *     tags={"Package"},
     *     summary="Comment on Package (Draft)",
     *     description="Allows users to comment on Package.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Package",
     *         @OA\Schema(type="string")
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
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment submitted successfully!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Package not found."
     *     )
     * )
     */
    public function actionComment($slug)
    {

        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $model = new PackageCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($package)) {
            // if ($this->userinfo) {
            //     /**login User info */
            //     $user = $this->userinfo;
            //     $username = $user->name;
            //     /**Mail sent to package owner */
            //     $to_mail = $package->user->username;
            //     /**subject of mail */
            //     $subject = 'New Comment : Package | ' . substr($package->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
            //     $creator_name = $package->user->name;
            //     $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_PACKAGE_COMMENT_BY_USER;
            //     /**Package Url */
            //     $package_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
            //     $req = ['username' => $username, 'package_url' => $package_url, 'creator_name' => $creator_name, 'package' => $package->attributes];
            //     $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            //     if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
            //         GeneralModel::sendmailfromlog($maillog_data['log_id']);
            //     }
            //     FrontendNotificationHelper::packageNewComment($package, $this->userinfo);
            // }
            $message = Yii::$app->api->messageManager->getMessage('common.comment_success');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }


    /**
     * Post Reply on Comment in Package
     *
     * Allows users to reply to specific comment in Package.
     *
     * @OA\Post(
     *     path="/package/{slug}/reply",
     *     tags={"Package"},
     *     summary="Reply to specific comment in Package (Draft)",
     *     description="Allows users to reply to specific comment in Package.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Package",
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="parent_id",
     *         in="query",
     *         required=true,
     *         description="Parent Id is the comment id on which reply post",
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
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reply submitted successfully!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Package not found."
     *     )
     * )
     */
    public function actionReply($slug, $parent_id)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo && isset($package->partner) && $package->safari_operator_id != $package->partner->id) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot Reply!!!"]);
        }

        $replymodel = new PackageReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($package)) {
                $reply_comment = $replymodel->commentbyParent();
                // if ($reply_comment) {
                //     if ($this->userinfo) {
                //         $user = $this->userinfo;
                //         $username = $user->name;
                //         $to_mail = $package->user->username;
                //         $subject = 'New Reply : Package | ' . substr($package->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                //         $creator_name = $package->user->name;
                //         $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_PACKAGE_REPLY_BY_USER;
                //         $package_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
                //         $req = ['username' => $username, 'package_url' => $package_url, 'creator_name' => $creator_name, 'package' => $package->attributes];
                //         $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                //         if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //             GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //         }
                //         // FrontendNotificationHelper::packageCommentReply($package, $reply_comment->user);
                //     }
                // }
                $message = Yii::$app->api->messageManager->getMessage('common.reply_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    /**
     * Wishlist Package
     *
     * Allows users to whishlist Package.
     *
     * @OA\Post(
     *     path="/package/{slug}/wishlist",
     *     tags={"Package"},
     *     summary="Wishlist Package (Draft)",
     *     description="Allows users to whishlist Package",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Package",
     *         @OA\Schema(type="string")
     *     ),
     * 
     *
     *     @OA\Response(
     *         response=200,
     *         description="You added the Package to your wishlist!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Package not found."
     *     )
     * )
     */
    public function actionWishlist($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($this->userinfo) {
            if ($this->userinfo->partner) {
                $message = Yii::$app->api->messageManager->getMessage('common.not_allowed');
                return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
            }
        }

        if ($package) {
            $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
            if (!$wishlist) {
                $wishlist = new UserWishlist();
            }
            $wishlist->user_id = $this->userinfoId;
            $wishlist->item_id = $package->id;
            $wishlist->item_type_id = UserWishlist::SAFARI_PACKAGE;
            $wishlist->item_type = 'package';
            $wishlist->status = 1;
            if ($wishlist->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.wishlist_added', ['{var}' => 'Package']);
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    /**
     * Unwishlist Package
     *
     * Allows users to Unwishlist Package.
     *
     * @OA\Post(
     *     path="/package/{slug}/unwishlist",
     *     tags={"Package"},
     *     summary="Unwishlist Package(Draft)",
     *     description="Allows users to Unwishlist Package",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Package",
     *         @OA\Schema(type="string")
     *     ),
     * 
     *
     *     @OA\Response(
     *         response=200,
     *         description="You removed the Package from your wishlist!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Package not found."
     *     )
     * )
     */
    public function actionUnwishlist($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($this->userinfo) {
            if ($this->userinfo->partner) {
                $message = Yii::$app->api->messageManager->getMessage('common.not_allowed');
                return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
            }
        }

        if ($package) {
            $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
            if ($wishlist) {
                $wishlist->status = 0;
                if ($wishlist->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.wishlist_removed', ['{var}' => 'Package']);
                    return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.wishlist_remove_failed', ['{var}' => 'Package']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    /**
     * Quote Request
     *
     * Allows users to raise quote request for Package.
     *
     * @OA\Post(
     *     path="/package/{slug}/package-quote",
     *     tags={"Package"},
     *     summary="Quote Request for Package (Draft)",
     *     description="Allows users to raise quote request for Package.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Package",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"travelers","pack_start_date","user_notes"},
     *                 @OA\Property(
     *                     property="travelers",
     *                     type="integer",
     *                     description="Enter Number of Travelers",
     *                 ),
     *                  @OA\Property(
     *                     property="pack_start_date",
     *                     type="string",
     *                     format="date",
     *                     description="Start date of the safari (YYYY-MM-DD)",
     *                     example = ""
     *                 ),
     *                  @OA\Property(
     *                     property="user_notes",
     *                     type="string",
     *                     description="Enter User Notes",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reported successfully!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Package not found."
     *     )
     * )
     */
    public function actionPackageQuote($slug)
    {
        if ($this->userinfo->is_mobile_no_verified == 0) {
            $message = Yii::$app->api->messageManager->getMessage('common.mobile_verification_required');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 403);
        }

        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo && isset($package->partner) && $this->userinfoId == $package->partner->user_id) {
            $message = Yii::$app->api->messageManager->getMessage('common.quote_restricted', ['{var}' => 'package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $packagemodel = new PackageLeadForm();
        $packagemodel->attributes = $this->request;
        if ($packagemodel->validate()) {
            if ($packagemodel->request($package->id, $this->userinfo)) {
                // FirebaseNotificationHelper::packageintrest($package, $this->userinfo);
                $message = Yii::$app->api->messageManager->getMessage('common.quote_request_sent');
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.quote_request_failed');
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return Yii::$app->api->sendFailedStringResponse($packagemodel->firstErrors, 400);
    }

    /**
     * Post Flag on Comment or reply in Package
     *
     * Allows users to post Flag on Comment or reply in Package.
     *
     * @OA\Post(
     *     path="/package/{slug}/flag",
     *     tags={"Package"},
     *     summary="Flag on Comment or reply in Package (Draft)",
     *     description="Allows users to post Flag on Comment or reply in Package.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Package",
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="package_comment_id",
     *         in="query",
     *         required=true,
     *         description="Primary key of comment or reply",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"report_reason_id","report_detail"},
     *                 @OA\Property(
     *                     property="report_reason_id",
     *                     type="integer",
     *                     description="Select Report Reason",
     *                 ),
     *                  @OA\Property(
     *                     property="report_detail",
     *                     type="string",
     *                     description="Enter Report Detail",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reported successfully!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Package not found."
     *     )
     * )
     */
    public function actionFlag($slug, $package_comment_id)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }


        $comments = PackageComment::find()->where(['id' => $package_comment_id])->limit(1)->one();
        if ($comments->user_id == $this->userinfoId) {
            $message = Yii::$app->api->messageManager->getMessage('common.flag_restricted');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new PackageCommentReportForm();
        $model->package_id = $package->id;
        $model->package_comment_id = $package_comment_id;

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->flag_model->save(false)) {
                $comments->flaged = 1;
                $comments->save(false);

                // $to_mail = Yii::$app->params['adminEmail'];
                // $subject = 'Flag Raised | Package : ' . substr($package->package_name, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                // $req = ['comment' => $comments->comment, 'report_details' => $model->flag_model->report_detail, 'username' => isset($this->userInfo) ? $this->userInfo->name : ''];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }
                $message = Yii::$app->api->messageManager->getMessage('common.report_success');
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.report_failed');
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    /**
     * Get Stay Category
     *
     *
     * @OA\Get(
     *     path="/package/staycategory",
     *     tags={"Share Safari"},
     *     summary="Get Package Stay Category (Draft)",
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionStaycategory()
    {
        $data = GeneralModel::budgetoption();
        return Yii::$app->api->sendResponse(array_map(function ($value, $key) {
            return ['id' => $key, 'name' => $value];
        }, $data, array_keys($data)));
    }


    public function actionCommentView($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $searchModel = new PackageCommentSearch();
        $searchModel->status = PackageCommentSearch::STATUS_ACTIVE;
        $searchModel->package_id = $package->id;
        return $this->dataProviderSender($searchModel, "comments");
    }

    public function actionPackagePark($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }


        $packageSafariPark = PackageSafariPark::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'package_id' => $package->id])
            ->all();
        if (!$packageSafariPark) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }


        $ids = array_column($packageSafariPark, 'park_id');


        $dataProvider = new ActiveDataProvider([
            'query' => SafariPark::find()->where(['id' => $ids]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "parks");
    }

    public function actionPackageDays($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $searchModel = new PackageDaySearch();
        $searchModel->status = PackageDaySearch::STATUS_ACTIVE;
        $searchModel->package_id = $package->id;
        return $this->dataProviderSender($searchModel, "PackageDay");
    }

    public function actionPackageFaqs($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $searchModel = new PackageFaqSearch();
        $searchModel->status = PackageFaqSearch::STATUS_ACTIVE;
        $searchModel->package_id = $package->id;


        $data = [];
        $searchModel->load(\Yii::$app->request->queryParams);
        $searchModel->setAttributes(\Yii::$app->request->queryParams);

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);



        $dataProvider->pagination = false;

        // $data['PackageFaq']['summary']['total'] = $dataProvider->getTotalCount();
        // $data['PackageFaq']['summary']['page'] = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
        // $data['PackageFaq']['summary']['pageSize'] = $dataProvider->pagination->pageSize;
        // $data['PackageFaq']['summary']['total_page'] = ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);

        $data['PackageFaq']['summary']['query_params'] = $this->query_params;

        if ($dataProvider->getTotalCount() > 0) {
            $data['PackageFaq']['data'] = $this->serializeData($dataProvider->getModels());
        } else {
            $data['PackageFaq']['data'] = $this->serializeData($this->prepareDefaultQuestionAnswer($package));
        }

        return Yii::$app->api->sendResponse($data);
    }

    private function prepareDefaultQuestionAnswer($package)
    {
        return  $arr = [
            [
                'question' => "Are meals included in the Package?",
                'answer' => $package->meals == 'Included' ? "Yes: Meals are included and will be provided as per the itinerary." : "No: Meals are not included; it will be charged additionally.",
            ],
            [
                'question' => "Does the Package include transport to and from the resort?",
                'answer' => $package->pickanddrop == 'Included' ? "Yes: Transport to and from the resort is included in the Package." : "No: Transport is not included; you will need to arrange your own.",
            ],
            [
                'question' => "Are accommodation arrangements included in the Package?",
                'answer' => $package->accomodationIncludes == 'Included' ? "Yes: Accomodation is included." : "No: Accomodation is not included.",
            ],

        ];
    }
}
