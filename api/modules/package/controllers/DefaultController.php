<?php

namespace api\modules\package\controllers;

use api\behaviours\Apiauth;
use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\operator\SafariOperator;
use api\models\package\Package;
use api\models\package\PackageComment;
use api\models\package\PackageSearch;
use api\models\UserWishlist;
use common\Helper\FirebaseNotificationHelper;
use common\Helper\FrontendNotificationHelper;
use common\models\GeneralModel;
use common\models\MailLog;
use frontend\models\PackageCommentForm;
use frontend\models\PackageCommentReportForm;
use frontend\models\PackageQuoteForm;
use frontend\models\PackageReplyForm;
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
                    'package-faqs' => ['GET'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $searchModel->status = Package::STATUS_ACTIVE;
        $searchModel->custom_sort_by = 5;
        $condition = "owned_by_id IN (SELECT id from safari_operator WHERE status=1)";

        return $this->dataProviderSenderWithCondition($searchModel, $rootIndexName = "Packages", $condition);
    }


    public function actionView($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        $searchModel = new PackageSearch();
        $searchModel->id = $package->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    }





    public function actionComment($slug)
    {

        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        $model = new PackageCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($package)) {

            if ($this->userinfo) {
                /**login User info */
                // $user = $this->userinfo;
                // $username = $user->name;
                // /**Mail sent to package owner */
                // $to_mail = $package->user->username;
                // /**subject of mail */
                // $subject = 'New Comment : Package | ' . substr($package->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                // $creator_name = $package->user->name;
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_PACKAGE_COMMENT_BY_USER;
                // /**Package Url */
                // $package_url = Yii::$app->urlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
                // $req = ['username' => $username, 'package_url' => $package_url, 'creator_name' => $creator_name, 'package' => $package->attributes];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }
                FrontendNotificationHelper::packageNewComment($package, $this->userinfo);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }


    public function actionReply($slug, $parent_id)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }

        $replymodel = new PackageReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($package)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    public function actionWishlist($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
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
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You added Package to wishlist!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    public function actionUnwishlist($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        if ($package) {
            $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
            if ($wishlist) {
                $wishlist->status = 0;
                if ($wishlist->save(false)) {
                    return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You removed Package to wishlist!"]);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not removed Package from wishlist!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    public function actionPackageQuote($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        if ($this->userinfo && isset($package->safarioperator) && $this->userinfoId == $package->safarioperator->user_id) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot quote yourself!!!"]);
        }
        $packagemodel = new PackageQuoteForm();
        $packagemodel->attributes = $this->request;
        if ($packagemodel->validate()) {
            if ($packagemodel->request($package->id)) {
                FirebaseNotificationHelper::packageintrest($package, $this->userinfo);
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Quote requested successfully submitted"]);
            }
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Quote requested not submitted"]);
        }
        return Yii::$app->api->sendFailedStringResponse($packagemodel->firstErrors, 400);
    }


    public function actionFlag($slug, $package_comment_id)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }


        $comments = PackageComment::find()->where(['id' => $package_comment_id])->limit(1)->one();
        if ($comments->user_id == $this->userinfoId) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot flag your comment/reply yourself!!!"]);
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
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment/Reply reported successfully!"]);
            }
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Comment/Reply not reported!"]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionStaycategory()
    {
        $data = GeneralModel::budgetoption();
        return Yii::$app->api->sendResponse(array_map(function ($value, $key) {
            return ['id' => $key, 'name' => $value];
        }, $data, array_keys($data)));
    }


    public function actionCommentView($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        $comment_list = PackageComment::find()->where(['package_id' => $package->id, 'status' => 1])->andWhere(['parent_id' => null])->all();
        return  Yii::$app->api->sendResponse($data = ['comments' => $comment_list]);
    }

    public function actionPackagePark($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        return Yii::$app->api->sendResponse($data = ['parks' => $this->serializeData($package->packagepark)]);
    }

    public function actionPackageDays($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        return Yii::$app->api->sendResponse($data = ['days' => $this->serializeData($package->packagedays)]);
    }

    public function actionPackageFaqs($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        return Yii::$app->api->sendResponse($data = ['faqs' => $this->serializeData($package->faqs)]);
    }
}
