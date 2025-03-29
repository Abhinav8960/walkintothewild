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
use api\models\park\SafariPark;
use api\models\park\SafariParkSearch;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;
use api\models\UserFollow;
use common\Helper\FirebaseNotificationHelper;
use common\Helper\FrontendNotificationHelper;
use common\interfaces\NewStatusInterface;
use common\models\GeneralModel;
use common\models\MailLog;
use frontend\models\OperatorQuoteForm;
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
                'exclude' => ['index', 'view', 'reviewlist', 'operator-park', 'user-rating-parklist', 'operator-shared-safari', 'operator-packages'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['follow', 'unfollow', 'quotesrequest', 'review', 'reviewupdate', 'flag'],
                'rules' => [
                    [
                        'actions' => ['follow', 'unfollow', 'quotesrequest', 'review', 'reviewupdate', 'flag'],
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
                    'flag' => ['POST']
                ],
            ],
        ];
    }

    public function actionView($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::OPERATOR_API_LAYOUT_FULL;
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
        }
        $searchModel = new SafariOperatorSearch();
        $searchModel->id = $operator->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
        // return $this->dataSender($operator, $rootIndexName = "Operator");
    }


    public function actionQuotesrequest($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
        }
        if ($this->userinfo && $this->userinfoId == $operator->user_id) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot quote yourself!!!"]);
        }
        $model = new OperatorQuoteForm();
        if ($this->userinfo) {
            $model->email = $this->userinfo->email;
            $model->full_name = $this->userinfo->name;
            $model->phone_no = $this->userinfo->mobile_no;
        }
        $model->attributes = $this->request;
        if ($model->validate()) {
            if ($operator_quote = $model->request($operator)) {
                FirebaseNotificationHelper::operatorquoterequest($operator, $this->userinfo);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Quote request sent!']);
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionFollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Operator not Found']);
        }
        if ($this->userinfo) {
            if ($this->userinfoId == $operator->user_id) {
                return Yii::$app->api->sendResponse($data = [], ['message' => "You can't follow yourself!"]);
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
                Yii::$app->session->setFlash('success', 'You are start following ' . $operator->business_name);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'You are start following']);
            } else {
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'You can not follow this operator currently!']);
            }
        }
    }

    public function actionUnfollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Operator not Found']);
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
                Yii::$app->session->setFlash('success', 'You unfollowed ' . $operator->business_name);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'You unfollowed']);
            } else {
                Yii::$app->session->setFlash('success', 'You can not unfollow this operator currently!');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'You cannot unfollowed']);
            }
        }
    }

    public function actionReviewlist($slug, $sort_by = null)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
        }

        $ratingsearchModel = new SafariOperatorRatingSearch();
        $ratingsearchModel->custom_sort_by = $sort_by;
        $ratingsearchModel->safari_operator_id = $operator->id;
        $ratingsearchModel->is_deleted = 0;
        $ratingsearchModel->status = 1;

        // $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->all();
        return $this->dataProviderSender($ratingsearchModel, $rootIndexName = "reviews");
    }


    public function actionReview($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
        }
        $same_operator = SafariOperator::find()->where(['user_id' => $this->userinfo ? $this->userinfoId : null, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();
        if ($same_operator == $operator->id) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Not Rate Yourself!!!"]);
        }

        $model = new SafariOperatorReviewForm();
        $model->safari_operator_id = $operator->id;
        $model->user_id = $this->userinfoId;


        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->rating_model->save(false)) {
                $model->updateRatingintoTable($operator);
                /**Mail to operator */

                // $operator_name = $operator->business_name;
                // /**Operator Mail Info */
                // $to_mail = $operator->user->username;

                // /**Template info */
                // $subject = 'New Review';
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_REVIEW_TO_OPERATOR;
                // /**Url Info */
                // $operator_url = Yii::$app->urlManager->createAbsoluteUrl([
                //     '/operator/default/reviewlist',
                //     'slug' => $operator->slug
                // ]);
                // $req = ['operator_name' => $operator_name, 'operator_url' => $operator_url];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }
                FirebaseNotificationHelper::newreview($operator, $this->userinfo);
                FrontendNotificationHelper::operatorNewReview($operator, $model->rating_model,  $this->userinfo);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Thanks for review!!']);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Not Submitted successfully']);
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

    public function actionUserRatingParklist($slug)
    {
        $this->layout = NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse([], ['message' => "Operator Not Found!!!"]);
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
            return Yii::$app->api->sendResponse([], ['message' => "Operator Not Found!!!"]);
        }
        $searchModel = new ShareSafariSearch();
        $searchModel->host_user_id = $operator->id;
        $searchModel->type = ShareSafari::TYPE_FIXED_DEPARTURE;
        $searchModel->status = ShareSafari::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "sharedsafari");
        // return Yii::$app->api->sendResponse($data = ['operatorsharedsafari' => $this->serializeData($operator->sharedsafari)]);
    }

    public function actionOperatorPark($slug)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse([], ['message' => "Operator Not Found!!!"]);
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
            return Yii::$app->api->sendResponse([], ['message' => "Operator Not Found!!!"]);
        }

        $searchModel = new PackageSearch();
        $searchModel->owned_by_id = $operator->id;
        $searchModel->status = Package::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, "packages");
        // return Yii::$app->api->sendResponse($data = ['operatorpackage' => $this->serializeData($operator->packages)]);
    }

    public function actionReviewupdate($slug, $id)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse([], ['message' => "Operator Not Found!!!"]);
        }
        $rating_model = SafariOperatorRating::find()->where(['user_id' => $this->userinfoId, 'safari_operator_id' => $operator->id, 'id' => $id])->one();
        $model = new SafariOperatorReviewForm($rating_model);

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->rating_model->save(false)) {
                $model->updateRatingintoTable($operator);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Thanks for edit review!!']);
            }
        }
    }


    public function actionFlag($slug, $id)
    {
        $operator = SafariOperator::find()
            ->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])
            ->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse([], ['message' => "Operator Not Found!!!"]);
        }
        $rating = SafariOperatorRating::find()->where(['id' => $id])->limit(1)->one();

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
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Review reported successfully!']);
            }
        }
    }
}
