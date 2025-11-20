<?php

namespace api\modules\account\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\account\form\SafaritourRegistrationForm;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorRequestActivities;
use api\models\operator\SafariOperatorRequestPark;
use api\models\package\Package;
use api\models\package\PackageVersionSearch;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;
use api\models\User;
use api\models\UserPrivacyPolicyAcknowledgement;
use api\models\UserWishlist;
use api\models\compliancedocuments\ComplianceDocuments;
use common\models\GeneralModel;
use common\models\MailLog;
use frontend\models\profile\PrivacyForm;
use frontend\models\profile\UserForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * Default controller for the `account` module
 */
class DefaultController extends RestController
{
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'profile-photo', 'cover-photo', 'privacy', 'dropdownoptions', 'wishlist-package', 'wishlist-shared-safari', 'profile-delete', 'privacy-policy-acknowledge'],
                'rules' => [
                    [
                        'actions' => ['index', 'profile-photo', 'cover-photo', 'privacy', 'dropdownoptions', 'wishlist-package', 'wishlist-shared-safari', 'profile-delete', 'privacy-policy-acknowledge'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [

                    'index' => ['POST'],
                    'profile-photo' => ['POST'],
                    'cover-photo' => ['POST'],
                    'privacy' => ['POST'],
                    'dropdownoptions' => ['GET'],
                    'wishlist-package' => ['GET'],
                    'wishlist-shared-safari' => ['GET'],
                    'profile-delete' => ['POST'],
                    'privacy-policy-acknowledge' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Post General Information
     *
     * @OA\Post(
     *     path="/account",
     *     tags={"Account"},
     *     summary="Update General Information",
     *     description="Allows users to update their own general information.",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", nullable=true, example=""),
     *                 @OA\Property(property="mobile_no", type="integer", nullable=true, example=""),
     *                 @OA\Property(property="user_handle", type="string", nullable=true, example=""),
     *                 @OA\Property(property="date_of_birth", type="string", format="date", nullable=true, example=""),
     *                 @OA\Property(property="gender", type="integer", nullable=true, example=""),
     *                 @OA\Property(property="user_bio", type="string", nullable=true, example=""),
     *                 @OA\Property(property="about", type="string", nullable=true, example=""),
     *                 @OA\Property(property="facebook_url", type="string", nullable=true, example=""),
     *                 @OA\Property(property="x_url", type="string", nullable=true, example=""),
     *                 @OA\Property(property="insta_url", type="string", nullable=true, example=""),
     *                 @OA\Property(property="youtube_url", type="string", nullable=true, example=""),
     *                 @OA\Property(property="website_url", type="string", nullable=true, example="")
     *             )
     *         )
     *     ),
     *
     *    @OA\Response(
     *         response=200,
     *         description="Information Updated successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Information Updated successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The format of D.O.B is invalid.")
     *         )
     *     ),
     * )
     */

    public function actionIndex()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'Manage']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $model = new UserForm($user_model);

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.updated', ['{var}' => 'Information']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed', ['{var}' => 'Information']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }




    /**
     * Post Profile Photo 
     *
     *
     * @OA\Post(
     *     path="/account/profile-photo",
     *     tags={"Account"},
     *     summary="Update Profile Photo",
     *     description="Allows update their own profile photo.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="profile_image",type="file",example="")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile Photo Updated successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Profile Photo Updated successfully!")
     *         )
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Only files with these extensions are allowed: jpeg, jpg, png.")
     *         )
     *     ),
     * )
     */
    public function actionProfilePhoto()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'Manage']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $model = new UserForm($user_model);
        $model->attributes = $this->request;
        $model->profile_image = UploadedFile::getInstanceByName('profile_image');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                $model->uploadFile();
                $message = Yii::$app->api->messageManager->getMessage('common.updated', ['{var}' => 'Profile Photo']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed', ['{var}' => 'Profile Photo']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    /**
     * Post Cover Photo 
     *
     *
     * @OA\Post(
     *     path="/account/cover-photo",
     *     tags={"Account"},
     *     summary="Update Cover Photo",
     *     description="Allows update their own cover photo.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="cover_image",type="file",example="")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cover Photo Updated successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Cover Photo Updated successfully!")
     *         )
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Only files with these extensions are allowed: jpeg, jpg, png.")
     *         )
     *     ),
     * )
     */

    public function actionCoverPhoto()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'Manage']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $model = new UserForm($user_model);
        $model->attributes = $this->request;
        $model->cover_image = UploadedFile::getInstanceByName('cover_image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                $model->uploadFile();
                $message = Yii::$app->api->messageManager->getMessage('common.updated', ['{var}' => 'Cover Photo']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed', ['{var}' => 'Cover Photo']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    // public function actionRegistrationOperator()
    // {
    //     if ($this->userinfo) {
    //         $registration_model = SafariOperator::findOne(['user_id' => $this->userinfoId]);
    //         if ($registration_model) {
    //             $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator',['{var}'=>'Manage']);
    //             return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    //         }
    //     }

    //     $registration_model = new SafaritourRegistrationForm();
    //     $registration_model->status = SafariOperator::STATUS_ACTIVE;
    //     $registration_model->user_id = $this->userinfoId;

    //     // $registration_model->action_url = Url::toRoute(['/account/default/registration-operator']);
    //     // $registration_model->action_validate_url = Url::toRoute(['/account/default/validate']);

    //     $registration_model->referrer_url = \Yii::$app->request->referrer;

    //     $registration_model->attributes = $this->request;
    //     $registration_model->logo = UploadedFile::getInstanceByName('logo');

    //     if ($registration_model->budget_segment) {
    //         $registration_model->budget_segment = explode(',', $registration_model->budget_segment);
    //     }
    //     if ($registration_model->offers_other_wildlifeactivities) {
    //         $registration_model->offers_other_wildlifeactivities = explode(',', $registration_model->offers_other_wildlifeactivities);
    //     }
    //     if ($registration_model->park_id) {
    //         $registration_model->park_id = explode(',', $registration_model->park_id);
    //     }

    //     if ($registration_model->validate()) {
    //         $registration_model->initializeForm();
    //         if ($registration_model->safarioperator_request_model->save(false)) {
    //             $registration_model->uploadFile();
    //             $parks = $registration_model->park_id;

    //             if ($parks) {
    //                 foreach ($parks as $park) {
    //                     $safarioperatorrequestpark = new SafariOperatorRequestPark();
    //                     $safarioperatorrequestpark->safari_operator_request_id = $registration_model->safarioperator_request_model->id;
    //                     $safarioperatorrequestpark->park_id = $park;
    //                     $safarioperatorrequestpark->save(false);
    //                 }
    //             }


    //             $activities = $registration_model->offers_other_wildlifeactivities;
    //             if ($activities) {
    //                 foreach ($activities as $activity) {
    //                     $safarioperatorrequestpark = new SafariOperatorRequestActivities();
    //                     $safarioperatorrequestpark->safari_operator_request_id = $registration_model->safarioperator_request_model->id;
    //                     $safarioperatorrequestpark->wildlife_activity_id = $activity;
    //                     $safarioperatorrequestpark->save(false);
    //                 }
    //             }

    //             $registration_model->safarioperator_request_model->is_approved = 1;
    //             if ($registration_model->safarioperator_request_model->save(false)) {
    //                 $safari_operator = $registration_model->safarioperator_request_model->safariapproved($registration_model->safarioperator_request_model);
    //                 if ($safari_operator) {
    //                     $user = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
    //                     $user->account_type = $registration_model->account_type;
    //                     $user->save(false);

    //                     /*Operator Register comment due to url*/
    //                     // $to_mail = Yii::$app->params['adminEmail'];
    //                     // $subject = 'New Operator Register | ' . substr($safari_operator->business_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
    //                     // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_OPERATOR_CREATED;
    //                     // $operator_url = Yii::$app->urlManager->createAbsoluteUrl(['/operator/default/sharedsafari', 'slug' => $safari_operator->slug]);
    //                     // $req = ['safari_operator' => $safari_operator->attributes, 'operator_url' => $operator_url];
    //                     // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //                     // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
    //                     //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
    //                     // }
    //                     $message = Yii::$app->api->messageManager->getMessage('common.registration_successful');
    //                     return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
    //                 }
    //             }
    //         }
    //     }
    // }


    /**
     * Post Privacy  
     *
     *
     * @OA\Post(
     *     path="/account/privacy",
     *     tags={"Account"},
     *     summary="Update privacy (NIU)",
     *     description="Allows update their privacy",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="gender_privacy",type="string",example=""),
     *                  @OA\Property(property="email_privacy",type="string",example="")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Privacy Updated successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Privacy Updated successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function actionPrivacy()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'Manage']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $model = new PrivacyForm($user_model);

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.updated', ['{var}' => 'Privacy']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed', ['{var}' => 'Privacy']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionDropdownoptions()
    {
        $return = [
            '1' => 'Public',
            '2' => 'Only me',
            '3' => 'My Follower',
        ];
        return $return;
    }


    // public function actionBlockedMember()
    // {
    //     return $this->render('index', [
    //         'model' => BlockedModel::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : NULL, 'status' => 1])->all(),
    //     ]);
    // }


    /**
     * Get Package wishlist
     *
     *
     * @OA\Get(
     *     path="/account/wishlist-package",
     *     tags={"Account"},
     *     summary="Get Package Wishlist",
     *     description="Returns paginated package wishlist that user has added to their wishlist.",
     *     security={{"bearerAuth": {}}},
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
     *@OA\Response(
     *     response=200,
     *     description="Package Wishlist list",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="packages",
     *             type="object",
     *             @OA\Property(
     *                 property="summary",
     *                 type="object",
     *                 ref="#/components/schemas/SummarySchema"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="package_display_name", type="string", example="Creeks & Crocodiles - Bhitarkanika National Park Odisha - Bhitarkanika"),
     *                     @OA\Property(property="package_name", type="string", example="Creeks & Crocodiles - Bhitarkanika National Park Odisha"),
     *                     @OA\Property(property="package_slug", type="string", example="creeks-crocodiles-bhitarkanika-national-park-odisha"),
     *                     @OA\Property(property="primary_park", type="string", example="Bhitarkanika National Park Odisha"),
     *                     @OA\Property(property="primary_park_slug", type="string", example="antara-park"),
     *                     @OA\Property(property="no_of_day", type="integer", example=3),
     *                     @OA\Property(property="no_of_night", type="integer", example=2),
     *                     @OA\Property(property="no_of_safari", type="integer", example=1),
     *                     @OA\Property(property="cost_per_person", type="integer", example=30000),
     *                     @OA\Property(property="cost_per_two_person", type="integer", example=50000),
     *                     @OA\Property(property="total_price", type="integer", example=30000),
     *                     @OA\Property(property="package_description", type="string", example="The Creeks & Crocodiles itinerary..."),
     *                     @OA\Property(property="image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/safaripark/277/logo1732599316.jpg"),
     *                     @OA\Property(property="image_banner_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/package/22/package_banner_image-1723825652.jpg"),
     *                     @OA\Property(property="package_day_night_labels", type="string", example="2 Nights, 3Days"),
     *                     @OA\Property(property="pick_and_drop", type="boolean", example=false),
     *                     @OA\Property(property="pick_and_drop_display", type="string", example="Not Included"),
     *                     @OA\Property(property="stay_category_display", type="string", example="Luxury"),
     *                     @OA\Property(property="meals_listing", type="string", example="Included"),
     *                     @OA\Property(property="lunch_included", type="boolean", example=true),
     *                     @OA\Property(property="dinner_included", type="boolean", example=true),
     *                     @OA\Property(property="meal_not_included", type="boolean", example=false),
     *                     @OA\Property(property="breakfast_included", type="boolean", example=true),
     *                     @OA\Property(property="start_location", type="string", example="Odisha"),
     *                     @OA\Property(property="end_location", type="string", example="Odisha"),
     *                     @OA\Property(property="start_date", type="string", nullable=true, example=null),
     *                     @OA\Property(property="end_date", type="string", nullable=true, example=null),
     *                     @OA\Property(property="status", type="integer", example=1),
     *                     @OA\Property(property="price_after_discount", type="integer", example=27000),
     *                     @OA\Property(
     *                         property="partner",
     *                         type="object",
     *                         @OA\Property(property="business_name", type="string", example="Shivsakti"),
     *                         @OA\Property(property="phone_no", type="string", example="8825317553"),
     *                         @OA\Property(property="email", type="string", example="annu@gmail.com"),
     *                         @OA\Property(property="operator_phone_no", type="string", example="9090909090"),
     *                         @OA\Property(property="operator_email", type="string", example="annu@gmail.com"),
     *                         @OA\Property(property="slug", type="string", example="shivsakti-94"),
     *                         @OA\Property(property="register_comapany_name", type="string", example="Shivsakti"),
     *                         @OA\Property(property="address", type="string", example="Noida sector 62"),
     *                         @OA\Property(property="google_rating", type="string", example="4.5"),
     *                         @OA\Property(property="google_review_count", type="integer", example=2),
     *                         @OA\Property(property="about_business", type="string", example="Just for testing."),
     *                         @OA\Property(property="image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/operator-registration/2025-07/9_logo_1751378227.jpeg"),
     *                         @OA\Property(property="park_count", type="integer", example=44),
     *                         @OA\Property(property="package_count", type="integer", example=18),
     *                         @OA\Property(property="shared_safari_count", type="integer", example=0),
     *                         @OA\Property(property="follower_list_count", type="integer", example=9),
     *                         @OA\Property(property="category_title", type="string", example="Safari Tour Operator"),
     *                         @OA\Property(property="is_followed", type="boolean", example=true),
     *                         @OA\Property(property="status", type="boolean", example=true),
     *                         @OA\Property(property="has_direct_call", type="boolean", example=true),
     *                         @OA\Property(property="direct_call_no", type="integer", example=7557178166),
     *                         @OA\Property(
     *                             property="review_url",
     *                             type="object",
     *                             @OA\Property(property="reviews", type="string", example="https://staging-api.walkintothewild.in/operator/eagle-safaris/reviewlist?sort_by=highest")
     *                         ),
     *                         @OA\Property(property="show_lead_phone_number", type="boolean", example=false)
     *                     ),
     *                     @OA\Property(property="is_wishlist", type="boolean", example=true),
     *                     @OA\Property(property="is_best_deal", type="integer", example=0),
     *                     @OA\Property(property="comment_count", type="integer", example=0),
     *                     @OA\Property(property="resource_uri", type="string", example="https://staging.d27737z6qvbtbo.amplifyapp.com/package/eagle-safaris-by-banzaara-3n-4d-stay-with-06-safaris-8f1846-31723645810-safari-package"),
     *                     @OA\Property(property="can_comment", type="boolean", example=true),
     *                     @OA\Property(property="can_reply", type="boolean", example=false),
     *                     @OA\Property(
     *                         property="urls",
     *                         type="object",
     *                         @OA\Property(property="comments", type="string", example="https://staging-api.walkintothewild.in/package/eagle-safaris-by-banzaara-3n-4d-stay-with-06-safaris-8f1846-31723645810-safari-package/comment-view")
     *                     ),
     *                     @OA\Property(property="custom_term_and_condition", type="string", example="<div><p>Terms...</p></div>"),
     *                     @OA\Property(property="template_code", type="integer", example=2),
     *                     @OA\Property(property="custom_activity_message", type="string", example="1 Shared Safari"),
     *                     @OA\Property(property="custom_price_message", type="string", example="Include taxes and fees"),
     *                     @OA\Property(property="cost_per_person_strike_off", type="integer", example=0),
     *                     @OA\Property(property="package_tag", type="string", nullable=true, example=null),
     *                     @OA\Property(property="package_tag_color", type="string", nullable=true, example=null),
     *                     @OA\Property(
     *                         property="image_thumbnails",
     *                         type="object",
     *                           @OA\Property(property="high", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/high/package_image-1732194969.png"),
     *                           @OA\Property(property="standard", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/original/package_image-1732194969.png"), 
     *                           @OA\Property(property="medium", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/medium/package_image-1732194969.png"),
     *                           @OA\Property(property="low", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/low/package_image-1732194969.png"),
     *                     ),
     *                    @OA\Property(
     *                         property="banner_thumbnails",
     *                         type="object",
     *                           @OA\Property(property="high", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/high/package_banner_image-1732194969.png"),
     *                           @OA\Property(property="standard", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/original/package_banner_image-1732194969.png"), 
     *                           @OA\Property(property="medium", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/medium/package_banner_image-1732194969.png"),
     *                           @OA\Property(property="low", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/low/package_banner_image-1732194969.png"),
     *                     ),
     *                 )
     *             )
     *         )
     *       )
     *     ),
     * )
     */
    public function actionWishlistPackage()
    {

        $wishlist_items = UserWishlist::find()->select('item_id')->where(['item_type_id' => UserWishlist::SAFARI_PACKAGE, 'status' => 1, 'user_id' => $this->userinfo ? $this->userinfoId : null])->all();
        $packageIds =  array_column($wishlist_items, 'item_id');

        $dataProvider = new ActiveDataProvider([
            'query' => Package::find()->where(['id' => $packageIds, 'status' => Package::STATUS_ACTIVE]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "packages");
    }

    /**
     * Renders the index view for the module
     * @return string
     */

    /**
     * Get Sharesafari wishlist
     *
     *
     * @OA\Get(
     *     path="/account/wishlist-shared-safari",
     *     tags={"Account"},
     *     summary="Get Shared Safari  Wishlist",
     *     description="Returns paginated shared safari wishlist that user has added to their wishlist.",
     *     security={{"bearerAuth": {}}},
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
     *     response=200,
     *     description="Share Safari List",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="share_safari",
     *             type="object",
     *             @OA\Property(
     *                 property="summary",
     *                 type="object",
     *                 @OA\Property(property="total", type="integer", example=5),
     *                 @OA\Property(property="page", type="integer", example=1),
     *                 @OA\Property(property="pageSize", type="integer", example=5),
     *                 @OA\Property(property="total_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="query_params",
     *                     type="array",
     *                     @OA\Items(type="string")
     *                 )
     *             ),
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="share_safari_title", type="string", example="New Test Safari"),
     *                     @OA\Property(property="slug", type="string", example="new-test-safari-1"),
     *                     @OA\Property(property="no_of_safari", type="integer", example=2),
     *                     @OA\Property(property="start_date", type="string", format="date", example="2025-11-29"),
     *                     @OA\Property(property="end_date", type="string", format="date", example="2025-11-30"),
     *                     @OA\Property(property="cut_off_date", type="string", format="date", example="2025-11-14"),
     *                     @OA\Property(property="cost_per_person", type="integer", example=2000),
     *                     @OA\Property(property="estimate_price_min", type="integer", example=0),
     *                     @OA\Property(property="estimate_price_max", type="integer", example=0),
     *                     @OA\Property(property="types", type="string", example="Fixed Departure"),
     *                     @OA\Property(property="organized_by_name", type="string", example="Safari Planners"),
     *                     @OA\Property(property="organized_by_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/operator-registration/2511/938_logo_1763122678.jpeg"),
     *                     @OA\Property(property="organized_slug", type="string", example="safari-planners"),
     *                     @OA\Property(property="shared_image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/fixed_departure/2511/1_fixed_departure_image_1763011409.jpeg"),
     *                     @OA\Property(property="seat_full_status", type="boolean", example=false),
     *                     @OA\Property(property="park_title", type="string", example="Bandhavgarh Tiger Reserve"),
     *                     @OA\Property(property="park_slug", type="string", example="bandhavgarh-tiger-reserve"),
     *                     @OA\Property(property="have_you_joined", type="boolean", example=false),
     *                     @OA\Property(property="is_wishlist", type="boolean", example=true),
     *                     @OA\Property(property="is_followed", type="boolean", example=false),
     *                     @OA\Property(property="interseted_user_count", type="integer", example=0),
     *                     @OA\Property(property="resource_uri", type="string", example="https://staging.d27737z6qvbtbo.amplifyapp.com/sharedsafari/new-test-safari-1"),
     *                     @OA\Property(property="can_comment", type="boolean", example=false),
     *                     @OA\Property(property="can_reply", type="boolean", example=false),
     *                     @OA\Property(property="total_seat", type="integer", example=4),
     *                     @OA\Property(property="share_seat", type="integer", example=1),
     *                     @OA\Property(
     *                         property="partner",
     *                         type="object",
     *                         @OA\Property(property="business_name", type="string", example="Safari Planners"),
     *                         @OA\Property(property="phone_no", type="string", example="8960874641"),
     *                         @OA\Property(property="email", type="string", example="abhinav@gmail.com"),
     *                         @OA\Property(property="operator_phone_no", type="string", example="8960874641"),
     *                         @OA\Property(property="operator_email", type="string", example="abhinav@gmail.com"),
     *                         @OA\Property(property="slug", type="string", example="safari-planners"),
     *                         @OA\Property(property="register_comapany_name", type="string", example="Safari Planners"),
     *                         @OA\Property(property="address", type="string", example="Noida Sector 62"),
     *                         @OA\Property(property="google_rating", type="string", example="0"),
     *                         @OA\Property(property="google_review_count", type="integer", example=0),
     *                         @OA\Property(property="about_business", type="string", example="NEW SAFARI PLANNERS"),
     *                         @OA\Property(property="image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/operator-registration/2511/938_logo_1763122678.jpeg"),
     *                         @OA\Property(property="park_count", type="integer", example=3),
     *                         @OA\Property(property="package_count", type="integer", example=1),
     *                         @OA\Property(property="shared_safari_count", type="integer", example=1),
     *                         @OA\Property(property="follower_list_count", type="integer", example=3),
     *                         @OA\Property(property="category_title", type="string", example="Safari Tour Operator"),
     *                         @OA\Property(property="is_followed", type="boolean", example=false),
     *                         @OA\Property(property="status", type="boolean", example=true),
     *                         @OA\Property(property="has_direct_call", type="boolean", example=false),
     *                         @OA\Property(property="direct_call_no", type="string", nullable=true, example=null),
     *                         @OA\Property(
     *                             property="review_url",
     *                             type="object",
     *                             @OA\Property(property="reviews", type="string", example="https://staging-api.walkintothewild.in/operator/safari-planners/reviewlist?sort_by=highest")
     *                         ),
     *                         @OA\Property(property="show_lead_phone_number", type="boolean", example=false)
     *                     ),
     *
     *                     @OA\Property(
     *                         property="interested_users",
     *                         type="array",
     *                         @OA\Items(type="object")
     *                     ),
     *
     *                     @OA\Property(property="safari_plan", type="string", example="Safari Plan Description here"),
     *
     *                     @OA\Property(
     *                         property="urls",
     *                         type="object",
     *                         @OA\Property(property="intrested_users", type="string", example="https://staging-api.walkintothewild.in/sharesafari/new-test-safari-1/intrested-user"),
     *                         @OA\Property(property="comments", type="string", example="https://staging-api.walkintothewild.in/sharesafari/new-test-safari-1/comment-view")
     *                     ),
     *
     *                     @OA\Property(property="comments_count", type="integer", example=0),
     *                     @OA\Property(property="witw_average_rating", type="integer", example=0),
     *                     @OA\Property(property="witw_review_count", type="integer", example=0),
     *                     @OA\Property(property="is_safari_operator", type="boolean", example=true),
     *                     @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *                     @OA\Property(property="status", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     )
     * )
     * )
     */
    public function actionWishlistSharedSafari()
    {

        $wishlist_items = UserWishlist::find()->where(['item_type_id' => UserWishlist::SHARED_SAFARI, 'status' => 1, 'user_id' => $this->userinfo ? $this->userinfoId : null])->all();

        $saafariIds =  array_column($wishlist_items, 'item_id');

        $dataProvider = new ActiveDataProvider([
            'query' => ShareSafari::find()->where(['id' => $saafariIds]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "share_safari");
    }


    /**
     * Post Delete User Profile
     *
     * @OA\Post(
     *     path="/account/profile-delete",
     *     tags={"Account"},
     *     summary="Delete the user profile",
     *     description="Allows the user to delete their profile from the Walk Into The Wild platform.",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Profile deleted successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Profile deleted successfully!")
     *         )
     *     ),
     * )
     */


    public function actionProfileDelete()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'Manage']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $model = User::find()->where(['id' => $user_model->id])->limit(1)->one();
        $model->status = User::STATUS_DELETED;

        if ($model->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.deleted', ['{var}' => 'Profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.delete_failed', ['{var}' => 'Profile']);
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }



    /**
     * Post Privacy Policy Acknowledgement
     *
     *
     * @OA\Post(
     *     path="/account/privacy-policy-acknowledge",
     *     tags={"Account"},
     *     summary="Update privacy policy acknowledgement",
     *     description="update status true if privacy policy acknowledged ",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Privacy acknowledged successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Success!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User Not Found")
     *         )
     *     )
     * )
     */

    public function actionPrivacyPolicyAcknowledge()
    {
        $user_model = $this->userinfo;
        $document = ComplianceDocuments::find()->where(['type' => ComplianceDocuments::PRIVACY_POLICY, 'status' => 1])->one();
        $data_exists = UserPrivacyPolicyAcknowledgement::find()->where(['user_id' => $user_model->id, 'document_id' => $document->id, 'document_version' => $document->version])->one();

        if ($data_exists) {
            $message = Yii::$app->api->messageManager->getMessage('common.already_acknowledged');
            return Yii::$app->api->sendResponse(['message' => $message]);
        }

        $user_acknowledgement = new UserPrivacyPolicyAcknowledgement();
        $user_acknowledgement->user_id = $user_model->id;
        $user_acknowledgement->document_id = $document->id;
        $user_acknowledgement->document_version = $document->version;

        if ($user_acknowledgement->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.success');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        $message = Yii::$app->api->messageManager->getMessage('common.set_failed', ['{var}' => 'Acknowledged']);
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }
}
