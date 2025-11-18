<?php

namespace api\modules\profile\controllers;

use Yii;
use api\behaviours\Verbcheck;
use yii\filters\AccessControl;
use api\behaviours\Apiauth;
use api\controllers\RestController;
use api\models\feeds\Feeds;
use api\models\feeds\FeedsSearch;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariIntrested;
use api\models\User;
use api\models\UserFollow;
use common\Helper\FirebaseNotificationHelper;
use common\Helper\FrontendNotificationHelper;
use common\models\GeneralModel;
use common\models\MailLog;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * Default controller
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
                'exclude' => ['index', 'organizedby', 'joinedby', 'useractivity', 'followers-list', 'followings-list'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['follow', 'unfollow'],
                'rules' => [
                    [
                        'actions' => ['follow', 'unfollow'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'follow' => ['POST'],
                    'unfollow' => ['POST'],
                    'organizedby' => ['GET'],
                    'useractivity' => ['GET'],
                    'followers-list' => ['GET'],
                    'followings-list' => ['GET'],
                ],
            ],
        ];
    }


    // public function actionIndex($user_handle)
    // {
    //     $this->layout = \common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL;
    //     $user = $this->findUser($user_handle);
    //     if ($user->partner) {
    //         return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sent to Operator Profile"]);
    //     }

    //     return Yii::$app->api->sendResponse($data = $user);
    // }

    /**
     * Get User Details
     *
     * @OA\Get(
     *     path="/user-profile",
     *     tags={"Profile"},
     *     summary="User Profile",
     *     description="The <b>User Profile</b> API provides detailed information about a user in the Walk Into Wild application.<br>
     *         It allows clients to fetch user details using the <b>user_handle</b> parameter.<br>
     *         This API can be used to display user profiles, check account status, and retrieve related user statistics like followers, followings, and safari counts.",
     *
     *     @OA\Parameter(
     *         name="user_handle",
     *         in="query",
     *         required=true,
     *         description="User handle to fetch the profile",
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful Response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="username", type="string", example="ibaibhavsingh@gmail.com"),
     *             @OA\Property(property="name", type="string", example="Baibhav"),
     *             @OA\Property(property="mobile_no", type="string", example="9540716069"),
     *             @OA\Property(property="is_mobile_no_verified", type="boolean", example=true),
     *             @OA\Property(property="mobile_no_verified_at", type="integer", example=1753853211),
     *             @OA\Property(property="email", type="string", example="ibaibhavsingh@gmail.com"),
     *             @OA\Property(property="is_support_user", type="integer", example=0),
     *             @OA\Property(property="is_safari_operator", type="boolean", example=false),
     *             @OA\Property(property="is_account_manager", type="integer", example=0),
     *             @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *             @OA\Property(property="is_developer", type="integer", example=0),
     *             @OA\Property(property="google_avatar_image", type="string", example="2389_google_avatar.jpg"),
     *             @OA\Property(property="user_handle", type="string", example="baibhav"),
     *             @OA\Property(property="facebook_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="whatsapp_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="x_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="insta_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="website_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="youtube_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="about", type="string", nullable=true, example="About me"),
     *             @OA\Property(property="user_bio", type="string", nullable=true, example="User Bio"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", nullable=true, example="1995-08-15"),
     *             @OA\Property(property="gender", type="integer", example=1),
     *             @OA\Property(property="account_type", type="integer", example=1),
     *             @OA\Property(property="gender_privacy", type="integer", example=1),
     *             @OA\Property(property="email_privacy", type="integer", example=1),
     *             @OA\Property(property="user_flaged", type="string", nullable=true, example=null),
     *             @OA\Property(property="pop_up_message", type="string", example="Pop up message"),
     *             @OA\Property(property="status", type="integer", example=10),
     *             @OA\Property(property="profile_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/2389_google_avatar.jpg"),
     *             @OA\Property(property="cover_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/2389_google_avatar.jpg"),
     *             @OA\Property(property="display_name", type="string", example="Baibhav"),
     *             @OA\Property(property="is_followed", type="boolean", example=false),
     *             @OA\Property(property="user_activity_count", type="integer", example=2),
     *             @OA\Property(property="operator_slug", type="string", example=""),
     *             @OA\Property(property="user_followers_count", type="integer", example=0),
     *             @OA\Property(property="user_followings_count", type="integer", example=2),
     *             @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=true),
     *             @OA\Property(property="organized_safari_count", type="integer", example=0),
     *             @OA\Property(property="joined_safari_count", type="integer", example=6),
     *             @OA\Property(
     *                 property="park_visited",
     *                 type="array",
     *                 @OA\Items(type="string"),
     *                 example={}
     *             ),
     *
     *             @OA\Property(
     *                 property="operator_type",
     *                 type="object",
     *                 @OA\Property(property="status", type="integer", example=0)
     *             ),
     *
     *             @OA\Property(property="operator_status", type="integer", example=0),
     *
     *             @OA\Property(
     *                 property="urls",
     *                 type="object",
     *                 @OA\Property(property="followers_list", type="string", example="https://staging-api.walkintothewild.in/profile/baibhav/followers-list"),
     *                 @OA\Property(property="followings_list", type="string", example="https://staging-api.walkintothewild.in/profile/baibhav/followings-list")
     *             ),
     *
     *             @OA\Property(property="is_mobile_verification_mandatory", type="boolean", example=false)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="User Not Found or User Account may be Blocked!"),
     *             @OA\Property(property="code", type="integer", example=0)
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: user_handle"),
     *             @OA\Property(property="code", type="integer", example=0)
     *         )
     *    ),
     * )
     */
    public function actionIndex($user_handle)
    {
        $this->layout = \common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL;
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        return Yii::$app->api->sendResponse($data =  $user->toArray());
    }

    /**
     * Get Organized By Share Safari
     *
     * @OA\Get(
     *     path="/organizedby",
     *     tags={"Profile"},
     *     summary="Get Organized By Share Safari",
     *     description="The <b>Organized By Share Safari</b> API provides a list of share safaris organized by a specific user in the Walk Into Wild application.<br>
     *         It allows clients to fetch share safari details using the <b>user_handle</b> parameter.<br>
     *         This API can be used to display the share safaris organized by a user, including details such as safari title, dates, costs, and interested users.",
     *     @OA\Parameter(
     *         name="user_handle",
     *         in="query",
     *         required=true,
     *         description="User handle to query",
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Organized Share Safari List",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="share_safari",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="share_safari_title", type="string", example="Catamaran"),
     *                     @OA\Property(property="slug", type="string", example="bhitarkanika-by-catamaran"),
     *                     @OA\Property(property="no_of_safari", type="integer", example=1),
     *                     @OA\Property(property="start_date", type="string", format="date", example="2026-01-23"),
     *                     @OA\Property(property="end_date", type="string", format="date", example="2026-01-26"),
     *                     @OA\Property(property="cut_off_date", type="string", nullable=true, example=null),
     *                     @OA\Property(property="cost_per_person", type="number", example=0),
     *                     @OA\Property(property="estimate_price_min", type="number", example=28000),
     *                     @OA\Property(property="estimate_price_max", type="number", example=100000),
     *                     @OA\Property(property="types", type="string", example="Share Safari"),
     *                     @OA\Property(property="organized_by_name", type="string", example="Vivek Bharti"),
     *                     @OA\Property(property="organized_by_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/2390_profile_1762259111.jpg"),
     *                     @OA\Property(property="organized_slug", type="string", example="vivek-bharti_2"),
     *                     @OA\Property(property="shared_image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/share_safari/2510/323_1759905900.jpg"),
     *                     @OA\Property(property="seat_full_status", type="boolean", example=false),
     *                     @OA\Property(property="park_title", type="string", example="Dudhwa Tiger Reserve"),
     *                     @OA\Property(property="park_slug", type="string", example="dudhwa-tiger-reserve"),
     *                     @OA\Property(property="have_you_joined", type="boolean", example=false),
     *                     @OA\Property(property="is_wishlist", type="boolean", example=false),
     *                     @OA\Property(property="is_followed", type="boolean", example=false),
     *                     @OA\Property(property="interseted_user_count", type="integer", example=3),
     *                     @OA\Property(property="resource_uri", type="string", example="https://staging.../sharedsafari/bhitarkanika-by-catamaran"),
     *                     @OA\Property(property="can_comment", type="boolean", example=true),
     *                     @OA\Property(property="can_reply", type="boolean", example=true),
     *                     @OA\Property(property="total_seat", type="integer", example=4),
     *                     @OA\Property(property="share_seat", type="integer", example=3),
     *                     @OA\Property(property="partner", type="string", nullable=true, example=null),
     *
     *                     @OA\Property(
     *                         property="interested_users",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="username", type="string", example="aayushsaini9999@gmail.com"),
     *                             @OA\Property(property="name", type="string", example="Aayush Saini"),
     *                             @OA\Property(property="email", type="string", example="aayushsaini9999@gmail.com"),
     *                             @OA\Property(property="is_support_user", type="integer", example=1),
     *                             @OA\Property(property="is_safari_operator", type="boolean", example=false),
     *                             @OA\Property(property="is_account_manager", type="integer", example=1),
     *                             @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *                             @OA\Property(property="is_developer", type="integer", example=1),
     *                             @OA\Property(property="google_avatar_image", type="string", example="32_google_avatar.jpg"),
     *                             @OA\Property(property="user_handle", type="string", example="aayushsaini"),
     *                             @OA\Property(property="gender", type="string", nullable=true, example=null),
     *                             @OA\Property(property="account_type", type="integer", example=1),
     *                             @OA\Property(property="gender_privacy", type="integer", example=1),
     *                             @OA\Property(property="email_privacy", type="integer", example=1),
     *                             @OA\Property(property="status", type="integer", example=10),
     *                             @OA\Property(property="profile_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/32_profile_1748334745.jpg"),
     *                             @OA\Property(property="cover_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/32_cover_1748334732.jpg"),
     *                             @OA\Property(property="display_name", type="string", example="Aayush Saini"),
     *                             @OA\Property(property="is_followed", type="boolean", example=false),
     *                             @OA\Property(property="user_activity_count", type="integer", example=4),
     *                             @OA\Property(property="operator_slug", type="string", example=""),
     *                             @OA\Property(property="user_followers_count", type="integer", example=3),
     *                             @OA\Property(property="user_followings_count", type="integer", example=2),
     *                             @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=false),
     *                             @OA\Property(property="joined_at", type="integer", example=1762144211)
     *                         )
     *                     ),
     *
     *                     @OA\Property(property="safari_plan", type="string", example="hfui"),
     *
     *                     @OA\Property(
     *                         property="urls",
     *                         type="object",
     *                         @OA\Property(property="intrested_users", type="string", example="https://staging-api.walkintothewild.in/.../intrested-user"),
     *                         @OA\Property(property="comments", type="string", example="https://staging-api.walkintothewild.in/.../comment-view")
     *                     ),
     *
     *                     @OA\Property(property="comments_count", type="integer", example=12),
     *                     @OA\Property(property="witw_average_rating", type="integer", example=0),
     *                     @OA\Property(property="witw_review_count", type="integer", example=0),
     *                     @OA\Property(property="is_safari_operator", type="boolean", example=false),
     *                     @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *                     @OA\Property(property="status", type="integer", example=0)
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="User Not Found or User Account may be Blocked!"),
     *             @OA\Property(property="code", type="integer", example=0)
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: user_handle"),
     *             @OA\Property(property="code", type="integer", example=0)
     *         )
     *    ),
     * )
     */
    public function actionOrganizedby($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($user->id == $this->userinfoId) {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT, ShareSafari::STATUS_SUSPEND]])->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($organized_by)]);
        } else {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($organized_by)]);
        }
    }

    /**
     * 
     * Get Joined By Share Safari
     *
     *
     * @OA\Get(
     *     path="/joinedby",
     *     tags={"Profile"},
     *     summary="Get Joined Share Safari",
     *     description="The <b>Joined Share Safari</b> API provides a list of share safaris that a specific user has joined in the Walk Into Wild application.<br>
     *        It allows clients to fetch share safari details using the <b>user_handle</b> parameter.<br>
     *        This API can be used to display the share safaris a user has joined, including details such as safari title, dates, costs, and interested users.",
     *      @OA\Parameter(
     *         name="user_handle",
     *         in="query",
     *         required=true,
     *         description="user_handle to query ",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Joined Share Safari List",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="share_safari",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="share_safari_title", type="string", example="Catamaran"),
     *                     @OA\Property(property="slug", type="string", example="bhitarkanika-by-catamaran"),
     *                     @OA\Property(property="no_of_safari", type="integer", example=1),
     *                     @OA\Property(property="start_date", type="string", format="date", example="2026-01-23"),
     *                     @OA\Property(property="end_date", type="string", format="date", example="2026-01-26"),
     *                     @OA\Property(property="cut_off_date", type="string", nullable=true, example=null),
     *                     @OA\Property(property="cost_per_person", type="number", example=0),
     *                     @OA\Property(property="estimate_price_min", type="number", example=28000),
     *                     @OA\Property(property="estimate_price_max", type="number", example=100000),
     *                     @OA\Property(property="types", type="string", example="Share Safari"),
     *                     @OA\Property(property="organized_by_name", type="string", example="Vivek Bharti"),
     *                     @OA\Property(property="organized_by_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/2390_profile_1762259111.jpg"),
     *                     @OA\Property(property="organized_slug", type="string", example="vivek-bharti_2"),
     *                     @OA\Property(property="shared_image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/share_safari/2510/323_1759905900.jpg"),
     *                     @OA\Property(property="seat_full_status", type="boolean", example=false),
     *                     @OA\Property(property="park_title", type="string", example="Dudhwa Tiger Reserve"),
     *                     @OA\Property(property="park_slug", type="string", example="dudhwa-tiger-reserve"),
     *                     @OA\Property(property="have_you_joined", type="boolean", example=false),
     *                     @OA\Property(property="is_wishlist", type="boolean", example=false),
     *                     @OA\Property(property="is_followed", type="boolean", example=false),
     *                     @OA\Property(property="interseted_user_count", type="integer", example=3),
     *                     @OA\Property(property="resource_uri", type="string", example="https://staging.../sharedsafari/bhitarkanika-by-catamaran"),
     *                     @OA\Property(property="can_comment", type="boolean", example=true),
     *                     @OA\Property(property="can_reply", type="boolean", example=true),
     *                     @OA\Property(property="total_seat", type="integer", example=4),
     *                     @OA\Property(property="share_seat", type="integer", example=3),
     *                     @OA\Property(property="partner", type="string", nullable=true, example=null),
     *
     *                     @OA\Property(
     *                         property="interested_users",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="username", type="string", example="aayushsaini9999@gmail.com"),
     *                             @OA\Property(property="name", type="string", example="Aayush Saini"),
     *                             @OA\Property(property="email", type="string", example="aayushsaini9999@gmail.com"),
     *                             @OA\Property(property="is_support_user", type="integer", example=1),
     *                             @OA\Property(property="is_safari_operator", type="boolean", example=false),
     *                             @OA\Property(property="is_account_manager", type="integer", example=1),
     *                             @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *                             @OA\Property(property="is_developer", type="integer", example=1),
     *                             @OA\Property(property="google_avatar_image", type="string", example="32_google_avatar.jpg"),
     *                             @OA\Property(property="user_handle", type="string", example="aayushsaini"),
     *                             @OA\Property(property="gender", type="string", nullable=true, example=null),
     *                             @OA\Property(property="account_type", type="integer", example=1),
     *                             @OA\Property(property="gender_privacy", type="integer", example=1),
     *                             @OA\Property(property="email_privacy", type="integer", example=1),
     *                             @OA\Property(property="status", type="integer", example=10),
     *                             @OA\Property(property="profile_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/32_profile_1748334745.jpg"),
     *                             @OA\Property(property="cover_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/32_cover_1748334732.jpg"),
     *                             @OA\Property(property="display_name", type="string", example="Aayush Saini"),
     *                             @OA\Property(property="is_followed", type="boolean", example=false),
     *                             @OA\Property(property="user_activity_count", type="integer", example=4),
     *                             @OA\Property(property="operator_slug", type="string", example=""),
     *                             @OA\Property(property="user_followers_count", type="integer", example=3),
     *                             @OA\Property(property="user_followings_count", type="integer", example=2),
     *                             @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=false),
     *                             @OA\Property(property="joined_at", type="integer", example=1762144211)
     *                         )
     *                     ),
     *
     *                     @OA\Property(property="safari_plan", type="string", example="hfui"),
     *
     *                     @OA\Property(
     *                         property="urls",
     *                         type="object",
     *                         @OA\Property(property="intrested_users", type="string", example="https://staging-api.walkintothewild.in/.../intrested-user"),
     *                         @OA\Property(property="comments", type="string", example="https://staging-api.walkintothewild.in/.../comment-view")
     *                     ),
     *
     *                     @OA\Property(property="comments_count", type="integer", example=12),
     *                     @OA\Property(property="witw_average_rating", type="integer", example=0),
     *                     @OA\Property(property="witw_review_count", type="integer", example=0),
     *                     @OA\Property(property="is_safari_operator", type="boolean", example=false),
     *                     @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *                     @OA\Property(property="status", type="integer", example=0)
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="User Not Found or User Account may be Blocked!"),
     *             @OA\Property(property="code", type="integer", example=0)
     *         )
     *    ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="Missing required parameters: user_handle"),
     *             @OA\Property(property="code", type="integer", example=0)
     *         )
     *    ),
     * )
     */
    public function actionJoinedby($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($user->id == $this->userinfoId) {
            $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id, 'status' => ShareSafariIntrested::STATUS_ACTIVE])->all();
            $safariIds = array_map(function ($item) {
                return $item->share_safari_id;
            }, $joined_by);
            $shared_safari = ShareSafari::find()
                ->where(['id' => $safariIds])
                ->andWhere(['>=', 'start_date', date("Y-m-d")])
                ->andWhere(['share_safari.status' => ShareSafari::STATUS_ACTIVE])
                ->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($shared_safari)]);
        } else {
            $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id, 'status' => ShareSafariIntrested::STATUS_ACTIVE])->all();
            $safariIds = array_map(function ($item) {
                return $item->share_safari_id;
            }, $joined_by);
            $shared_safari = ShareSafari::find()
                ->where(['id' => $safariIds])
                ->andWhere(['>=', 'start_date', date("Y-m-d")])
                ->andWhere(['share_safari.status' => ShareSafari::STATUS_ACTIVE])
                ->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($shared_safari)]);
        }
    }

    public function actionFollow($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($this->userinfo) {
            if ($this->userinfoId == $user->id) {
                $message = Yii::$app->api->messageManager->getMessage('common.follow_restricted', ['{var}' => 'yourself']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
            $follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $user->id])->limit(1)->one();
            if (!$follower) {
                $follower = new UserFollow();
            }
            $follower->user_id = $this->userinfoId;
            $follower->follow_user_id = $user->id;
            $follower->status = 1;
            $follower->save(false);

            // $to_mail = $user->username;
            // $following_name = $this->userinfo->name;
            // $subject = 'New Follower';
            // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_FOLLOWER_BY_ANY_USER;
            // $follower_url = Yii::$app->urlManager->createAbsoluteUrl(['/profile/default/follower', 'user_handle' => $user->user_handle]);
            // $req = ['following_name' => $following_name, 'follower_url' => $follower_url];
            // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
            //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
            // }
            // FrontendNotificationHelper::userNewFollower($user, $this->userinfo);
            // FirebaseNotificationHelper::profilefollowing($user, $this->userinfo);
            $message = Yii::$app->api->messageManager->getMessage('common.follow_success');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.follow_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    public function actionUnfollow($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($this->userinfo) {
            $my_follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $user->id])->limit(1)->one();
            if ($my_follower) {
                $my_follower->user_id = $this->userinfoId;
                $my_follower->follow_user_id = $user->id;
                $my_follower->status = 0;
                if ($my_follower->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.unfollow_success');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.unfollow_failed');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_logged_in');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    public function findUserbyHandle($user_handle)
    {
        if ($user = User::find()->where(['user_handle' => $user_handle])->andWhere(['blocked_at' => null, 'status' => User::STATUS_ACTIVE])->limit(1)->one()) {
            return $user;
        }
        $message = Yii::$app->api->messageManager->getMessage('common.user_not_accessible');
        throw new ForbiddenHttpException($message);
    }

    public function findUser($user_handle)
    {
        if ($user = User::find()->where(['user_handle' => $user_handle])->limit(1)->one()) {
            return $user;
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_found');
        throw new ForbiddenHttpException($message);
    }

    /**
     * 
     * Get User Activity
     *
     *
     * @OA\Get(
     *     path="/useractivity",
     *     tags={"Profile"},
     *     summary="Get User Activity (NIU)",
     *      @OA\Parameter(
     *         name="user_handle",
     *         in="query",
     *         required=true,
     *         description="user_handle to query ",
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
    public function actionUseractivity($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        // if ($user->partner) {
        //     return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sent to Operator Profile"]);
        // }
        if ($user) {
            $searchModel = new FeedsSearch();
            $searchModel->created_by = $user->id;
            $searchModel->status = Feeds::STATUS_ACTIVE;
            return $this->dataProviderSender($searchModel, $rootIndexName = "user_activity");
        }
    }


    // public function actionFollowersList($user_handle)
    // {
    //     $this->layout = \common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL;
    //     $user = $this->findUserbyHandle($user_handle);
    //     if ($user->partner) {
    //         return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sent to Operator Profile"]);
    //     }

    //     $followers_list = UserFollow::find()->where(['follow_user_id' => $user->id])->joinWith('user')->andWhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->all();

    //     $ids = array_column($followers_list, 'id');

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => User::find()->where(['id' => $ids]),
    //         // 'pagination' => false,
    //     ]);

    //     return $this->querySender($dataProvider, $rootIndexName = "user_follower_list");
    // }

    public function actionFollowingsList($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        $following_list = UserFollow::find()->where(['user_id' => $user->id])->joinWith('follower')->andWhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);

        // $ids = array_column($followers_list, 'follow_user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $following_list,
        ]);

        return $this->querySender($dataProvider, $rootIndexName = "user_follower_list");
    }

    public function actionFollowersList($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        $followers_list = UserFollow::find()->where(['follow_user_id' => $user->id])->joinWith('user')->andWhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);

        // $ids = array_column($following_list, 'user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $followers_list,
        ]);

        return $this->querySender($dataProvider, $rootIndexName = "user_following_list");
    }
}
