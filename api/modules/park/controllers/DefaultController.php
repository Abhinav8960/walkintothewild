<?php

namespace api\modules\park\controllers;

use api\behaviours\Apiauth;
use api\controllers\RestController;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafari;
use api\behaviours\Verbcheck;
use api\models\operator\SafariOperatorSearch;
use api\models\park\SafariParkRating;
use api\models\park\SafariParkRatingSearch;
use api\models\park\SafariParkSearch;
use api\models\suggestions\SafariSuggestions;
use common\models\suggestions\form\SafariSuggestionsForm;
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
                'exclude' => ['index', 'view', 'filter-parklist', 'reviewlist'],
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
                    'suggestion' => ['POST']

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
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            // return $this->redirect(['/park']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $searchModel = new SafariParkSearch();

        $searchModel->id = $model->id; // for show Selected Park name in search

        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    }


    public function actionFilterParklist()
    {
        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        $searchModel->show_in_filter = 1;
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
}