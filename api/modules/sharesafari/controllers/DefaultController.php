<?php

namespace api\modules\sharesafari\controllers;

use Yii;

use api\behaviours\Verbcheck;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;
use common\Helper\FrontendNotificationHelper;
use common\models\GeneralModel;
use common\models\MailLog;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafariParklist;
use frontend\models\form\CreateDepartureForm;
use frontend\models\form\SharedSafariForm;
use yii\filters\AccessControl;
use api\behaviours\Apiauth;
use api\models\sharesafari\ShareSafariComment;
use common\models\firebasenotification\FirebaseNotificationLog;
// use api\models\UserWishlist;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;
use frontend\models\ReplyForm;
use frontend\models\ShareSafariCommentForm;
use frontend\models\ShareSafariCommentReportForm;

/**
 * Site controller
 */
class DefaultController extends SafariController
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
                'exclude' => ['index', 'view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['organize-safari', 'join', 'unjoin', 'wishlist', 'unwishlist', 'comment'],
                'rules' => [
                    [
                        'actions' => ['organize-safari', 'comment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['unjoin', 'join'],
                        'allow' => $this->isSafariHost(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['wishlist', 'unwishlist'],
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
                    'organize-safari' => ['POST'],
                    'join' => ['POST'],
                    'unjoin' => ['POST'],
                    'wishlist' => ['POST'],
                    'unwishlist' => ['POST'],

                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        return $this->dataProviderSender($searchModel, $rootIndexName = "Share Safari");
    }


    public function actionView($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        $searchModel = new ShareSafariSearch();
        $searchModel->id = $share_safari->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    }

    public function actionOrganizeSafari()
    {
        $model = new SharedSafariForm();
        $model->host_user_id = $this->userinfoId;
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->type = ShareSafari::TYPE_SAFARI;
        $model->host_type = 1;

        $login_user = $this->userinfo;
        if ($login_user = $this->userinfo) {
            if ($login_user->x_url <> '') {
                $model->website_url = $login_user->x_url;
            }
            if ($login_user->insta_url <> '') {
                $model->website_url = $login_user->insta_url;
            }
            if ($login_user->facebook_url <> '') {
                $model->website_url = $login_user->facebook_url;
            }
        }

        $model->attributes = $this->request;
        $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_model->save()) {
                $model->UploadFiles($model->shared_safari_model->id);
                if ($model->shared_safari_model->user) {
                    $user = $model->shared_safari_model->user;
                    $username = $user->name;
                    $to_mail = Yii::$app->params['adminEmail'];
                    $subject = 'New Shared Safari | ' . substr($model->shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_CREATEDBY_USER;
                    $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_model->slug, 'organized_slug' => $model->shared_safari_model->organizedslug ?: '']);

                    $req = ['shared_safari' => $model->shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                    $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                    if (!empty($maillog_data['log_id'])) {
                        GeneralModel::sendmailfromlog($maillog_data['log_id']);
                    }
                }
                return Yii::$app->api->sendResponse($data = [$model->shared_safari_model->attributes], ['message' => "Shared safari created successfully"]);
            }
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionJoin($slug)
    {
        $share_safari = $this->sharesafari;
        if ($share_safari) {
            if ($this->userinfo) {
                if ($this->userinfo->operator) {
                    return Yii::$app->api->sendResponse($data = [], ['message' => "Only individual users are allowed to join a shared safari. Tour operators cannot participate in shared safaris."]);
                }
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
                if (!$share_safari_intrested) {
                    $share_safari_intrested = new ShareSafariIntrested();
                }
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent(Yii::$app->request->userAgent);
                $share_safari_intrested->user_ip_address = Yii::$app->getRequest()->getUserIp();
                $share_safari_intrested->user_agent =  Yii::$app->request->userAgent;
                $share_safari_intrested->user_device  = $agent->device();
                $share_safari_intrested->user_platform = $agent->platform();
                $share_safari_intrested->user_browser = $agent->browser();
                $share_safari_intrested->park_id = $share_safari->park_id;
                $share_safari_intrested->share_safari_id = $share_safari->id;
                $share_safari_intrested->user_id = $this->userinfoId;
                $share_safari_intrested->status = 1;
                $share_safari_intrested->intrested_at = time();
                if ($share_safari_intrested->save(false)) {
                    /**Firebase Notification start */
                    $user_ids = $share_safari->getIntrested()->joinWith('user')->where(['user.status' => 10, 'share_safari_intrested.status' => 1])->select('user_id')->column();
                    $title = 'Join Safari';
                    $message = 'You Join Safari';
                    $sent_data = 'Share Safari';
                    FirebaseNotificationLog::setActivity($title, $message, $user_ids, $sent_data);
                    /**Firebase Notification end */
                    FrontendNotificationHelper::sharedSafariJoin($share_safari, $this->userinfo);
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You joined this shared safari!"]);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not Joined!"]);
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }


    public function actionUnjoin($slug)
    {
        $share_safari = $this->sharesafari;
        if ($share_safari) {
            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
            if ($share_safari_intrested) {
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent(Yii::$app->request->userAgent);
                $share_safari_intrested->user_ip_address = Yii::$app->getRequest()->getUserIp();
                $share_safari_intrested->user_agent =  Yii::$app->request->userAgent;
                $share_safari_intrested->user_device  = $agent->device();
                $share_safari_intrested->user_platform = $agent->platform();
                $share_safari_intrested->user_browser = $agent->browser();
                $share_safari_intrested->park_id = $share_safari->park_id;
                $share_safari_intrested->share_safari_id = $share_safari->id;
                $share_safari_intrested->user_id = Yii::$app->user->identity->id;
                $share_safari_intrested->status = 0; //UNfollow
                $share_safari_intrested->unintrested_at = time();
                if ($share_safari_intrested->save(false)) {
                    FrontendNotificationHelper::sharedSafariLeave($share_safari, $this->userinfo);
                    return   Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You unjoined this shared safari!"]);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not unjoined!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }


    public function actionWishlist($slug)
    {

        $share_safari = $this->sharesafari;
        if ($share_safari) {
            $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI])->one();
            if (!$wishlist) {
                $wishlist = new UserWishlist();
            }
            $wishlist->user_id = $this->userinfoId;
            $wishlist->item_id = $share_safari->id;
            $wishlist->item_type_id = UserWishlist::SHARED_SAFARI;
            $wishlist->item_type = 'share-safari';
            $wishlist->status = 1;
            if ($wishlist->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You added share safari to wishlist!"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not added share safari to wishlist!"]);
        }
        return Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }

    public function actionUnwishlist($slug)
    {
        $share_safari = $this->sharesafari;
        if ($share_safari) {
            $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI])->one();
            if ($wishlist) {
                $wishlist->status = 0;
                if ($wishlist->save(false)) {
                    return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You removed share safari from wishlist!"]);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not removed share safari from wishlist!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }


    // public function actionCreateFixedDeparture()
    // {
    //     $safari_operator = SafariOperator::find()->where(['user_id' => $this->userinfoId])->limit(1)->one();
    //     if(!$safari_operator)
    //     {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "You are not operator."]);
    //     }
    //     $model = new CreateDepartureForm();
    //     $model->host_user_id =  $safari_operator->id;
    //     $model->type = 2;

    //     if ($safari_operator->category_id == 1) {
    //         $model->host_type = 3;
    //     } elseif ($safari_operator->category_id == 2) {
    //         $model->host_type = 2;
    //     } else {
    //         $model->host_type = $this->userinfo->account_type;
    //     }

    //     $model->status = ShareSafari::STATUS_SUSPEND;
    //     $model->rand_text = substr(sha1(mt_rand()), 17, 6) . '-' . $model->host_user_id . time();
    //     $model->attributes = $this->request;
    //     if ($model->validate()) {
    //         $model->initializeForm();
    //         if ($model->shared_safari_departure_model->save()) {
    //             $parks = $model->park_list;
    //             if ($parks) {
    //                 foreach ($parks as $park) {
    //                     $park_model = new ShareSafariParklist();
    //                     $park_model->share_safari_id = $model->shared_safari_departure_model->id;
    //                     $park_model->park_id = $park;
    //                     $park_model->save(false);
    //                 }
    //             }

    //             $to_mail = Yii::$app->params['adminEmail'];
    //             $subject = 'New Fixed Departure | ' . substr($model->shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
    //             $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_OPERATOR_CREATED_NEW_FIXEDDEPARTURE;
    //             $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_departure_model->slug, 'organized_slug' => $model->shared_safari_departure_model->organizedslug ? $model->shared_safari_departure_model->organizedslug : '']);
    //             $req = ['shared_safari' => $model->shared_safari_departure_model->attributes, 'operator_name' => $safari_operator->business_name, 'shared_safari_url' => $shared_safari_url];
    //             $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //             if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
    //                 GeneralModel::sendmailfromlog($maillog_data['log_id']);
    //             }

    //             return Yii::$app->api->sendResponse($data = [$model->shared_safari_model->attributes], ['message' => "Shared safari created successfully"]);
    //         }
    //     }
    //     return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    // }


    public function actionComment($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        $model = new ShareSafariCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($share_safari)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
        }

        return Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }


    public function actionReply($slug, $parent_id)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();

        $replymodel = new ReplyForm();
        $replymodel->parent_id = $parent_id;

        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($share_safari)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }


        return Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }

    public function actionFlag($slug, $park_id, $share_safari_comment_id)
    {
        $share_safari = ShareSafari::find()->where(['slug' => $slug])->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        $comments = ShareSafariComment::find()->where(['id' => $share_safari_comment_id])->limit(1)->one();

        $model = new ShareSafariCommentReportForm();
        $model->share_safari_id = $share_safari->id;
        $model->park_id = $park_id;
        $model->share_safari_comment_id = $share_safari_comment_id;

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->flag_model->save(false)) {
                $comments->flaged = 1;
                $comments->save(false);
                /*Send Email*/
                $to_mail = Yii::$app->params['adminEmail'];
                $subject = 'Flag Raised | Shared Safari : ' . substr($share_safari->share_safari_title, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                $req = ['comment' => $comments->comment, 'report_details' => $model->flag_model->report_detail, 'username' => isset(Yii::$app->user->identity) ? Yii::$app->user->identity->name : ''];
                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                }

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reported successfully!"]);
            }
        }
    }
}
