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
use common\models\leads\form\ParkLeadForm;
use common\models\suggestions\form\SafariSuggestionsForm;
use frontend\models\OperatorQuoteForm;
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
                'exclude' => ['index', 'view', 'filter-parklist', 'reviewlist', 'park-operator', 'park-shared-safari', 'park-package', 'park-stay-category'],
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

                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
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


    public function actionFilterParklist()
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;

        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        $condition = ['template_code' => 1];
        return $this->dataProviderSenderConditionWithoutPagination($searchModel, "parks", $condition);
        // return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "parks");
    }

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
            }
        }

        if (count($sf->operator) < 1) {
            $message = Yii::$app->api->messageManager->getMessage('park.quote_request.no_verified_operators');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        // return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        $message = Yii::$app->api->messageManager->getMessage('park.quote_request.request_sent');
        return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
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
}
