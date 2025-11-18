<?php

namespace api\modules\operator\controllers;

use api\behaviours\Apiauth;
use Yii;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorPark;
use api\models\operator\SafariOperatorRating;
use api\models\operator\SafariOperatorRatingSearch;
use api\models\operator\SafariOperatorSearch;
use api\models\package\Package;
use api\models\package\PackageSearch;
use api\models\package\PackageVersion;
use api\models\package\PackageVersionSearch;
use api\models\park\SafariPark;
use api\models\park\SafariParkSearch;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;
use api\models\UserFollow;
use common\Helper\FirebaseNotificationHelper;
use common\Helper\FrontendNotificationHelper;
use common\interfaces\NewStatusInterface;
use common\models\GeneralModel;
use common\models\leads\form\PartnerLeadForm;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorReportProfileForm;
use common\models\operator\SafariOperatorReportProfile;
use frontend\models\SafariOperatorRatingReportForm;
use frontend\models\SafariOperatorReviewForm;
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
                'exclude' => ['index', 'view', 'reviewlist', 'operator-park', 'user-rating-parklist', 'operator-shared-safari', 'operator-packages', 'operator-park-dropdown'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['follow', 'unfollow', 'quotesrequest', 'review', 'reviewupdate', 'flag', 'report-operator'],
                'rules' => [
                    [
                        'actions' => ['follow', 'unfollow', 'quotesrequest', 'review', 'reviewupdate', 'flag', 'report-operator'],
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
                    'follow' => ['POST'],
                    'unfollow' => ['POST'],
                    'reviewlist' => ['GET'],
                    'operator-park' => ['GET'],
                    'quotesrequest' => ['POST'],
                    'review' => ['POST'],
                    'user-rating-parklist' => ['GET'],
                    'operator-shared-safari' => ['GET'],
                    'operator-packages' => ['GET'],
                    'reviewupdate' => ['POST'],
                    'flag' => ['POST'],
                    'operator-park-dropdown' => ['GET'],
                    'report-operator' => ['POST'],

                ],
            ],
        ];
    }

    // public function actionView($slug)
    // {
    //     $this->layout = \common\interfaces\NewStatusInterface::OPERATOR_API_LAYOUT_FULL;
    //     $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (!$operator) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
    //     }
    //     $searchModel = new SafariOperatorSearch();
    //     $searchModel->id = $operator->id;
    //     return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    //     // return $this->dataSender($operator, $rootIndexName = "Operator");
    // }

    /**
     * Get Operator View
     *
     *
     * @OA\Get(
     *     path="/operator/{slug}",
     *     tags={"Operator"},
     *     summary="Get Operator View",
     *     description = "<b>Purpose:</b> Retrieve detailed information about a safari tour operator (business), including contact details, parks they operate in, ratings, URLs and other metadata.<br> <b>Use Cases : </b><br><ul><li>Operator Detail Page on the frontend.</li><li>Prefill forms for quotation/booking.</li><li>Display operator-related parks, packages and reviews.</li></ul>",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query single operator detail",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="business_name", type="string", example="Rawat Safari"),
     *                 @OA\Property(property="phone_no", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="email", type="string", example="deepti@triline.co.in"),
     *                 @OA\Property(property="operator_phone_no", type="integer", example=9874563210),
     *                 @OA\Property(property="operator_email", type="string", example="deepti@triline.co.in"),
     *                 @OA\Property(property="slug", type="string", example="rawat-safari"),
     *                 @OA\Property(property="address", type="string", example="Noida"),
     *                 @OA\Property(property="google_rating", type="string", example="5"),
     *                 @OA\Property(property="google_review_count", type="integer", example=3),
     *                 @OA\Property(property="about_business", type="string", example="Business is a vast and exciting domain, covering everything from startups and entrepreneurship to corporate strategy and market trends."),
     *                 @OA\Property(property="image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/operator-registration/2505/2276_logo_1747893831.jpg"),
     *                 @OA\Property(property="park_count", type="integer", example=50),
     *                 @OA\Property(property="package_count", type="integer", example=1),
     *                 @OA\Property(property="shared_safari_count", type="integer", example=0),
     *                 @OA\Property(property="follower_list_count", type="integer", example=5),
     *                 @OA\Property(property="category_title", type="string", example="Safari Tour Operator"),
     *                 @OA\Property(property="is_followed", type="boolean", example=false),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="has_direct_call", type="boolean", example=false),
     *                 @OA\Property(property="direct_call_no", type="string", nullable=true ,example=null),
     *                 @OA\Property(
     *                     property="review_url",
     *                     type="object",
     *                     @OA\Property(property="reviews", type="string", example="https://staging-api.walkintothewild.in/operator/rawat-safari/reviewlist?sort_by=highest")

     *                 ),
     *                 @OA\Property(
     *                  property="park",
     *                  type="array",
     *                  @OA\Items(
     *                       type="object",
     *                       @OA\Property(property="id", type="integer", example=1),
     *                       @OA\Property(property="title", type="string", example="Dudhwa Tiger Reserve"),
     *                       @OA\Property(property="slug", type="string", example="dudhwa-tiger-reserve"),
     *                       @OA\Property(property="feature_image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/safaripark/1/park_feature_image1718179650.jpg"),
     *                       @OA\Property(property="quotation_form_note", type="string", example="Test testbb. Jjjjj  jhjjh"),
     *                  )
     *                ),
     *                 @OA\Property(property="is_approved", type="boolean", example=true),
     *                 @OA\Property(property="has_cancellation_policy", type="boolean", example=false),
     *                 @OA\Property(property="budget", type="string", example=""),
     *                 @OA\Property(property="other_wildlife_activity", type="string", example="[]"),
     *                 @OA\Property(property="facebook_url", type="string", nullable=true ,example=null),
     *                 @OA\Property(property="youtube_link", type="string", nullable=true ,example=null),
     *                 @OA\Property(property="instagram_url", type="string", nullable=true ,example=null),
     *                 @OA\Property(property="website", type="string", nullable=true ,example=null),
     *                 @OA\Property(
     *                     property="urls",
     *                     type="object",
     *                     @OA\Property(property="parks", type="string", example="https://staging-api.walkintothewild.in/operator/rawat-safari/operator-park"),
     *                     @OA\Property(property="sharedsafari", type="string", example="https://staging-api.walkintothewild.in/operator/rawat-safari/operator-shared-safari"),
     *                     @OA\Property(property="packages", type="string", example="https://staging-api.walkintothewild.in/operator/rawat-safari/operator-packages"),
     *                     @OA\Property(property="reviews", type="string", example="https://staging-api.walkintothewild.in/operator/rawat-safari/reviewlist?sort_by=highest")
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!"),
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug"),
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator Not Found",
     *     ),
     * )
     */
    public function actionView($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::OPERATOR_API_LAYOUT_FULL;
        $operator = SafariOperator::find()->where(['slug' => $slug])->limit(1)->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($operator->status != SafariOperator::STATUS_ACTIVE) {
            $message = Yii::$app->api->messageManager->getMessage('common.inactive', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 404);
        }
        return Yii::$app->api->sendResponse($data = ['data' => $operator->toArray()]);
    }


    /**
     * Quotes Request Operator
     *
     * Allows users to send a quote request to an operator.
     *
     * @OA\Post(
     *     path="/operator/{slug}/quotesrequest",
     *     tags={"Operator"},
     *     summary="Quotes Request Operator",
     *     description="Allows users to send a quote request to a specific operator using their slug. Includes details like safari count, category, dates, and optional notes.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Operator",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"safari_park_id", "safaris", "travelers", "stay_category_id", "start_date", "end_date"},
     *                 
     *                 @OA\Property(
     *                     property="safari_park_id",
     *                     type="integer",
     *                     description="Safari Park ID",
     *                     example=31
     *                 ),
     *                 @OA\Property(
     *                     property="safaris",
     *                     type="integer",
     *                     description="Number of safaris",
     *                     example=5
     *                 ),
     *                 @OA\Property(
     *                     property="travelers",
     *                     type="integer",
     *                     description="Total number of travelers",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="stay_category_id",
     *                     type="integer",
     *                     description="Stay Category ID",
     *                     example=2
     *                 ),
     *                 @OA\Property(
     *                     property="start_date",
     *                     type="string",
     *                     format="date",
     *                     description="Start Date (YYYY-MM-DD)",
     *                     example="2025-12-14"
     *                 ),
     *                 @OA\Property(
     *                     property="end_date",
     *                     type="string",
     *                     format="date",
     *                     description="End Date (YYYY-MM-DD)",
     *                     example="2025-12-15"
     *                 ),
     *                 @OA\Property(
     *                     property="user_notes",
     *                     type="string",
     *                     nullable=true,
     *                     description="User notes or special requests (optional)",
     *                     example="Buy me a coffee!!!"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Quote request sent successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Quote request sent successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!")
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug")
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator not found."
     *     )
     * )
     */

    public function actionQuotesrequest($slug)
    {
        if ($this->userinfo->is_mobile_no_verified == 0) {
            $message = Yii::$app->api->messageManager->getMessage('common.mobile_verification_required');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 403);
        }

        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo && $this->userinfoId == $operator->user_id) {
            $message = Yii::$app->api->messageManager->getMessage('common.quote_restricted');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $model = new PartnerLeadForm();
        if ($this->userinfo) {
            $model->email = $this->userinfo->email;
            $model->full_name = $this->userinfo->name;
            $model->phone_no = $this->userinfo->mobile_no;
        }
        $model->attributes = $this->request;
        if ($model->validate()) {
            if ($operator_quote = $model->request($operator, $this->userinfo)) {
                $message = Yii::$app->api->messageManager->getMessage('common.quote_request_sent');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    /**
     * Follow Operator
     *
     * Allows users to follow Operator.
     *
     * @OA\Post(
     *     path="/operator/{slug}/follow",
     *     tags={"Operator"},
     *     summary="Follow Operator",
     *     description="This is allows a user to follow a specific operator by using the operator's slug. This action is typically used to receive updates or notifications about the operator's activities, packages, or offerings.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Operator",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Followed successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Followed successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!")
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug")
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator Not Found!"
     *     )
     * )
     */
    public function actionFollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        if ($this->userinfo) {
            if ($this->userinfoId == $operator->user_id) {
                $message = Yii::$app->api->messageManager->getMessage('common.follow_restricted', ['{var}' => 'yourself']);
                return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
            }

            $follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $operator->user_id])->one();
            if (!$follower) {
                $follower = new UserFollow();
            }

            $follower->user_id = $this->userinfoId;
            $follower->follow_user_id = $operator->user_id;
            $follower->status = 1;

            if ($follower->save(false)) {
                // $to_mail = $operator->email;
                // $subject = 'Follow Request';
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_FOLLOW_REQUEST;
                // $req = ['username' => $operator->business_name, 'name' => $this->userinfo->name, 'is_email_sending' => true];

                // MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // FrontendNotificationHelper::operatorNewFollower($operator, $this->userinfo);
                $message = Yii::$app->api->messageManager->getMessage('common.follow_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            } else {
                $message = Yii::$app->api->messageManager->getMessage('common.follow_restricted', ['{var}' => 'this operator currently']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
    }

    /**
     * Unfollow Operator
     *
     * Allows users to unfollow Operator.
     *
     * @OA\Post(
     *     path="/operator/{slug}/unfollow",
     *     tags={"Operator"},
     *     summary="unfollow Operator",
     *     description="This API is allows a user to unfollow a specific operator by their slug identifier. When successfully unfollowed, the API returns a confirmation message.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Operator",
     *         @OA\Schema(type="string")
     *     ),
     * 
     *
     *     @OA\Response(
     *         response=200,
     *         description="Unfollowed successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Unfollowed successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!"),
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug"),
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator Not Found!"
     *     )
     * )
     */
    public function actionUnfollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        if ($this->userinfo) {
            $my_follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $operator->user_id])->one();

            $my_follower->user_id = $this->userinfoId;
            $my_follower->follow_user_id = $operator->user_id;
            $my_follower->status = 0;

            if ($my_follower->save(false)) {
                // $to_mail = $operator->email;
                // $subject = 'UnFollow Request';
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_UNFOLLOW_REQUEST;
                // $req = ['username' => $operator->business_name, 'name' => $this->userinfo->name, 'is_email_sending' => true];

                // MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // Yii::$app->session->setFlash('success', 'You unfollowed ' . $operator->business_name);
                $message = Yii::$app->api->messageManager->getMessage('common.unfollow_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            } else {
                Yii::$app->session->setFlash('success', 'You can not unfollow this operator currently!');
                $message = Yii::$app->api->messageManager->getMessage('common.unfollow_restricted');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
    }

    public function actionReviewlist($slug, $sort_by = null)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $ratingsearchModel = new SafariOperatorRatingSearch();
        $ratingsearchModel->custom_sort_by = $sort_by;
        $ratingsearchModel->safari_operator_id = $operator->id;
        $ratingsearchModel->is_deleted = 0;
        $ratingsearchModel->status = 1;

        // $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->all();
        return $this->dataProviderSender($ratingsearchModel, $rootIndexName = "reviews");
    }

    /**
     * Review to Operator
     *
     * Allows users to review operator for specifice park.
     *
     * @OA\Post(
     *     path="/operator/{slug}/review",
     *     tags={"Operator"},
     *     summary="Review to Operator",
     *     description="The <b>Operator Review API</b> allows users to share feedback and rate safari or tour operators listed on the platform. By submitting a review, users can provide a star rating (e.g., 1–5) along with comments about their experience.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Operator",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"park_id","rating","review"},
     *                 @OA\Property(
     *                     property="park_id",
     *                     type="integer",
     *                     description="Enter Park Id",
     *                     example = "",
     *                 ),
     *                @OA\Property(
     *                     property="rating",
     *                     type="integer",
     *                     description="Enter Rating",
     *                     example = "",
     *                 ),
     *                @OA\Property(
     *                     property="review",
     *                     type="string",
     *                     description="Enter Review",
     *                     example = "",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!"),
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug"),
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator not found."
     *     )
     * )
     */
    public function actionReview($slug)
    {
        $login_operator = SafariOperator::find()->where(['user_id' => $this->userinfo ? $this->userinfoId : null])->limit(1)->one();
        if ($login_operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.operator_cannot_review');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $same_operator = SafariOperator::find()->where(['user_id' => $this->userinfo ? $this->userinfoId : null, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();

        if (!empty($same_operator) && $same_operator->id == $operator->id) {
            $message = Yii::$app->api->messageManager->getMessage('common.rating_restricted');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $model = new SafariOperatorReviewForm();
        $model->safari_operator_id = $operator->id;
        $model->user_id = $this->userinfoId;


        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->rating_model->save(false)) {
                // $model->updateRatingintoTable($operator);
                /**Mail to operator */

                // $operator_name = $operator->business_name;
                // /**Operator Mail Info */
                // $to_mail = $operator->user->username;

                // /**Template info */
                // $subject = 'New Review';
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_REVIEW_TO_OPERATOR;
                // // /**Url Info */
                // $operator_url = Yii::$app->frontendUrlManager->createAbsoluteUrl([
                //     '/operator/default/reviewlist',
                //     'slug' => $operator->slug
                // ]);

                // $req = ['operator_name' => $operator_name, 'operator_url' => $operator_url];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }
                // FirebaseNotificationHelper::newreview($operator, $this->userinfo);
                // FrontendNotificationHelper::operatorNewReview($operator, $model->rating_model,  $this->userinfo);
                $message = Yii::$app->api->messageManager->getMessage('common.thank_you_for_review');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.not_submitted');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    // public function actionOperatorpark($slug)
    // {
    //     $operator = SafariOperator::find()
    //         ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
    //         ->one();
    //     if (!$operator) {
    //         return Yii::$app->api->sendResponse([], ['message' => "Operator Not Found!!!"]);
    //     }

    //     $parks = $operator->park;
    //     return Yii::$app->api->sendResponse(['parks' => $parks]);
    // }

    /**
     * Get Rating
     *
     *
     * @OA\Get(
     *     path="/operator/{slug}/user-rating-parklist",
     *     tags={"Operator"},
     *     summary="Get Rating",
     *     description = "This API returns the list of National Parks and Tiger Reserves with their details (ID, title, slug, feature image, and notes).It is primarily used to fetch parks associated with a given operator for rating or display purposes.",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query single operator detail",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="parks",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(
     *                         property="query_params",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                         example={}
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=321),
     *                         @OA\Property(property="title", type="string", example="Great Himalayan National Park"),
     *                         @OA\Property(property="slug", type="string", example="great-himalayan-national-park"),
     *                         @OA\Property(property="feature_image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/safaripark/321/park_feature_image1722583958.jpg"),
     *                         @OA\Property(property="quotation_form_note", type="string", example=""),
     *                         @OA\Property(property="template_code", type="integer", example=1)     
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!"),
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug"),
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator or Park not found",
     *     )
     * )
     */
    public function actionUserRatingParklist($slug)
    {
        $this->layout = NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }
        $user_park_id = SafariOperatorRating::find()
            ->select('park_id')
            ->where(['user_id' => $this->userinfoId, 'safari_operator_id' => $operator->id, 'status' => 1])
            ->column();

        $operatorsafariparkData = SafariOperatorPark::find()
            ->where(['safari_operator_id' => $operator->id, 'status' => 1])
            ->andWhere(['not in', 'park_id', $user_park_id])
            ->all();

        $ids = array_column($operatorsafariparkData, 'park_id');
        $dataProvider = new ActiveDataProvider([
            'query' => SafariPark::find()->where(['id' => $ids]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => false,
        ]);

        return $this->querySender($dataProvider, $rootIndexName = "parks");
    }

    public function actionOperatorSharedSafari($slug)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }
        $searchModel = new ShareSafariSearch();
        $searchModel->safari_operator_id = $operator->id;
        $searchModel->type = ShareSafari::TYPE_FIXED_DEPARTURE;
        $searchModel->status = [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT];
        return $this->dataProviderSender($searchModel, $rootIndexName = "sharedsafari");
        // return Yii::$app->api->sendResponse($data = ['operatorsharedsafari' => $this->serializeData($operator->sharedsafari)]);
    }

    public function actionOperatorPark($slug)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }
        $safariOperatorPark =  SafariOperatorPark::find()->where(['status' => SafariOperatorPark::STATUS_ACTIVE, 'safari_operator_id' => $operator->id])->all();

        $ids = array_column($safariOperatorPark, 'park_id');


        $dataProvider = new ActiveDataProvider([
            'query' => SafariPark::find()->where(['id' => $ids]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->querySender($dataProvider, $rootIndexName = "parks");
    }

    public function actionOperatorPackages($slug)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }

        $searchModel = new PackageSearch();
        $searchModel->safari_operator_id = $operator->id;
        $searchModel->status = Package::STATUS_ACTIVE;
        $condition = ['not', ['live_version' => null]];
        return $this->dataProviderSenderWithCondition($searchModel, "packages", $condition);
        // return Yii::$app->api->sendResponse($data = ['operatorpackage' => $this->serializeData($operator->packages)]);
    }

    public function actionReviewupdate($slug, $id)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }
        $rating_model = SafariOperatorRating::find()->where(['user_id' => $this->userinfoId, 'safari_operator_id' => $operator->id, 'id' => $id])->one();
        $model = new SafariOperatorReviewForm($rating_model);

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->rating_model->save(false)) {
                $model->updateRatingintoTable($operator);
                $message = Yii::$app->api->messageManager->getMessage('common.thank_you_for_review');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
    }

    /**
     * Flag Review
     *
     * Allows users to flag review.
     *
     * @OA\Post(
     *     path="/operator/{slug}/flag",
     *     tags={"Operator"},
     *     summary="Flag Review",
     *     description="The Operator Flag API allows users to flag a specific operator or content for review. This can be used to report inappropriate behavior, violations, or other issues. Flagging helps maintain platform safety and ensures operators follow guidelines.<br>The API requires the operator’s unique slug and the reason ID (id) in the query parameters. Responses are returned in JSON format with a status flag (1 for success, 0 for error) and a message or error details.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Operator",
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Review Id",
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
     *                     description="Enter Reason Id",
     *                     example = "",
     *                 ),
     *                @OA\Property(
     *                     property="report_detail",
     *                     type="string",
     *                     description="Enter reason",
     *                     example = "",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Flagged successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Flagged successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!"),
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug or review_id"),
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator not found."
     *     )
     * )
     */
    public function actionFlag($slug, $id)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }

        $rating = SafariOperatorRating::find()->where(['id' => $id])->limit(1)->one();
        if (!$rating) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Review']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $model = new SafariOperatorRatingReportForm();
        $model->safari_operator_id = $operator->id;
        $model->park_id = $rating->park_id;
        $model->safari_operator_rating_id = $id;

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->flag_model->save(false)) {
                $rating->flaged = 1;
                $rating->save(false);
                /* Mail to admin*/
                // $to_mail = Yii::$app->params['adminEmail'];
                // $subject = 'Flag Raised in Operator Review : ' . substr($operator->business_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                // $req = ['comment' => $rating->review, 'report_details' => $model->flag_model->report_detail, 'username' => isset($this->userinfo) ? $this->userinfo->name : ''];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }
                $message = Yii::$app->api->messageManager->getMessage('common.report_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
    }


    /**
     * Get Operator Park Drop Down
     *
     *
     * @OA\Get(
     *     path="/operator/{slug}/operator-park-dropdown",
     *     tags={"Operator"},
     *     summary="Get Operator Park Drop Down",
     *     description = "Fetches a list of parks associated with a specific operator, returning basic information about each park such as ID, title, slug, feature image URL, and an optional quotation note.",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query single operator",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="parks",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(
     *                         property="query_params",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                         example={}
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=321),
     *                         @OA\Property(property="title", type="string", example="Great Himalayan National Park"),
     *                         @OA\Property(property="slug", type="string", example="great-himalayan-national-park"),
     *                         @OA\Property(property="feature_image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/safaripark/321/park_feature_image1722583958.jpg"),
     *                         @OA\Property(property="quotation_form_note", type="string", example=""),
     *                         @OA\Property(property="template_code", type="integer", example=1)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!"),
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug"),
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator or Park Not found",
     *     )
     * )
     */
    public function actionOperatorParkDropdown($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }
        $safariOperatorPark =  SafariOperatorPark::find()->where(['status' => SafariOperatorPark::STATUS_ACTIVE, 'safari_operator_id' => $operator->id])->all();

        $ids = array_column($safariOperatorPark, 'park_id');


        $dataProvider = new ActiveDataProvider([
            'query' => SafariPark::find()->where(['id' => $ids]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => false
        ]);

        return $this->querySender($dataProvider, $rootIndexName = "parks");
    }

    /**
     * Report Operator
     *
     * Allows users to report operator.
     *
     * @OA\Post(
     *     path="/operator/{slug}/report-operator",
     *     tags={"Operator"},
     *     summary="Report Operator",
     *     description="The <b>Report Operator API</b> allows users to report an operator for inappropriate content, fraudulent behavior, or other issues. Submitting a report helps maintain the quality and trustworthiness of operators on the platform.<br>All requests require the operator’s unique slug in the URL and proper authentication. Responses are returned in JSON format with a status flag (1 for success, 0 for error) along with a message or error details.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of Operator",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"reason_id","reason"},
     *                 @OA\Property(
     *                     property="reason_id",
     *                     type="integer",
     *                     description="Enter Reason Id",
     *                     example = "",
     *                 ),
     *                @OA\Property(
     *                     property="reason",
     *                     type="string",
     *                     description="Enter reason",
     *                     example = "",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reported successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Reported successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="operator Not Found or Operator Account may be Blocked!"),
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: operator_slug"),
     *         )
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator not found."
     *     )
     * )
     */
    public function actionReportOperator($slug)
    {
        $operator = SafariOperator::find()->where(['slug' => $slug])->limit(1)->one();
        if (!$operator) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Operator']);
            return Yii::$app->api->sendResponse([], ['message' => $message]);
        }

        $model = new SafariOperatorReportProfileForm();
        $model->user_id = $this->userinfoId;
        $model->safari_operator_id = $operator->id;
        $model->status = SafariOperatorReportProfile::STATUS_ACTIVE;

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->report_model->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.report_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
    }
}
