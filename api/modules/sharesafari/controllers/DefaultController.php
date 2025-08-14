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
use yii\filters\AccessControl;
use api\behaviours\Apiauth;
use api\models\cms\flagreason\Flagreason;
use api\models\sharesafari\form\SharedSafariForm;
use api\models\sharesafari\ShareSafariComment;
use api\models\sharesafari\ShareSafariHistory;
use api\models\sharesafari\ShareSafariIntrested;
use api\models\User;
use common\Helper\FirebaseNotificationHelper;
use common\models\firebasenotification\FirebaseNotificationLog;
// use api\models\UserWishlist;
use common\models\UserWishlist;
use frontend\models\ReplyForm;
use frontend\models\ShareSafariCommentForm;
use frontend\models\ShareSafariCommentReportForm;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

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
                'exclude' => ['index', 'view', 'flagreason', 'comment-view', 'intrest-user', 'fixed-departure-includes', 'fixed-departure-days', 'fixed-departure-gallery', 'fixed-departure-faqs', 'intrested-user', 'might-intrested', 'share-safari-history'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['organize-safari', 'join', 'unjoin', 'wishlist', 'unwishlist', 'comment', 'flag', 'update'],
                'rules' => [
                    [
                        'actions' => ['organize-safari', 'comment', 'wishlist', 'unwishlist', 'flag', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['unjoin', 'join'],
                        'allow' => $this->isSafariHost(),
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
                    'update' => ['POST'],
                    'join' => ['POST'],
                    'unjoin' => ['POST'],
                    'wishlist' => ['POST'],
                    'unwishlist' => ['POST'],
                    'flagreason' => ['GET'],
                    'comment-view' => ['GET'],
                    'intrested-user' => ['GET'],
                    /**FD */
                    'fixed-departure-includes' => ['GET'],
                    'fixed-departure-days' => ['GET'],
                    'fixed-departure-gallery' => ['GET'],
                    'fixed-departure-faqs' => ["GET"],
                    'might-intrested' => ['GET'],
                    'share-safari-history' => ['GET']

                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        return $this->dataProviderSender($searchModel, $rootIndexName = "share_safari");
    }


    // public function actionView($slug)
    // {
    //     $this->layout = \common\interfaces\NewStatusInterface::SHARE_SAFARI_API_LAYOUT_FULL;
    //     $share_safari = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
    //     if (!$share_safari) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
    //     }

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => ShareSafari::find()->where(['slug' => $slug]),
    //     ]);
    //     return $this->querySender($dataProvider, $rootIndexName = 0, $singleRecord = true);
    // }

    public function actionView($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::SHARE_SAFARI_API_LAYOUT_FULL;
        $share_safari = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Share Safari Not Found!!!"]);
        }

        if (!in_array($share_safari->status, [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT])) {
            return Yii::$app->api->sendResponse($data = ['data' => $share_safari->toArray()], ['message' => "Share Safari is not in use!!!"]);
        }

        if ($share_safari->start_date < date('Y-m-d')) {
            return Yii::$app->api->sendResponse($data = ['data' => $share_safari->toArray()], ['message' => "Share Safari Expired!!!"]);
        }

        return Yii::$app->api->sendResponse($data = ['data' => $share_safari->toArray()]);
    }

    public function actionOrganizeSafari()
    {
        if ($this->userinfo->is_mobile_no_verified == 0) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You are not allow do peform this action untill you verify mobile no!"], 403);
        }

        $operator = SafariOperator::find()->where(['user_id' => $this->userinfo ? $this->userinfoId : null])->limit(1)->one();

        if ($operator) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Operator can not create Shared safari!"]);
        }

        // if ($operator && $operator->status <> SafariOperator::STATUS_ACTIVE) {
        //     return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Operator is deactivate can not create Shared safari!"]);
        // }
        $model = new SharedSafariForm();
        $model->host_user_id = $this->userinfoId;
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->type = ShareSafari::TYPE_SAFARI;
        $model->host_type = 1;
        $model->version = 1;


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
        $model->shared_safari_image = UploadedFile::getInstanceByName('shared_safari_image');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_model->save()) {
                $model->shared_safari_model->savehistory();
                $model->UploadFiles($model->shared_safari_model->id);
                // if ($model->shared_safari_model->user) {
                //     /**User Info Who created safari */
                //     $user = $model->shared_safari_model->user;
                //     $username = $user->name;
                //     /**Sent to admin */
                //     $to_mail = Yii::$app->params['adminEmail'];
                //     $subject = 'New Shared Safari | ' . substr($model->shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                //     $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_CREATEDBY_USER;
                //     /**Url of shared Safari */
                //     $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_model->slug, 'organized_slug' => $model->shared_safari_model->organizedslug ? $model->shared_safari_model->organizedslug : '']);

                //     $req = ['shared_safari' => $model->shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                //     $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                //     if (!empty($maillog_data['log_id'])) {
                //         GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //     }
                // }

                // if ($active_followers = $model->shared_safari_model->sharesafarifollowerlist) {
                //     foreach ($active_followers as $follower) {
                //         /** Creator Info */
                //         $creator_name = $model->shared_safari_model->organizedbyname;
                //         /**User Info */
                //         $to_mail = $follower->user->username;
                //         /**Template info */
                //         $subject = 'New Shared Safari | ' . substr($model->shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                //         $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_TO_FOLLOWER;
                //         /**Url Info */
                //         $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_model->slug, 'organized_slug' => $model->shared_safari_model->organizedslug ? $model->shared_safari_model->organizedslug : '']);
                //         $req = ['shared_safari' => $model->shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'creator_name' => $creator_name];
                //         $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                //         if (!empty($maillog_data['log_id'])) {
                //             GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //         }
                //     }
                // }
                // if($model->shared_safari_model->getsharesafarifollowerlist() != null){
                // $active_followers = $model->shared_safari_model->getsharesafarifollowerlist()->asArray()->all();
                // if (!empty($active_followers)) {
                //     new \common\events\sharesafari\NewSafariCreatedByUser(
                //         $active_followers,
                //         $this->userinfoId,
                //         $model->shared_safari_model->user->name,
                //         $model->shared_safari_model->user->email,
                //         $model->shared_safari_model->id
                //     );
                //     }
                // }
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Shared safari created successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Shared safari not created successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionJoin($slug)
    {

        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        if ($this->userinfo) {
            if ($this->userinfo->partner) {
                return Yii::$app->api->sendResponse($data = [], ['message' => "Only individual users are allowed to join a shared safari. Tour operators cannot participate in shared safaris."]);
            }
            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
            if (!$share_safari_intrested) {
                $share_safari_intrested = new ShareSafariIntrested();
            }
            // return  new \common\events\sharesafari\SafariJoinedByuser($share_safari_intrested->user->name,$share_safari_intrested->sharesafari->id);

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
                /* Login User Info */
                $user = $this->userinfo;
                $username = $user->name;
                /*Creator Info*/
                // if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                //     $to_mail = $share_safari->user->username;
                // } else {
                //     $to_mail = $share_safari->partner->user->username;
                // }
                // $creator_name = $share_safari->organizedbyname;
                // $subject = 'New Member Alert: Shared Safari | ' . substr($share_safari->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_TO_HOST_JOIN_SAFARI;
                // $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                // $req = ['username' => $username, 'creator_name' => $creator_name, 'shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }

                // FirebaseNotificationHelper::sharedSafariJoin($share_safari, $this->userinfo);
                // FrontendNotificationHelper::sharedSafariJoin($share_safari, $this->userinfo);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You joined this shared safari!"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not Joined!"]);
        }
    }


    public function actionUnjoin($slug)
    {



        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
        if ($this->userinfo->partner) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Only individual users are allowed to unjoin a shared safari. Tour operators cannot participate in shared safaris."]);
        }



        // return  new \common\events\sharesafari\SafariUnjoinedByuser($share_safari_intrested->user->name,$share_safari_intrested->sharesafari->id);

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
            $share_safari_intrested->user_id = $this->userinfoId;
            $share_safari_intrested->status = 0; //UNfollow
            $share_safari_intrested->unintrested_at = time();
            if ($share_safari_intrested->save(false)) {
                FrontendNotificationHelper::sharedSafariLeave($share_safari, $this->userinfo);
                return   Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You unjoined this shared safari!"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not unjoined!"]);
        }
    }


    public function actionWishlist($slug)
    {

        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        if ($this->userinfo && $this->userinfo->partner) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not allowed to perform this!!!"]);
        }

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

    public function actionUnwishlist($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        if ($this->userinfo && $this->userinfo->partner) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not allowed to perform this!!!"]);
        }

        $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI])->one();
        if ($wishlist) {
            $wishlist->status = 0;
            if ($wishlist->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You removed share safari from wishlist!"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not removed share safari from wishlist!"]);
        }
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
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        if ($this->userinfo) {
            if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                if ($this->userinfo->partner) {
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are Operator You can't comment on this safari!!!"]);
                }
            }

            if ($share_safari->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
                if ($this->userinfo->partner) {
                    if ($this->userinfo->partner->id != $share_safari->host_user_id) {
                        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are Operator You can't comment on this safari!!!"]);
                    }
                } else {
                    $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
                    if (!$share_safari_intrested) {
                        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You can not join this safari!!!"]);
                    }
                }
            }

            if ($share_safari->type == ShareSafari::TYPE_SAFARI && $share_safari->host_user_id != $this->userinfoId) {
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
                if (!$share_safari_intrested) {
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You can not join this safari!!!"]);
                }
            }
        }

        $model = new ShareSafariCommentForm();
        $model->version = $share_safari->version;
        $model->attributes = $this->request;
        if ($model->validate()) {
            /**To Creator */
            if ($comment = $model->comment($share_safari)) {
                // FirebaseNotificationHelper::safaricommentorreply($share_safari, $this->userinfo);
                /**To All Join */
                // FirebaseNotificationHelper::safaricommentintrested($share_safari, $this->userinfo);
                // $user = User :: find()->where(['status'=>10])->andWhere(['id'=>Yii::$app->user->id])->one();
                // return new  \common\events\sharesafari\SafariCommentReplyByUser($user->name,$this->sharesafari->id);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
            }
        }

        return Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }


    public function actionReply($slug, $parent_id)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(1)->one();

        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        if ($this->userinfo) {
            if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                if ($this->userinfo->partner) {
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are Operator You can't reply on this safari!!!"]);
                }
            }

            if ($share_safari->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
                if ($this->userinfo->partner) {
                    if ($this->userinfo->partner->id != $share_safari->host_user_id) {
                        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are Operator You can't reply on this safari!!!"]);
                    }
                } else {
                    $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
                    if (!$share_safari_intrested) {
                        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You can not join this safari!!!"]);
                    }
                }
            }

            if ($share_safari->type == ShareSafari::TYPE_SAFARI && $share_safari->host_user_id != $this->userinfoId) {
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->limit(1)->one();
                if (!$share_safari_intrested) {
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You can not join this safari!!!"]);
                }
            }
        }

        $replymodel = new ReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->version = $share_safari->version;

        $replymodel->attributes = $this->request;
        $on_comment = ShareSafariComment::find()->where(['id' => $parent_id])->limit(1)->one();

        if ($replymodel->validate()) {
            if ($reply = $replymodel->reply($share_safari)) {
                /* To Creator*/
                // if ($this->userinfo && $share_safari->host_user_id != $this->userinfoId) {
                //     $user = $this->userinfo;
                //     $username = $user->name;
                //     if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                //         $to_mail = $share_safari->user->username;
                //     } else {
                //         $to_mail = $share_safari->partner->user->username;
                //     }
                //     $creator_name = $share_safari->organizedbyname;
                //     $subject = 'New Reply : Shared Safari | ' . substr($share_safari->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                //     $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_COMMENT_REPLY_SAFARI;
                //     $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                //     $req = ['username' => $username, 'creator_name' => $creator_name, 'shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url];
                //     $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                //     if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //         GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //     }
                //     FrontendNotificationHelper::sharedSafariReply($share_safari);
                // }
                // /* Comment Owner*/
                // if ($this->userinfo && $on_comment && $to_comment_user = $on_comment->user) {
                //     $reply_user = $this->userinfo;
                //     $reply_username = $reply_user->name;
                //     $to_mail = $to_comment_user->username;
                //     $safari_creator_name = $share_safari->organizedbyname;
                //     $subject = 'New Reply';
                //     $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_REPLY_BY_USER_TO_COMMENTUSER;
                //     $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                //     $req = ['username' => $reply_username, 'creator_name' => $safari_creator_name, 'shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url];
                //     $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                //     if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //         GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //     }
                // }

                if ($reply) {
                    $replymodel->NotifyUser($reply, []);
                }

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }


        return Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }

    public function actionFlag($slug, $share_safari_comment_id)
    {
        $share_safari = ShareSafari::find()->where(['slug' => $slug])->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
        }

        $comments = ShareSafariComment::find()->where(['id' => $share_safari_comment_id])->limit(1)->one();
        if ($comments->user_id == $this->userinfoId) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot flag your comment/reply yourself!!!"]);
        }

        $model = new ShareSafariCommentReportForm();
        $model->share_safari_id = $share_safari->id;
        $model->park_id = $share_safari->park_id;
        $model->share_safari_comment_id = $share_safari_comment_id;

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->flag_model->save(false)) {
                $comments->flaged = 1;
                $comments->save(false);
                /*Send Email*/
                // $to_mail = Yii::$app->params['adminEmail'];
                // $subject = 'Flag Raised | Shared Safari : ' . substr($share_safari->share_safari_title, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                // $req = ['comment' => $comments->comment, 'report_details' => $model->flag_model->report_detail, 'username' => isset($this->userinfo) ? $this->userinfo->name : ''];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reported successfully!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionFlagreason()
    {
        $reasons = Flagreason::find()->where(['status' => Flagreason::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->all();
        if ($reasons) {
            // Converts an array of objects to an array of arrays
            // This will include all public properties, or properties defined by attributes() method
            $formattedReasons = ArrayHelper::toArray($reasons);
            return Yii::$app->api->sendResponse($data = $formattedReasons);
        }

        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not found !!!"]);
    }

    public function actionCommentView($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        // $commentlist = ShareSafariComment::find()->where(['share_safari_id' => $share_safari->id, 'status' => 1])->andWhere(['parent_id' => null])->all();



        $dataProvider = new ActiveDataProvider([
            'query' => ShareSafariComment::find()->where(['share_safari_id' => $share_safari->id, 'status' => 1, 'parent_id' => null]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "comments");
    }

    /**
     * Fixed departure breaking has Many
     */
    public function actionFixedDepartureIncludes($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        if ($share_safari && $share_safari->type != ShareSafari::TYPE_FIXED_DEPARTURE) {
            return Yii::$app->api->sendResponse($data = [], ['message' => 'Includes not found']);
        }
        return Yii::$app->api->sendResponse($data = ['includes' => $this->serializeData($share_safari->includeds)]);
    }

    public function actionFixedDepartureDays($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        if ($share_safari && $share_safari->type != ShareSafari::TYPE_FIXED_DEPARTURE) {
            return Yii::$app->api->sendResponse($data = [], ['message' => 'Days not found']);
        }
        return Yii::$app->api->sendResponse($data = ['days' => $this->serializeData($share_safari->sharesafaridays)]);
    }

    public function actionFixedDepartureGallery($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        if ($share_safari && $share_safari->type != ShareSafari::TYPE_FIXED_DEPARTURE) {
            return Yii::$app->api->sendResponse($data = [], ['message' => 'Gallery not found']);
        }
        return Yii::$app->api->sendResponse($data = ['gallery' => $this->serializeData($share_safari->sharesafarigallery)]);
    }

    public function actionFixedDepartureFaqs($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        if ($share_safari && $share_safari->type != ShareSafari::TYPE_FIXED_DEPARTURE) {
            return Yii::$app->api->sendResponse($data = [], ['message' => 'Faqs not found']);
        }
        return Yii::$app->api->sendResponse($data = ['faqs' => $this->serializeData($share_safari->sharesafariFaqs)]);
    }


    // public function actionIntrestedUser($slug)
    // {
    //     $share_safari = ShareSafari::find()->where(['slug' => $slug, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->limit(1)->one();
    //     if (!$share_safari) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
    //     }

    //     $query = User::find()
    //         ->alias('u')
    //         ->innerJoin('share_safari_intrested ssi', 'ssi.user_id = u.id')
    //         ->where(['ssi.share_safari_id' => $share_safari->id, 'ssi.status' => 1, 'u.status' => User::STATUS_ACTIVE])
    //         ->select(['u.*', 'ssi.intrested_at'])
    //         ->orderBy(['ssi.intrested_at' => SORT_DESC]);

    //     $pageSize = Yii::$app->request->get('pageSize', 10);
    //     $page = Yii::$app->request->get('page', 1);

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //         'pagination' => [
    //             'pageSize' => $pageSize,
    //             'page' => $page - 1,
    //         ],
    //     ]);

    //     $users = [];
    //     foreach ($dataProvider->getModels() as $user) {
    //         $users[] = [
    //             // 'username' => $user->username,
    //             'name' => $user->name,
    //             // 'is_mobile_no_verified' => $user->is_mobile_no_verified,
    //             // 'email' => $user->email,
    //             // 'is_safari_operator' => $user->is_safari_operator,
    //             // 'user_handle' => $user->user_handle,
    //             // 'gender' => $user->gender,
    //             // 'account_type' => $user->account_type,
    //             // 'gender_privacy' => $user->gender_privacy,
    //             // 'email_privacy' => $user->email_privacy,
    //             // 'status' => $user->status,
    //             // 'profile_display_image' => $user->profile_display_image,
    //             // 'cover_display_image' => $user->cover_display_image,
    //             'display_name' => $user->display_name,
    //             // 'is_followed' => $user->is_followed,
    //             // 'user_activity_count' => $user->user_activity_count,
    //             'operator_slug' => $user->operator_slug,
    //             'intrested_at' => date('Y-m-d', $user->getAttribute('intrested_at')),
    //         ];
    //     }

    //     $pagination = $dataProvider->getPagination();

    //     return Yii::$app->api->sendResponse([
    //         'intrested_users' => [
    //             'summary' => [
    //                 'total' => $dataProvider->getTotalCount(),
    //                 'page' => $pagination->getPage() + 1,
    //                 'pageSize' => $pagination->getPageSize(),
    //                 'total_page' => $pagination->getPageCount(),
    //                 'query_params' => Yii::$app->request->queryParams,
    //             ],
    //             'data' => $users,
    //         ],
    //     ]);
    // }

    public function actionUpdate($slug)
    {
        $shared_safari_model = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
        if ($shared_safari_model->host_user_id != $this->userinfoId) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You cannot Update this safari!!!"]);
        }
        $model = new SharedSafariForm($shared_safari_model);
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->version = $shared_safari_model->version + 1;
        $model->attributes = $this->request;
        $model->shared_safari_image = UploadedFile::getInstanceByName('shared_safari_image');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_model->save(false)) {
                $model->shared_safari_model->savehistory();
                $model->UploadFiles($model->shared_safari_model->id);
                /* All Joined User*/
                $intrested_users = $shared_safari_model->getIntrested()->joinWith('user')->andWhere(['user.status' => 10, 'share_safari_intrested.status' => 1])->asArray()->all();
                // if ($intrested_users) {
                //     foreach ($intrested_users as $intrest) {
                //         $user = $intrest->user;
                //         $username = $user->name;
                //         $to_mail = $user->username;
                //         $creator_name = $shared_safari_model->organizedbyname;
                //         $subject = 'Update Shared Safari | ' . substr($shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                //         $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_UPDATE_SAFARI_CREATEDBY_USER;
                //         $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $shared_safari_model->slug, 'organized_slug' => $shared_safari_model->organizedslug ? $shared_safari_model->organizedslug : '']);
                //         $req = ['creator_name' => $creator_name, 'shared_safari' => $shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                //         $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                //         if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //             GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //         }
                //     }
                // }

                // FrontendNotificationHelper::sharedSafariUpdate($model->shared_safari_model);
                // print_r(json_encode($intrested_users));
                // die();
                if ($intrested_users) {
                    // new \common\events\sharesafari\SafariUpdatedByUser(
                    //     $intrested_users,
                    //     $this->userinfoId,
                    //     $model->shared_safari_model->user->name,
                    //     $model->shared_safari_model->user->email,
                    //     $model->shared_safari_model->id
                    // );
                }
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Shared safari updated successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Shared safari not updated successfully"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionMightIntrested()
    {
        $searchModel = new ShareSafariSearch();
        $queryParams = Yii::$app->request->queryParams;
        $searchModel->load($queryParams);

        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->pagination = false;
        $dataProvider->query->orderBy(new \yii\db\Expression('RAND()'))->limit(4);
        $data = [
            'share_safari' => [
                'data' => $this->serializeData($dataProvider->getModels()),
            ],
        ];

        return Yii::$app->api->sendResponse($data);
    }

    public function actionShareSafariHistory($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug, 'type' => 1])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari History Not found!"]);
        }

        $columns = $this->sharedsafaricolumn();

        $query = "SELECT id as current_id, updated_at as date, ";
        foreach ($columns as $column_data) {
            $query .= "
        " . $column_data['actual_column'] . " as " . $column_data['current_column'] . ", 
        lead(" . $column_data['actual_column'] . ") over() as " . $column_data['previous_column'] . ",
        ";
        }

        $query .= " row_number() over() as `row_number`
            FROM `share_safari_history` 
            WHERE `slug` = :slug AND `status` = 1 AND `type` = 1 
            ORDER BY `id` DESC;";

        $history_model = Yii::$app->db->createCommand($query)
            ->bindValue(':slug', $slug)
            ->queryAll();

        $filtered_history = [];
        $totalRows = count($history_model);

        foreach ($history_model as $index => $row) {
            $changes = [];
            $isLastRow = ($index === $totalRows - 1);
            $rowAction = null;

            foreach ($columns as $column_data) {
                $currentKey = $column_data['current_column'];
                $previousKey = $column_data['previous_column'];
                $currentValue = $row[$currentKey];
                $previousValue = $row[$previousKey];

                if ($isLastRow) {
                    if ($currentValue !== null) {
                        $changes[$currentKey] = [
                            'new' => $currentValue
                        ];
                        $rowAction = 'Created';
                    }
                } else {
                    if ($currentValue !== $previousValue) {
                        if ($previousValue === null) {
                            $changes[$currentKey] = [
                                'new' => $currentValue
                            ];
                            $rowAction = 'Created';
                        } else {
                            $changes[$currentKey] = [
                                'new' => $currentValue,
                                'old' => $previousValue
                            ];
                            $rowAction = 'Updated';
                        }
                    }
                }
            }

            if (!empty($changes)) {
                $filtered_history[] = [
                    'current_id' => $row['current_id'],
                    'date' => $row['date'],
                    'action' => $rowAction,
                    'changes' => $changes,
                ];
            }
        }

        return Yii::$app->api->sendResponse([
            'share_safari_history' => $filtered_history
        ]);
    }


    public function actionFixedHistory($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $slug, 'type' => 2, 'mail_sent' => 1])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Fixed History Not found!"]);
        }

        $columns = $this->fixeddeparturecolumn();
        $query = "SELECT id as current_id, updated_at as date, ";
        foreach ($columns as $column_data) {
            $query .= "
            " . $column_data['actual_column'] . " as " . $column_data['current_column'] . ", 
            lead(" . $column_data['actual_column'] . ") over() as " . $column_data['previous_column'] . ",
            ";
        }

        $query .= " row_number() over() as `row_number`
                    FROM `share_safari_history` WHERE `slug` = '$slug' AND `status` = 1 AND `type` = 2 AND `mail_sent` = 1 ORDER BY `id` DESC;";

        $history_model = Yii::$app->db->createCommand($query)
            ->queryAll();

        $filtered_history = [];
        $totalRows = count($history_model);

        foreach ($history_model as $index => $row) {
            $changes = [];
            $isLastRow = ($index === $totalRows - 1);
            $rowAction = null;

            foreach ($columns as $column_data) {
                $currentKey = $column_data['current_column'];
                $previousKey = $column_data['previous_column'];
                $currentValue = $row[$currentKey];
                $previousValue = $row[$previousKey];

                if ($isLastRow) {
                    if ($currentValue !== null) {
                        $changes[$currentKey] = [
                            'new' => $currentValue
                        ];
                        $rowAction = 'Created';
                    }
                } else {
                    if ($currentValue !== $previousValue) {
                        if ($previousValue === null) {
                            $changes[$currentKey] = [
                                'new' => $currentValue
                            ];
                            $rowAction = 'Created';
                        } else {
                            $changes[$currentKey] = [
                                'new' => $currentValue,
                                'old' => $previousValue
                            ];
                            $rowAction = 'Updated';
                        }
                    }
                }
            }

            if (!empty($changes)) {
                $filtered_history[] = [
                    'current_id' => $row['current_id'],
                    'date' => $row['date'],
                    'action' => $rowAction,
                    'changes' => $changes,
                ];
            }
        }

        return Yii::$app->api->sendResponse([
            'share_safari_history' => $filtered_history
        ]);
    }



    public function sharedsafaricolumn()
    {
        return [
            [
                'actual_column' => 'no_of_safari',
                'previous_column' => 'previous_no_of_safari',
                'current_column' => 'current_no_of_safari',
            ],
            [
                'actual_column' => 'share_seat',
                'previous_column' => 'previous_share_seat',
                'current_column' => 'current_share_seat',
            ],
            [
                'actual_column' => 'total_seat',
                'previous_column' => 'previous_total_seat',
                'current_column' => 'current_total_seat',
            ],
            [
                'actual_column' => 'estimate_price_min',
                'previous_column' => 'previous_estimate_price_min',
                'current_column' => 'current_estimate_price_min',
            ],
            [
                'actual_column' => 'estimate_price_max',
                'previous_column' => 'previous_estimate_price_max',
                'current_column' => 'current_estimate_price_max',
            ],
            [
                'actual_column' => 'start_date',
                'previous_column' => 'previous_start_date',
                'current_column' => 'current_start_date',
            ],
            [
                'actual_column' => 'end_date',
                'previous_column' => 'previous_end_date',
                'current_column' => 'current_end_date',
            ],
            [
                'actual_column' => 'share_safari_title',
                'previous_column' => 'previous_share_safari_title',
                'current_column' => 'current_share_safari_title',
            ],

        ];
    }

    public function fixeddeparturecolumn()
    {
        return [
            [
                'actual_column' => 'no_of_safari',
                'previous_column' => 'previous_no_of_safari',
                'current_column' => 'current_no_of_safari',
                'label' => 'Safari'
            ],
            [
                'actual_column' => 'share_seat',
                'previous_column' => 'previous_share_seat',
                'current_column' => 'current_share_seat',
                'label' => 'Share Seat'
            ],
            [
                'actual_column' => 'total_seat',
                'previous_column' => 'previous_total_seat',
                'current_column' => 'current_total_seat',
                'label' => 'Total Seat'
            ],
            [
                'actual_column' => 'cost_per_person',
                'previous_column' => 'previous_cost_per_person',
                'current_column' => 'current_cost_per_person',
                'label' => 'Estimate Price Min'
            ],
            [
                'actual_column' => 'start_date',
                'previous_column' => 'previous_start_date',
                'current_column' => 'current_start_date',
                'label' => 'Start Date'
            ],
            [
                'actual_column' => 'end_date',
                'previous_column' => 'previous_end_date',
                'current_column' => 'current_end_date',
                'label' => 'End Date'
            ],
            [
                'actual_column' => 'cut_off_date',
                'previous_column' => 'previous_cut_off_date',
                'current_column' => 'current_cut_off_date',
                'label' => 'Cut Off Date'
            ],
            // [
            //     'actual_column' => 'safari_plan',
            //     'previous_column' => 'previous_safari_plan',
            //     'current_column' => 'current_safari_plan',
            //     'label' => 'Safari Plan'
            // ],
            [
                'actual_column' => 'share_safari_terms_condtition',
                'previous_column' => 'previous_share_safari_terms_condtition',
                'current_column' => 'current_share_safari_terms_condtition',
                'label' => 'T & C'
            ],
            [
                'actual_column' => 'privacy_policy',
                'previous_column' => 'previous_privacy_policy',
                'current_column' => 'current_privacy_policy',
                'label' => 'Privacy Policy'
            ],
            [
                'actual_column' => 'change_policy',
                'previous_column' => 'previous_change_policy',
                'current_column' => 'current_change_policy',
                'label' => 'Change Policy'
            ],
            [
                'actual_column' => 'what_you_must_carry',
                'previous_column' => 'previous_what_you_must_carry',
                'current_column' => 'current_what_you_must_carry',
                'label' => 'Must Carry'
            ],
            [
                'actual_column' => 'date_change_policy',
                'previous_column' => 'previous_date_change_policy',
                'current_column' => 'current_date_change_policy',
                'label' => 'Date Change Policy'
            ],
            [
                'actual_column' => 'refund_policy',
                'previous_column' => 'previous_refund_policy',
                'current_column' => 'current_refund_policy',
                'label' => 'Refund Policy'
            ],
            [
                'actual_column' => 'getting_there',
                'previous_column' => 'previous_getting_there',
                'current_column' => 'current_getting_there',
                'label' => 'Getting There'
            ],
            [
                'actual_column' => 'share_safari_title',
                'previous_column' => 'previous_share_safari_title',
                'current_column' => 'current_share_safari_title',
                'label' => 'Safari Title'
            ],
        ];
    }

    public function actionIntrestedUser($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }

        $ShareSafariIntrested = ShareSafariIntrested::find()->where(['share_safari_id' => $share_safari->id])->andWhere(['share_safari_intrested.status' => 1])->joinWith('user')->andWhere(['user.status' => 10]);

        // $ids = array_column($ShareSafariIntrested, 'user_id');
        $dataProvider = new ActiveDataProvider([
            'query' => $ShareSafariIntrested,
            // 'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "intrested_users");
    }
}
