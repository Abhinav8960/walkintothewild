<?php

namespace api\modules\park\controllers;

use api\behaviours\Apiauth;
use api\controllers\RestController;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafari;
use api\behaviours\Verbcheck;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorSearch;
use api\models\package\Package;
use api\models\package\PackageSafariPark;
use api\models\package\PackageVersionSearch;
use api\models\park\SafariParkRating;
use api\models\park\SafariParkRatingSearch;
use api\models\park\SafariParkSearch;
use api\models\sharesafari\ShareSafariSearch;
use api\models\suggestions\SafariSuggestions;
use common\Helper\FirebaseNotificationHelper;
use api\models\package\PackageSearch;
use api\models\park\ParkStayCategory;
use api\models\park\ParkStayCategorySearch;
use api\models\park\SafariParkAccomodation;
use api\models\park\SafariParkAccomodationSearch;
use api\models\park\SafariParkFollower;
use common\events\park\ParkReviewApprovalEvent;
use common\models\GeneralModel;
use common\models\leads\form\ParkLeadForm;
use common\models\suggestions\form\SafariSuggestionsForm;
use frontend\models\SafariParkReviewForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
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
                'exclude' => ['index', 'view', 'filter-parklist', 'reviewlist', 'park-operator', 'park-shared-safari', 'park-package', 'park-stay-category', 'trip-budget', 'planning-type'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['suggestion', 'park-follow', 'park-unfollow', 'quotesrequest'],
                'rules' => [
                    [
                        'actions' => ['suggestion', 'park-follow', 'park-unfollow', 'quotesrequest'],
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
                    'filter-parklist' => ['GET'],
                    'reviewlist' => ['GET'],
                    'suggestion' => ['POST'],
                    'park-operator' => ['GET'],

                    'park-shared-safari' => ['GET'],
                    'park-package' => ['GET'],
                    'quotesrequest' => ['POST'],
                    'park-follow' => ['POST'],
                    'park-unfollow' => ['POST'],
                    'park-stay-category' => ['GET'],
                    'trip-budget' => ['GET'],
                    'planning-type' => ['GET'],

                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */

    /**
     * Get Park List
     *
     * @OA\Get(
     *     path="/park",
     *     tags={"Park"},
     *     summary="Get Park List",
     *    security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *
     * @OA\Response(
     *     response=200,
     *     description="Successful operation. Returns paginated Park list.",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="parks",
     *             type="object",
     *
     *             @OA\Property(
     *                 property="summary",
     *                 ref="#/components/schemas/SummarySchema"
     *             ),
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/ParkListSchema"),
     *                         @OA\Schema(
     *                             @OA\Property(
     *                                 property="top_operators",
     *                                 type="array",
     *                                 @OA\Items(ref="#/components/schemas/PartnerSchema"),
     *                             )
     *                         )
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     * )
     */
    public function actionIndex()
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_WITH_TOP_OPERATORS;
        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "parks");
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    // public function actionView($slug)
    // {

    //     $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FULL;
    //     $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (!$model) {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    //     $searchModel = new SafariParkSearch();

    //     $searchModel->id = $model->id; // for show Selected Park name in search
    //     $searchModel->is_single = true; // for show Selected Park name in search

    //     return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    // }

    /**
     * Get Park List
     *
     *
     * @OA\Get(
     *     path="/park/{slug}",
     *     tags={"Park"},
     *     summary="Get Single Park",
     *     description="Return Single Park details",
     *     security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query single park",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Single Park list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/ParkViewSchema"
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Park not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Park Not Found!"
     *             )
     *         )
     *     )
     * )
     */

    public function actionView($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FULL;
        $model = SafariPark::find()->where(['slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($model->status != SafariPark::STATUS_ACTIVE) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_in_use', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = ['data' => $model->toArray()], ['message' => $message]);
        }
        return Yii::$app->api->sendResponse($data = ['data' => $model->toArray()]);
    }


    /**
     * Get Filter Park List
     *
     *
     * @OA\Get(
     *     path="/filter-parklist",
     *     tags={"Park"},
     *     summary="Get Filter Park List",
     *     security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
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
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated filter park list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="parks",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=5),
     *                         @OA\Property(property="title", type="string", example="Bandhavgarh Tiger Reserve"),
     *                         @OA\Property(property="slug", type="string", example="bandhavgarh-tiger-reserve"),
     *                         @OA\Property(property="feature_image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/safaripark/6/park_feature_image1718179247.jpg"),
     *                         @OA\Property(property="quotation_form_note", type="string", example=""),
     *                         @OA\Property(property="template_code", type="integer", nullable=true, example=1)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    public function actionFilterParklist()
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;

        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        $condition = ['template_code' => 1];
        return $this->dataProviderSenderConditionWithoutPagination($searchModel, "parks", $condition);
        // return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "parks");
    }


    /**
     * Get Park Review List
     *
     * @OA\Get(
     *     path="/park/{slug}/reviewlist",
     *     tags={"Park"},
     *     summary="Get Park Review List",
     *     security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug to query park review list",
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated park review list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="reviews",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     ref="#/components/schemas/SummarySchema"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ParkReviewSchema")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Park not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Park Not Found!"
     *             )
     *         )
     *     )
     * )
     */

    public function actionReviewlist($slug, $sort_by = null)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        // $my_review = SafariParkRating::find()->where(['safari_park_id' => $model->id, 'user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->one();

        $searchModel = new SafariParkRatingSearch();
        $searchModel->safari_park_id = $model->id;
        $searchModel->status = 1;
        $searchModel->custom_sort_by = $sort_by;

        return $this->dataProviderSender($searchModel, $rootIndexName = "reviews");
    }


    /**
     * Post Park Suggestion 
     *
     * @OA\Post(
     *     path="/park/{slug}/suggestion",
     *     tags={"Park"},
     *     summary="Post Park Suggestion",
     *     description="Allow user to submit a park suggestion",
     *    security={
     *             {"bearerAuth"={} },
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug to identify the Park",
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"master_suggestion_id", "details"},
     *
     *                 @OA\Property(
     *                     property="master_suggestion_id",
     *                     type="integer",
     *                     example=""
     *                 ),
     *
     *                 @OA\Property(
     *                     property="details",
     *                     type="string",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Submitted successfully")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Park not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Park Not Found!"
     *             )
     *         )
     *     )
     * )
     */

    public function actionSuggestion($slug)
    {
        $safari_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$safari_park) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo) {
            $model = new SafariSuggestionsForm();
            $model->status = SafariSuggestions::STATUS_ACTIVE;
            $model->is_approved = 0;
            $model->park_id = $safari_park->id;
            $model->name = $this->userinfo->name;
            $model->email = $this->userinfo->email;
            $model->phone = $this->userinfo->mobile_no;
            $model->ip_address = Yii::$app->request->getRemoteIP();

            $model->attributes = $this->request;
            if ($model->validate()) {
                $model->initializeForm();
                if ($model->safari_suggestion_model->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.submit', ['{var}' => 'Suggestion']);
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.not_submit', ['{var}' => 'Suggestion']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    /**
     * Post Park Review 
     *
     *
     * @OA\Post(
     *     path="/park/{slug}/review",
     *     tags={"Park"},
     *     summary="Post Park Review",
     *     description="Allow user to submit a park review",
     *     security={
     *             {"bearerAuth"={} },
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query Park",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"rating", "review"},
     *                 @OA\Property(
     *                     property="rating",
     *                     type="integer",
     *                     example = ""
     *                 ),
     *                 @OA\Property(
     *                     property="review",
     *                     type="string",
     *                     example = ""
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Review submitted successfully"),
     *         )
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Park not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Park Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionReview($slug)
    {
        $safari_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$safari_park) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $my_review = SafariParkRating::find()->where(['safari_park_id' => $safari_park->id, 'user_id' => $this->userinfo ? $this->userinfoId : null])->limit(1)->one();
        if (!$my_review) {
            $model = new SafariParkReviewForm();
            $model->safari_park_id = $safari_park->id;
            $model->status = SafariParkRating::STATUS_SUSPEND;
            $model->attributes = $this->request;
            if ($model->validate()) {
                $model->initializeForm();
                if ($model->rating_model->save(false)) {
                    new ParkReviewApprovalEvent($safari_park->title, $model->rating_model->review);
                    Yii::$app->session->setFlash('success', 'Thanks for Review! Your review sent for approval');
                    $message = Yii::$app->api->messageManager->getMessage('park.review.review_submitted');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('park.review.review_failed');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
            return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        } else {
            $message = Yii::$app->api->messageManager->getMessage('park.review.review_already_submitted');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
    }


    public function actionParkOperator($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;


        return $this->dataProviderSender($operatorsearchModel, $rootIndexName = "operators", $additionalSearchQueryParams = [$park_id = $model->id]);
    }

    public function actionParkSharedSafari($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $searchModel = new ShareSafariSearch();
        $searchModel->park_id = $model->id;
        $searchModel->status = ShareSafari::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "shared_safari");
    }

    public function actionParkPackage($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $safaripackages = PackageSafariPark::find()->where(['park_id' => $model->id, 'status' => 1])->all();
        $packageIds = array_column($safaripackages, 'package_id');
        $searchModel = new PackageSearch();
        $searchModel->id = $packageIds;
        $searchModel->status = Package::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, "packages");
    }

    /**
     * Post Qoute Request Park  
     *
     *
     * @OA\Post(
     *     path="/park/{slug}/quotesrequest",
     *     tags={"Park"},
     *     summary="Qoute Request Park",
     *     description="Allow user to submit a park quote request",
     *    security={
     *             {"bearerAuth"={} },
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query Park",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"safaris", "travelers", "stay_category_id", "start_date", "end_date", "planning_type", "trip_budget"},
     *                 @OA\Property(property="safaris",type="integer",example=""),
     *                 @OA\Property(property="travelers",type="integer",example=""),
     *                 @OA\Property(property="stay_category_id",type="integer",example=""),
     *                 @OA\Property(property="start_date",type="string",format="date",example=""),
     *                 @OA\Property(property="end_date",type="string",format="date",example=""),
     *                 @OA\Property(property="user_notes",type="string",example=""),
     *                 @OA\Property(property="planning_type",type="integer",example=""),
     *                 @OA\Property(property="trip_budget",type="integer",example="")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Quote Request Sent!"),
     *         )
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Park not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Park Not Found!"
     *             )
     *         )
     *     )
     * )
     */

    public function actionQuotesrequest($slug)
    {
        if ($this->userinfo->is_mobile_no_verified == 0) {
            $message = Yii::$app->api->messageManager->getMessage('common.mobile_verification_required');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 403);
        }

        if ($this->userinfo) {
            $safari_operator = SafariOperator::find()->where(['user_id' => $this->userinfoId])->limit(1)->one();
            if ($safari_operator) {
                $message = Yii::$app->api->messageManager->getMessage('park.quote_request.operator_restricted');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }

        $sf = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$sf) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }


        $model = new ParkLeadForm();
        if ($this->userinfo) {
            $model->email = $this->userinfo->email;
            $model->full_name = $this->userinfo->name;
            $model->phone_no = $this->userinfo->mobile_no;
        }
        $model->attributes = $this->request;
        $model->safari_park_id = $sf->id;
        if ($model->validate()) {
            if ($park_quote = $model->request($this->userinfo)) {
                // FirebaseNotificationHelper::operatorquoterequest($operator, $this->userinfo);
                if (count($sf->operator) == 0) {
                    $message = Yii::$app->api->messageManager->getMessage('park.quote_request.no_verified_operators');
                    return Yii::$app->api->sendResponse($data = ['status' => 1, 'autoclose' => false], ['message' => $message]);
                } else {
                    $message = Yii::$app->api->messageManager->getMessage('park.quote_request.request_sent');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
            }
        } else {
            return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }

        if (count($sf->operator) < 1) {
            $message = Yii::$app->api->messageManager->getMessage('park.quote_request.no_verified_operators');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        // return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionParkFollow($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($this->userinfo) {
            $park_follower = SafariParkFollower::find()->where(['user_id' => $this->userinfoId, 'safari_park_id' => $model->id])->limit(1)->one();
            if (!$park_follower) {
                $park_follower = new SafariParkFollower();
            }
            $park_follower->user_id = $this->userinfoId;
            $park_follower->safari_park_id = $model->id;
            $park_follower->follow_datetime = time();
            $park_follower->status = 1;
            if ($park_follower->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.follow_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.follow_failed');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_logged_in');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }


    public function actionParkUnfollow($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($this->userinfo) {
            $park_follower = SafariParkFollower::find()->where(['user_id' => $this->userinfoId, 'safari_park_id' => $model->id])->limit(1)->one();
            if ($park_follower) {
                $park_follower->unfollow_datetime = time();
                $park_follower->status = 0;
                if ($park_follower->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.unfollow_success');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.follow_failed');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_logged_in');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }


    /**
     * Get Stay Category Option
     * 
     * @OA\Get(
     *     path="/park/{slug}/park-stay-category",
     *     tags={"Park"},
     *     summary="Get Stay Category Option",
     *     description="Get Stay Category Option by Park Slug",
     *    security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Park slug to query stay category option",
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns stay category options.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="stay_category_options",
     *                 type="object",
     *
     *                 @OA\Property(
     *                     property="summary",
     *                     ref="#/components/schemas/SummarySchema"
     *                 ),
     *
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Forest Rest House")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Park not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Park Not Found!"
     *             )
     *         )
     *     )
     * )
     */
    public function actionParkStayCategory($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $searchModel = new SafariParkAccomodationSearch();
        $searchModel->safari_park_id = $model->id;
        $searchModel->status = SafariParkAccomodation::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "stay_category_options");
    }

    // public function actionParkStayCategory($slug)
    // {
    //     $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (!$model) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Park Not Found!!!"]);
    //     }

    //     $searchModel = new SafariParkAccomodationSearch();
    //     $searchModel->safari_park_id = $model->id;
    //     $searchModel->status = SafariParkAccomodation::STATUS_ACTIVE;

    //     $data = [];
    //     $searchModel->load(\Yii::$app->request->queryParams);
    //     $searchModel->setAttributes(\Yii::$app->request->queryParams);

    //     $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);



    //     $dataProvider->pagination = false;

    //     $data['stay_category_options']['summary']['query_params'] = $this->query_params;
    //     $data['stay_category_options']['data'] = $this->serializeData($dataProvider->getModels());
    //     return Yii::$app->api->sendResponse($data);
    // }


    /**
     * Get Trip Budget
     * 
     * @OA\GET(
     *     tags={"Park"},
     *     path="/trip-budget",
     *     summary="Get Trip Budget List",
     *     description="Get Trip Budget List",
     *     security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation. Returns park trip budget list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="value", type="string", example="₹10,000 - ₹20,000"),
     *                  
     *                 )        
     *             )
     *         )
     *     ),
     * )
     */
    public function actionTripBudget()
    {
        $data['data'] = GeneralModel::tripbudget();
        return Yii::$app->api->sendResponse($data);
    }

    /**
     * Get Planning Type
     * 
     * @OA\GET(
     *     tags={"Park"},
     *     path="/planning-type",
     *     summary="Get Park Planning Type List",
     *     security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *      @OA\Response(
     *        response=200,
     *        description="Successful operation. Returns Planning Type.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="value", type="string", example="Immediately / This Week"),
     *                  
     *                 )        
     *             )
     *         )
     *     ),
     * )
     */

    public function actionPlanningType()
    {
        $data['data'] = GeneralModel::planningtype();
        return Yii::$app->api->sendResponse($data);
    }
}
