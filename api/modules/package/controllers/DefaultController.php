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
                'only' => ['comment', 'reply', 'wishlist', 'unwishlist', 'package-quote', 'flag', 'quotation'],
                'rules' => [
                    [
                        'actions' => ['comment', 'reply', 'wishlist', 'unwishlist', 'package-quote', 'flag', 'quotation'],
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
                    'quotation' => ['POST'],
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

    public function actionView($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PACKAGE_API_LAYOUT_FULL;
        $package = Package::find()->where(['package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }

        if ($package->status != Package::STATUS_ACTIVE) {
            return Yii::$app->api->sendResponse($data = ['data' => $package], ['message' => "Package is not in use!!!"]);
        }

        return Yii::$app->api->sendResponse($data = ['data' => $package]);
    }




    public function actionComment($slug)
    {

        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        $model = new PackageCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($package)) {

            if ($this->userinfo) {
                /**login User info */
                $user = $this->userinfo;
                $username = $user->name;
                /**Mail sent to package owner */
                $to_mail = $package->user->username;
                /**subject of mail */
                $subject = 'New Comment : Package | ' . substr($package->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                $creator_name = $package->user->name;
                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_PACKAGE_COMMENT_BY_USER;
                /**Package Url */
                $package_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
                $req = ['username' => $username, 'package_url' => $package_url, 'creator_name' => $creator_name, 'package' => $package->attributes];
                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                }
                FrontendNotificationHelper::packageNewComment($package, $this->userinfo);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }


    public function actionReply($slug, $parent_id)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        if ($this->userinfo && isset($package->partner) && $package->owned_by_id != $package->partner->id) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot Reply!!!"]);
        }

        $replymodel = new PackageReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($package)) {

                $reply_comment = $replymodel->commentbyParent();
                if ($reply_comment) {
                    if ($this->userinfo) {
                        $user = $this->userinfo;
                        $username = $user->name;
                        $to_mail = $package->user->username;
                        $subject = 'New Reply : Package | ' . substr($package->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        $creator_name = $package->user->name;
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_PACKAGE_REPLY_BY_USER;
                        $package_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
                        $req = ['username' => $username, 'package_url' => $package_url, 'creator_name' => $creator_name, 'package' => $package->attributes];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }
                        // FrontendNotificationHelper::packageCommentReply($package, $reply_comment->user);
                    }
                }

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    public function actionWishlist($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }

        if ($this->userinfo) {
            if ($this->userinfo->partner) {
                return Yii::$app->api->sendResponse($data = [], ['message' => "You are not allowed to do this!!!"]);
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
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You added Package to wishlist!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    public function actionUnwishlist($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }

        if ($this->userinfo) {
            if ($this->userinfo->partner) {
                return Yii::$app->api->sendResponse($data = [], ['message' => "You are not allowed to do this!!!"]);
            }
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
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        if ($this->userinfo && isset($package->partner) && $this->userinfoId == $package->partner->user_id) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot quote yourself!!!"]);
        }
        $packagemodel = new PackageQuoteForm();
        $packagemodel->attributes = $this->request;
        if ($packagemodel->validate()) {
            if ($packagemodel->request($package->id)) {
                // FirebaseNotificationHelper::packageintrest($package, $this->userinfo);
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Quote requested successfully submitted"]);
            }
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Quote requested not submitted"]);
        }
        return Yii::$app->api->sendFailedStringResponse($packagemodel->firstErrors, 400);
    }


    public function actionFlag($slug, $package_comment_id)
    {
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
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

                $to_mail = Yii::$app->params['adminEmail'];
                $subject = 'Flag Raised | Package : ' . substr($package->package_name, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                $req = ['comment' => $comments->comment, 'report_details' => $model->flag_model->report_detail, 'username' => isset($this->userInfo) ? $this->userInfo->name : ''];
                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                }
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
        $package = Package::find()->where(['package_slug' => $slug])->andWhere(['status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
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
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }


        $packageSafariPark = PackageSafariPark::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'package_id' => $package->id])
            ->all();
        if (!$packageSafariPark) {
            return Yii::$app->api->sendResponse([], ['message' => "Park Not Found!!!"]);
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
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
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
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
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
