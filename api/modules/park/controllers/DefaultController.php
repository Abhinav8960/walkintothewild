<?php

namespace api\modules\park\controllers;

use api\behaviours\Apiauth;
use api\controllers\RestController;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafari;
use api\behaviours\Verbcheck;
use api\models\operator\SafariOperatorSearch;
use api\models\package\Package;
use api\models\package\PackageSafariPark;
use api\models\package\PackageSearch;
use api\models\park\SafariParkRating;
use api\models\park\SafariParkRatingSearch;
use api\models\park\SafariParkSearch;
use api\models\sharesafari\ShareSafariSearch;
use api\models\suggestions\SafariSuggestions;
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
                'exclude' => ['index', 'view', 'filter-parklist', 'reviewlist', 'park-operator', 'park-shared-safari', 'park-package'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['suggestion'],
                'rules' => [
                    [
                        'actions' => ['suggestion'],
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

        return $this->dataProviderSender($searchModel, $rootIndexName = "SafariPark");
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {

        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FULL;
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $searchModel = new SafariParkSearch();

        $searchModel->id = $model->id; // for show Selected Park name in search
        $searchModel->is_single = true; // for show Selected Park name in search

        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    }


    public function actionFilterParklist()
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;

        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        // $searchModel->show_in_filter = 1;
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "SafariPark");
    }

    public function actionReviewlist($slug, $sort_by = null)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Park Not Found!!!"]);
        }

        // $my_review = SafariParkRating::find()->where(['safari_park_id' => $model->id, 'user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->one();

        $searchModel = new SafariParkRatingSearch();
        $searchModel->safari_park_id = $model->id;
        $searchModel->status = 1;
        $searchModel->custom_sort_by = $sort_by;

        return $this->dataProviderSender($searchModel, $rootIndexName = "Review");
    }


    public function actionSuggestion($slug)
    {
        $safari_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$safari_park) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Park Not Found!!!"]);
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
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Suggestion Submitted Successfully"]);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Suggestion Not Submitted"]);
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionReview($slug)
    {
        $safari_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$safari_park) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Park Not Found!!!"]);
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
                    $model->updateRatingintoTable($safari_park);
                    Yii::$app->session->setFlash('success', 'Thanks for Review! Your review sent for approval');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Thanks for Review! Your review sent for approval"]);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Your review not sent for approval"]);
            }
            return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        } else {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Review Already submitted"]);
        }
    }

    public function actionParkOperator($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;
      

        return $this->dataProviderSender($operatorsearchModel, $rootIndexName = "ParkOperator", $additionalSearchQueryParams = [$parl_id=$model->id]);
    }

    public function actionParkSharedSafari($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Park Not Found!!!"]);
        }

        $searchModel = new ShareSafariSearch();
        $searchModel->park_id = $model->id;
        $searchModel->status = ShareSafari::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "parksharedsafari");
    }

    public function actionParkPackage($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Park Not Found!!!"]);
        }

        $safaripackages = PackageSafariPark::find()->where(['park_id' => $model->id, 'status' => 1])->all();
        $packageIds = array_column($safaripackages, 'package_id');
        $searchModel = new PackageSearch();
        $searchModel->id = $packageIds;
        $searchModel->status = Package::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, "parkpackage");
    }
}
